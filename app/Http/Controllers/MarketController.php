<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    // Method to display market page
    public function view() {
        $products = Product::latest('id')->paginate(4);

        // Check for 0 quantity item
        foreach($products as $key=>$product) {
            if ($product->stock === 0) {
                unset($products[$key]);
            }
        }

        // Function to format money
        Blade::directive('currency', function($amount) {
            return "Rp. <?php echo number_format($amount,0,',','.');?>";
        });

        return view('market', [
            'products' => $products
        ]);
    }

    // Method for add to cart logic
    public function add_to_cart($id) {
        // Check if product id is valid
        if (Product::find($id) === null) {
            // Return bad request
            return abort(400);
        }

        // Get user id
        $user_id = Auth::user()->id;

        // Check for existing invoice
        $exist_invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")
                        ->where('status', 'LIKE', "%pending%")->get();

        if (!$exist_invoice->isEmpty()) {
            // Redirect user to invoice page
            return redirect()->intended('/invoice');
        }

        // Check whenever the order is already exist
        $exist_cart = Cart::where('user_id', 'LIKE', "%$user_id%")->get();

        if (!$exist_cart->isEmpty()) {
            // Check whenever current product stock is 0
            if (Product::find($id)->stock === 0) {
                // Sent out of stock status
                return redirect('/market')->with("out_of_stock", "status:out of stock");
            }

            // Check if current product stock not 0
            if ($exist_cart[0]->quantity + 1 <= Product::find($exist_cart[0]->product_id)->stock) {
                // Increase quantity
                $exist_cart[0]->quantity++;

                // Update order
                $exist_cart[0]->save();
            }
        }
        else {
            // Create new order
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        // Return user back to market page
        return redirect()->back();
    }
}
