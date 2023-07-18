<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joelbid Furnishing | Register</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/register.css')}}">

    <!-- Boxicons css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Form -->
    <div>
        <form action="/register" method="POST">
            @csrf
            <h2>Register</h2>
            <p>Please enter your details to register your account</p>
            <div class="input-wrapper">
                <div>
                    <i class='bx bxs-user'></i>
                    <input type="text" name="username" placeholder="Username" required minlength="3" maxlength="15" pattern="[A-Za-z0-9\S]+" value="{{old('username')}}">
                </div>
                <div>
                    <i class='bx bxl-gmail'></i>
                    <input type="email" name="email" placeholder="Email" required value="{{old('email')}}">
                </div>
                <div>
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="password" placeholder="Password" required minlength="8" maxlength="20">
                </div>
            </div>
            <button type="submit" name="regis-btn">Register</button>
            <p>Already have account? <a href="/login">Click here</a></p>
        </form>
    </div>

    {{-- Check if username is error --}}
    @error('username')
        <script type="text/javascript">
            alert("Username already exist! Please use a new one");
        </script>
    @enderror

    {{-- Check if email is error --}}
    @error('email')
        <script type="text/javascript">
            alert("Please use other email");
        </script>
    @enderror
</body>
</html>
