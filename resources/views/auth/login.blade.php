<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Arya:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #f0f0f0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 22px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(180deg, rgba(184, 177, 177, 0) 12%, rgba(82, 79, 79, 0.79) 100%);
        }
        .title {
            text-align: center;
            color: black;
            font-size: 32px;
            font-weight: 400;
            margin-bottom: 20px;
            font-family: "Arya", sans-serif;
        }
        .input-box {
            width: 100%;
            height: 55px;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 11px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .button {
            width: 100%;
            height: 45px;
            background: #375BB7;
            border-radius: 3px;
            color: white;
            font-size: 18px;
            text-align: center;
            line-height: 45px;
            cursor: pointer;
            border: none;
        }
        .button:focus, .button:active {
            box-shadow: none !important;
            outline: none !important;
            background: #5a78d0; /* Warna lebih terang saat tombol dipencet */
        }
        .image {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
            transition: width 0.3s;
        }
        @media (max-width: 767.98px) {
            .title {
                font-size: 24px;
            }
            .input-box {
                height: 45px;
                font-size: 14px;
            }
            .button {
                height: 40px;
                font-size: 16px;
            }
            .image {
                max-width: 150px;
            }

        }

        .label  {
            font-family: "Arya", sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ url('img/logo.png') }}" alt="Logo" class="image">
        <div class="title">Login</div>
        <form method="POST" action="{{ route('login.action') }}">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div>
                <label for="email" class="label email">Email</label>
                <input type="email" id="email" class="input-box email" name="email" placeholder="Email" required="">
            </div>

            <div>
                <label for="password" class="label password">Password</label>
                <input type="password" id="password" class="input-box password" name="password" placeholder="Password" required="">
            </div>
            <div class="d-flex justify-content-between align-items-center ">
                <div class="d-flex align-items-start">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember" required="" name="remember" aria-describedby="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="button">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
