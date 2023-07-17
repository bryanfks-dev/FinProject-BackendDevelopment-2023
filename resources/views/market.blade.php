<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joelbid Furnishing | Market</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/market.css')}}">

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
        <!-- Products -->
        <div class="items">
            @foreach($products as $product)
                @include('partials.item_card')
            @endforeach
        </div>
        <!-- Pagination -->
        {{$products->links('partials.pagination')}}
    </main>

    {{-- Registration success indicator --}}
    @if(session()->has('out_of_stock'))
        <script type="text/javascript">
            alert("Product already out of stock!");
        </script>
    @endif
</body>
</html>
