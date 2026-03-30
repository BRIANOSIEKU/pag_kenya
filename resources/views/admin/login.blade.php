<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - PAG-K</title>
    <style>
        /* Reset styles */
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

        /* Shimmer effect */
        body::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 400px;
            background: linear-gradient(120deg, rgba(255,255,255,0) 30%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 70%);
            transform: translate(-50%, -50%) rotate(20deg);
            animation: shimmer 3s infinite;
            z-index: 0;
        }

        @keyframes shimmer {
            0% { transform: translate(-70%, -50%) rotate(20deg); }
            100% { transform: translate(70%, -50%) rotate(20deg); }
        }

        /* Fade-in + slide-up + shadow pulse animation */
        @keyframes fadeInUpShadow {
            0% {
                opacity: 0;
                transform: translateY(20px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }
            50% {
                opacity: 1;
                transform: translateY(0);
                box-shadow: 0 15px 30px rgba(0,0,0,0.15); /* subtle shadow pulse */
            }
            100% {
                opacity: 1;
                transform: translateY(0);
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            }
        }

        .login-container {
            position: relative;
            background-color: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 3px solid #4CAF50; /* PAG-K green border */
            z-index: 1; /* above watermark and shimmer */
            animation: fadeInUpShadow 1s ease forwards;
        }

        .login-container img {
            width: 180px; /* large logo on top */
            margin-bottom: 15px;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #4CAF50;
            font-size: 28px;
            font-weight: bold;
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s ease;
        }

        .login-container input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #FFD700; /* Gold button */
            color: #1e3c72;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #4CAF50;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #4CAF50;
            color: #fff;
        }

        .error-message {
            color: red;
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
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- PAG-K Logo -->
        <img src="{{ asset('images/pagk_logo.png') }}" alt="PAG-K Logo">

        <h2>ADMIN LOGIN</h2>

        @if($errors->any())
            <div class="error-message">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
