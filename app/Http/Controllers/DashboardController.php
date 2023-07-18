<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\File;

use App\Models\Product;

class DashboardController extends Controller
{
    // Method to display admin dashboard page
    public function view() {
        $products = Product::latest('id')->get();

        return view('admin_dashboard', [
            "products" => $products
        ]);
    }

    // Method for create new item logic
    public function create_item(Request $request) {
        // Validate inputted item data
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required'
        ]);

        // Add image to validatedData
        $validatedData['image'] = date('dmY').'_'.time().'.'.$request->image->getClientOriginalExtension();

        // Save image to app folder
        $request->image->storeAs(
            'public/product_img', $validatedData['image']
        );

        // Create new item data
        Product::create($validatedData);

        // Redirect admin back to dashboard
        return redirect()->intended('/dashboard');
    }

    // Method for sorting item logic
    public function sort_item($by) {
        $sort_by = ['name', 'price', 'stock'];

        if ($by >= 0 && $by < count($sort_by)) {
            // Fetch all item and sort them
            $items = Product::all()->sortBy($sort_by[$by]);

            // Display admin dashboard page with sorted items
            return view('admin_dashboard', [
                "products" => $items
            ]);
        }
        // Return bad request
        else abort(400);
    }

    // Method for search item logic
    public function search_item(Request $request) {
        // Get item name from search
        $input = $request->search;

        // Search item's name matched with search
        $products = Product::where('name', 'LIKE', "%$input%")
                    ->orWhere('price', 'LIKE', "%$input%")
                    ->orWhere('stock', 'LIKE', "%$input%")->get();

        // Display admin dashboard page with found item only as product
        return view('admin_dashboard', [
            "products" => $products
        ]);
    }

    // Method for update item logic
    public function update_item(Request $request) {
        // Validate inputted item data
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required'
        ]);

        // Get item id
        $item_id = $request->input("id");

        // Find item using it's id
        $item = Product::find($item_id);

        // Update item attributes
        $item->name = $validatedData["name"];
        $item->price = $validatedData["price"];
        $item->stock = $validatedData["stock"];
        $item->description = $validatedData["description"];

        // Save updated item attributes
        $item->save();

        // Redirect admin back to dashboard
        return redirect()->intended('/dashboard');
    }

    // Method for delete item logic
    public function delete_item($id) {
        // Find item using it's id
        $item = Product::find($id);

        // Delete item image
        if (File::exists("url('public/product_img', $item->image)")) {
            File::delete("url('public/product_img', $item->image))");
        }

        // Delete item
        $item->delete();

        // Redirect admin back to dashboard
        return redirect()->intended('/dashboard');
    }
}
