<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    // Method to display shopping cart page
    public function view() {
        $orders = Cart::latest('id')->paginate(4);
        $products = Product::all();

        return view('shopping_cart', [
            'user' => Auth::user()->username,
            'orders' => $orders,
            'products' => $products
        ]);
    }

    // Method for update quantity logic
    public function update_quantity($action, $id) {
        // Get user id
        $user_id = Auth::user()->id;

        // Check for existing invoice
        $exist_invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")->where('status', 'LIKE', "%pending%")->get();

        if (!$exist_invoice->isEmpty()) {
            // Redirect user to invoice page
            return redirect()->intended('/invoice');
        }

        // Find order using it's id
        $order = Cart::find($id);

        // Check for action
        if (strcmp("min", $action) === 0) {
            // Check if next quantity value is not 0
            if ($order->quantity - 1 !== 0) {
                // Decrease quantity
                $order->quantity--;

                // Update order
                $order->save();

                // Update product
                $product = Product::find($order->product_id);

                $product->stock++;

                $product->save();
            }
        }
        else {
            // Check if current product stock not 0
            if (Product::find($order->product_id)->stock !== 0) {
                // Increase quantity
                $order->quantity++;

                // Update order
                $order->save();

                // Update product
                $product = Product::find($order->product_id);

                $product->stock--;

                $product->save();
            }
        }

        // Redirect user back to cart page
        return redirect()->back();
    }

    // Method for delete order logic
    public function delete_order($id) {
        // Check if there's user invoice with pending status
        // Get user id
        $user_id = Auth::user()->id;

        // Check for existing invoice
        $exist_invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")->where('status', 'LIKE', "%pending%")->get();

        if (!$exist_invoice->isEmpty()) {
            // Redirect user to invoice page
            return redirect()->intended('/invoice');
        }

        // Find orde using it's id
        $order = Cart::find($id);

        // Update product stock
        $product = Product::find($order->product_id);

        // Add product stock
        $product->stock += $order->quantity;

        // Save product changes
        $product->save();

        // Delete order
        $order->delete();

        // Redirect user back to cart page
        return redirect()->back();
    }

    // Method for proceed order logic
    public function proceed_order() {
        // Check if there's no existing invoice with pending status
        $user_id = Auth::user()->id;

        if (Invoice::where('user_id', 'LIKE', "%$user_id%")->where('status', 'LIKE', "%pending%")->get()->isEmpty()) {
            // Create invoice
            Invoice::create([
                'name' => "Invoice INV/".Auth::user()->id."/".date('Ymd')."/".time(),
                'user_id' => Auth::user()->id,
                'date' => date("Y-m-d H:i:s"),
                'status' => "pending"
            ]);
        }

        // Redirect user to invoice page
        return redirect()->intended('/invoice');
    }
}
