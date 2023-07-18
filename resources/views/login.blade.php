<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joelbid Furnishing | Login</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Main css -->
    <link rel="stylesheet" href="{{url('css/public.css')}}">
    <link rel="stylesheet" href="{{url('css/login.css')}}">

    <!-- Boxicons css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Form -->
    <div>
        <form action="/login" method="POST">
            @csrf
            <h2>Login</h2>
            <p>Please enter your details to login to your account</p>
            <div class="input-wrapper">
                <div>
                    <i class='bx bxs-user'></i>
                    <input type="text" name="username" placeholder="Username" required minlength="3" maxlength="15" pattern="[A-Za-z0-9\S]+">
                </div>
                <div>
                    <i class='bx bxs-lock-alt'></i>
                    <input type="password" name="password" placeholder="Password" required minlength="8" maxlength="20">
                    <i class='bx bx-hide' id="show-btn"></i>
                </div>
                <div>
                    <input type="checkbox" name="keep-me-box">
                    <label for="keep-me-box">Remember me for 30 days</label>
                </div>
            </div>
            <button type="submit" name="login-btn">Login</button>
            <p>Don't have account? <a href="/register">Click here</a></p>
        </form>
    </div>

    {{-- Registration success indicator --}}
    @if(session()->has('regist_success'))
        <script type="text/javascript">
            alert("Registration success! Please login");
        </script>
    @endif

    {{-- Login failed indicator --}}
    @if(session()->has('login_error'))
        <script type="text/javascript">
            alert("Login failed! Please check your username / password again");
        </script>
    @endif

    {{-- Too many attempts indicator --}}
    @if(session()->has('too_many_attempts'))
        <script type="text/javascript">
            alert("Too many attempts! Please wait for a minute to login again");
        </script>
    @endif

    <!-- Show password button js -->
    <script type="text/javascript">
        const show_btn = document.querySelector("#show-btn");
        const password_input = document.querySelector("input[name='password']")

        show_btn.addEventListener("click", () => {
            if (show_btn.classList.contains("bx-hide")) {
                // Remove hide icon
                show_btn.classList.remove("bx-hide");
                // Display show icon
                show_btn.classList.add("bx-show");

                // Change input type
                password_input.type = "text";
            }
            else {
                // Remove show icon
                show_btn.classList.remove("bx-show");
                // Display hide icon
                show_btn.classList.add("bx-hide");

                // Change input type
                password_input.type = "password";
            }
        });
    </script>
</body>
</html>
