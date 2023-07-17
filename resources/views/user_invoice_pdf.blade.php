<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$invoice->name}}</title>

    <!-- Main css -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 3em;
        }

        div {
            display: inline-block
        }

        .client {
            float: right;
            text-align: right;
        }

        /* Main */
        h2 {
            margin: 1.3em 0;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table body */
        tbody tr {
            height: 3em;
        }

        tr {
            border-bottom: 1px solid rgb(161, 155, 155);
            text-align: center;
        }

        /* Table head */
        thead {
            height: 3em;
            background-color: lightgray;
        }

        tfoot .empty-tr {
            height: 1.6em;
        }
    </style>
</head>
<body>
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
        <h3>{{$name}}</h3>
        <p>{{$email}}</p>
    </div>

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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr class="empty-tr">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Subtotal</td>
                <td>@currency($sub_total)</td>
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
                <td>@currency($vat_due)</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>TOTAL DUE</td>
                <td>@currency($total_due)</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
