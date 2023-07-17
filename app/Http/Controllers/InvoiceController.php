<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    // Method to display user invoice page
    public function view() {
        $user_id = Auth::user()->id;

        $invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")->where('status', 'LIKE', "%pending%")->latest('id')
                    ->get();

        // Check if invoice is empty
        if ($invoice->isEmpty()) {
            // Redirect user back to shopping cart page
            return redirect('/cart');
        }

        $orders = Cart::where('user_id', 'LIKE', "%$user_id%")->get();

        // Function to format money
        Blade::directive('currency', function($amount) {
            return "Rp. <?php echo number_format($amount,0,',','.');?>";
        });

        $products = Product::all();

        return view('invoice', [
            'orders' => $orders,
            'products' => $products,
            'invoice' => $invoice[0]
        ]);
    }

    // Method for canceling invoice logic
    public function cancel_invoice($id) {
        // Store product stock back
        // Get user id
        $user_id = Auth::user()->id;

        // Fetch products from user shopping cart
        $orders = Cart::where('user_id', 'LIKE', "%$user_id%")->get();

        foreach($orders as $order) {
            $product = Product::find($order->product_id);

            $product->stock += $order->quantity;

            $product->save();

            $order->delete();
        }

        // Delete invoice
        $invoice = Invoice::find($id);

        $invoice->delete();

        // Redirect user to market
        return redirect()->intended('/');
    }

    // Method for submiting invoice logic
    public function submit_invoice($id) {
        // Save invoice as pdf
        $user_id = Auth::user()->id;
        $orders = Cart::where('user_id', 'LIKE', "%$user_id%")->get();

        $products = Product::all();

        $invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")->where('status', 'LIKE', "%pending%")->get();

        // Calculate subtotal
        $sub_total = 0;

        foreach($orders as $order) {
            $sub_total += $order->quantity * $products->find($order->product_id)->price;
        }

        // Caluclate vat due
        $vat_rate = 10/100;

        $vat_due = $vat_rate * $sub_total;

        // Calculate total due
        $total_due = $sub_total + $vat_due;

        // Function to format money
        Blade::directive('currency', function($amount) {
            return "Rp. <?php echo number_format($amount,0,',','.');?>";
        });

        $pdf = Pdf::loadView('user_invoice_pdf', [
            "name" => Auth::user()->username,
            "email" => Auth::user()->email,
            "orders" => $orders,
            "products" => $products,
            "invoice" => $invoice[0],
            "sub_total" => $sub_total,
            "vat_due" => $vat_due,
            "total_due" => $total_due
        ]);

        // Download content
        $content = $pdf->download($invoice[0]->name)->getOriginalContent();

        // Put content into invoice_pdf folder
        Storage::put('public/invoice_pdf/'.$invoice[0]->id.'.pdf', $content);

        // Delete user orders
        // Get user id
        $user_id = Auth::user()->id;

        // Fetch products from user shopping cart
        $orders = Cart::where('user_id', 'LIKE', "%$user_id%")->get();

        // Delete orders
        foreach($orders as $order) {
            $order->delete();
        }

        // Update invoice status
        $invoice = Invoice::find($id);

        $invoice->status = "submitted";

        // Save invoice changes
        $invoice->save();

        // Redirect user to market
        return redirect()->intended('/');
    }
}
