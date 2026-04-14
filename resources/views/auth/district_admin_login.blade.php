<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>District Admin Login</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            position: relative;
            overflow: hidden;
        }

        /* Watermark */
        body::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 400px;
            background-image: url('{{ asset('images/pagk_logo.png') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.08;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        /* shimmer */
        body::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 400px;
            background: linear-gradient(
                120deg,
                rgba(255,255,255,0) 30%,
                rgba(255,255,255,0.2) 50%,
                rgba(255,255,255,0) 70%
            );
            transform: translate(-50%, -50%) rotate(20deg);
            animation: shimmer 3s infinite;
            z-index: 0;
        }

        @keyframes shimmer {
            0% { transform: translate(-70%, -50%) rotate(20deg); }
            100% { transform: translate(70%, -50%) rotate(20deg); }
        }

        @keyframes fadeInUpShadow {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            position: relative;
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 3px solid #4CAF50;
            z-index: 1;
            animation: fadeInUpShadow 1s ease forwards;
        }

        .login-container img {
            width: 180px;
            margin-bottom: 15px;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #4CAF50;
            font-size: 26px;
            font-weight: bold;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #FFD700;
            color: #1e3c72;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #4CAF50;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #4CAF50;
            color: #fff;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px 20px;
            }

            .login-container img {
                width: 140px;
            }

            .login-container h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <!-- LOGO -->
    <img src="{{ asset('images/pagk_logo.png') }}" alt="Logo">

    <h2>District Admin Login</h2>

    {{-- ERROR --}}
    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('district.admin.login.submit') }}">
        @csrf

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

</div>

</body>
</html>