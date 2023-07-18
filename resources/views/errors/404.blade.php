<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/404.css')}}">
</head>
<body>
    <div>
        <div>
            <h1>Error 404</h1>
            <h2>Page Not Found</h2>
            <p>The page you're looking for no longer exist</p>
            <a href="@if(Auth::user() !== null && Auth::user()->is_admin){{url('dashboard')}}@else{{url('/')}}@endif">Return to homepage</a>
        </div>
    </div>
</body>
</html>
