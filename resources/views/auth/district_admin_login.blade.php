<!DOCTYPE html>
<html>
<head>
    <title>District Admin Login</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
        }

        .login-container {
            width: 360px;
            margin: 100px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">

    <h2>District Admin Login</h2>

    {{-- ERROR MESSAGE --}}
    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
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