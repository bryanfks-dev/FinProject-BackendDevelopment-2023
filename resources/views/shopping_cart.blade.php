<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joelbid Furnishing | Cart</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/cart.css')}}">

    <!-- Boxicons css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Header -->
    <header>
        @include('partials.navbar')
    </header>
    <!-- Main -->
    <main>
        <span>
            <b>{{$user}}'s Shopping Cart</b>
        </span>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            {{-- Product cells --}}
            @foreach($orders as $order)
                @include('partials.item_cell')
            @endforeach
        </table>
        <!-- Pagination -->
        {{$orders->links('partials.pagination')}}

        <style>
            /* Custom pagination */
            main > nav {
                position: absolute;
                bottom: 1.5em
            }
        </style>

        <!-- Checkout button -->
        <a href="/cart/proceed_order">Check Out</a>
    </main>

    @if (session()->has('no_order'))
        <script type="text/javascript">
            alert("No order found in your shopping cart");
        </script>
    @endif

    <!-- Total update js -->
    <script type="text/javascript">
        const quant = document.querySelectorAll("p.quantity");
        const price_td = document.querySelectorAll("tr td:nth-of-type(2)");
        const total_td = document.querySelectorAll("tr td:nth-of-type(4)");

        // Quantity inputs on change listener
        quant.forEach((ele, idx) => {
            // Replace unwanted string components with empty string
            let price = price_td[idx].innerText.replace("Rp. ", "");

            // Set total price
            total_td[idx].innerText = `Rp. ${(parseInt(quant[idx].innerText) * parseInt(price)).toLocaleString("id-ID")}`;
        });
    </script>
</body>
</html>
