<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    // Method to display shopping cart page
    public function view() {
        // Get user id
        $user_id = Auth::user()->id;

        $orders = Cart::where('user_id', 'LIKE', "%$user_id%")
                    ->latest('id')
                    ->paginate(4);

        $products = Product::all();

        return view('shopping_cart', [
            'user' => Auth::user()->username,
            'orders' => $orders,
            'products' => $products
        ]);
    }

    // Method for checking available invoice
    private static function check_invoice() {
        // Get user id
        $user_id = Auth::user()->id;

        $invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")
                    ->where('status', 'LIKE', "%pending%")->get();

        // Check if available invoice is not empty
        if (!$invoice->isEmpty()) {
            // Redirect user to invoice page
            return 1;
        }

        return 0;
    }

    // Method for increase quantity logic
    public function increase_quantity($id) {
        if (self::check_invoice()) {
            return redirect('/invoice');
        }

        // Find order using it's id
        $order = Cart::find($id);

        // Check if order id is valid
        if ($order === null) {
            // Return bad request
            return abort(400);
        }

        // Check if current product stock not 0
        if ($order->quantity + 1 <= Product::find($order->product_id)->stock) {
            // Increase quantity
            $order->quantity++;

            // Update order
            $order->save();
        }

        // Redirect user back to cart page
        return redirect()->back();
    }

    // Method for decrease quantity logic
    public function decrease_quantity($id) {
        // Get user id
        $user_id = Auth::user()->id;

        $invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")
                    ->where('status', 'LIKE', "%pending%")->get();

        // Check if available invoice is empty
        if ($invoice->isEmpty()) {
            // Find order using it's id
            $order = Cart::find($id);

            // Check if order id is valid
            if ($order === null) {
                // Return bad request
                return abort(400);
            }

            $product = Product::find($order->product_id);

            // Set order quantity to current product stock
            // if order quantity greater than stock
            if ($order->quantity > $product->stock) {
                $order->quantity = $product->stock;
            }
            // Check if current product stock still less than order quantity and not 0
            else if ($order->quantity <= $product->stock && $order->quantity - 1 >= 1) {
                // Increase quantity
                $order->quantity--;

                // Update order
                $order->save();
            }

            // Redirect user back to cart page
            return redirect()->back();
        }
        // Redirect user to invoice page
        else return redirect('/invoice');
    }

    // Method for delete order logic
    public static function delete_order($id) {
        if (self::check_invoice()) {
            return redirect('/invoice');
        }

        // Find order using it's id
        $order = Cart::find($id);

        // Check if order id is valid
        if ($order === null) {
            // Return bad request
            return abort(400);
        }

        // Delete order
        $order->delete();

        // Redirect user back to cart page
        return redirect()->back();
    }

    // Method for proceed order logic
    public function proceed_order() {
        // Get user id
        $user_id = Auth::user()->id;

        // Check for existing invoice
        $exist_invoice = Invoice::where('user_id', 'LIKE', "%$user_id%")
                        ->where('status', 'LIKE', "%pending%")->get();

        if ($exist_invoice->isEmpty()) {
            // Get user id
            $user_id = Auth::user()->id;

            // Get user orders
            $orders = Cart::where('user_id', 'LIKE', "%$user_id%")->get();

            // Check if user order is empty
            if ($orders->isEmpty()) {
                // Redirect user back to cart page with no order status
                return redirect()->back()->with("no_order", "status:no_order");
            }

            // Check for product stock and order quantity
            foreach($orders as $order) {
                if ($order->quantity > Product::find($order->product_id)->stock) {
                    return redirect()->back()->with('insufficient_stock', 'status:insufficient_stock');
                }
            }

            try {
                // Database transaction
                DB::beginTransaction();

                // Decrease product stock by quantity
                foreach($orders as $order) {
                    $product = Product::find($order->product_id);

                    $product->stock -= $order->quantity;

                    $product->save();
                }

                // Create invoice
                Invoice::create([
                    'name' => "Invoice INV/".Auth::user()->id."/".date('Ymd')."/".time(),
                    'user_id' => Auth::user()->id,
                    'date' => date("Y-m-d H:i:s"),
                    'status' => "pending"
                ]);

                DB::commit();
            }
            catch (\Throwable $th) {
                // Throw error
                throw $th;

                // Rollback database
                DB::rollBack();
            }
        }

        // Redirect user to invoice page
        return redirect()->intended('/invoice');
    }
}
