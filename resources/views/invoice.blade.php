<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joelbid Furnishing | Invoice</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/invoice.css')}}">
</head>
<body>
    <header>
        <!-- Company Profile -->
        <div class="company">
            <h3>Joelbid's Furnishing</h3>
            <p>Karya Timur I Street</p>
            <p>East Java, Malang</p>
            <p>Indonesia, 65122</p>
            <p>joelbidfurnishing@gmail.com</p>
        </div>
        <!-- Client Profile -->
        <div class="client">
            <h3>{{Auth::user()->username}}</h3>
            <p>{{Auth::user()->email}}</p>
        </div>
    </header>
    <main>
        <!-- Invoice title -->
        <h2>{{$invoice->name}}</h2>
        <!-- Product Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contents here --}}
                @foreach($orders as $order)
                    @include('partials.invoice_item_cell')
                @endforeach
            </tbody>
            <tfoot>
                {{-- Empty tr --}}
                <tr class="empty-tr">
                    <td></td>
                </tr>
                <tr class="empty-tr">
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Subtotal</td>
                    <td class="sub-total"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Vat Rate</td>
                    <td>10%</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Vat Due</td>
                    <td class="vat-due"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTAL DUE</td>
                    <td class="total-due"></td>
                </tr>
            </tfoot>
        </table>
        <!-- Action buttons -->
        <div>
            <a onclick="return confirm('Are you sure to cancel this order?');" href="{{url('invoice/cancel', $invoice->id)}}" class="cancel-invoice">
                Cancel
            </a>
            <a onclick="return confirm('Are you sure to submit this order?');" href="{{url('invoice/submit', $invoice->id)}}" class="submit-invoice">
                Submit
            </a>
        </div>
    </main>

    <!-- Compute total js -->
    <script type="text/javascript">
        const total_cells = document.querySelectorAll(".total");
        const sub_total = document.querySelector(".sub-total");
        const vat_due = document.querySelector(".vat-due");
        const total_due = document.querySelector(".total-due");

        // Function to convert string into integer
        const convert_to_int = (amount) => {
            // Replace unwanted string components with an empty string
            amount = amount.replace("Rp. ", "");
            amount = amount.replace(".", "");

            // Return the integer format
            return parseInt(amount);
        }

        // Function to convert integer to currency format
        const convert_to_currency = (amount) => {
            return `Rp. ${amount.toLocaleString("id-ID")}`;
        }

        // This variable contains total value
        let total_value = 0;

        /* Set sub total value */
        // Sum all total values
        total_cells.forEach(ele => {
            total_value += convert_to_int(ele.innerText);
        });

        sub_total.innerText = convert_to_currency(total_value);

        /* Set vat rate value */
        const vat_rate = 0.1; // = 10%

        vat_due.innerText = convert_to_currency(vat_rate * total_value);

        /* Set total due value */
        total_value += total_value * vat_rate;

        total_due.innerText = convert_to_currency(total_value);
    </script>
</body>
</html>
