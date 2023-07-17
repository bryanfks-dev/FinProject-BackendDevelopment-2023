<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class IncomingInvoiceController extends Controller
{
    // Method to display incoming invoice page
    public function view() {
        $invoices = Invoice::latest('id')->get();

        return view("admin_invoice", [
            'invoices' => $invoices
        ]);
    }

    // Method for displaying invoice logic
    public function view_invoice($id) {
        // Display pdf
        return response()->file(public_path('storage/invoice_pdf/'.$id.'.pdf'), [
            'content-type'=>'application/pdf'
        ]);
    }

    // Method for sorting invoice logic
    public function sort_invoice($by) {
        $sort_by = ['name', 'date'];

        // Fetch all invoice and sort them
        $invoices = Invoice::all()->sortBy($sort_by[$by]);

        return view('admin_invoice', [
            "invoices" => $invoices
        ]);
    }

    // Method for search item logic
    public function search_invoice(Request $request) {
        // Get invoice data from search
        $search = $request->input("search");

        $date_input = date('Y-m-d H:i:s', strtotime($search));

        // Search invoice matched with search
        $invoices = Invoice::where('name', 'LIKE', "%$search%")
                    ->orWhere('date', 'LIKE', "%$date_input%") ->get();

        // Display admin invoice page with found invoice only
        return view('admin_invoice', [
            "invoices" => $invoices
        ]);
    }
}
