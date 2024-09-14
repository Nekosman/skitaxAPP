<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Arya:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
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

        .button:focus,
        .button:active {
            box-shadow: none !important;
            outline: none !important;
            background: #5a78d0;
            /* Warna lebih terang saat tombol dipencet */
        }

        .image {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
            transition: width 0.3s;
        }

        .label  {
            font-family: "Arya", sans-serif;
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
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ url('img/logo.png') }}" alt="Logo" class="image">
        <div class="title">Create an account</div>
        <form method="POST" action="{{ route('register.save') }}">
            @csrf
            <div>
                <label for="name" class="label name">Name</label>
                <input type="text" id="name" class="input-box name" name="name" placeholder="Input your name" required>
                @error('name')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="label email">Email</label>
                <input type="email" id="email" class="input-box email" name="email" placeholder="Input your email"
                    required>
                @error('email')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="label password">Password</label>
                <input type="password" id="password" class="input-box password" name="password" placeholder="Input your password"
                    required>
                @error('password')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="label password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" class="input-box password_confirmation" name="password_confirmation"
                    placeholder="Input your password confirmation" required>
                @error('password_confirmation')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="button">Enter</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
