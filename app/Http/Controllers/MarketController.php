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
        // Check whenever user already logged in
        if (Auth::user() === null) {
            // Redirect user to login page
            return redirect('/login');
        }
        else {
            // Get user id
            $user_id = Auth::user()->id;

            // Check for existing invoice
            $exist_invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")->where('status', 'LIKE', "%pending%")->get();

            if (!$exist_invoice->isEmpty()) {
                // Redirect user to invoice page
                return redirect()->intended('/invoice');
            }
        }

        // Check whenever the order is already exist
        $user_id = Auth::user()->id;
        $exist_cart = Cart::where('user_id', 'LIKE', "%$user_id%")->where('product_id', 'LIKE', "%$id%")->get();

        if (!$exist_cart->isEmpty()) {
            // Check whenever current product stock is 0
            if (Product::find($id)->stock === 0) {
                // Sent out of stock status
                return redirect('/market')->with("out_of_stock", "status:out of stock");
            }

            // Add order quantity
            $exist_cart[0]->quantity++;

            // Decrease product stock
            $product = Product::find($id);
            $product->stock--;

            // Save changes
            $product->save();

            $exist_cart[0]->save();
        }
        else{
            // Create new order
            $cart = new Cart;

            // Set order details
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $id;
            $cart->quantity = 1;

            // Decrease product stock
            $product = Product::find($id);
            $product->stock--;

            // Save changes
            $product->save();

            // Save order
            $cart->save();
        }

        // Return user back to market page
        return redirect()->back();
    }
}
