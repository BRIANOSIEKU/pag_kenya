<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PAG Kenya')</title>
    
    <!-- Simple CSS for demonstration -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fffdd0; /* cream white */
            color: #000;
        }

        header {
            background-color: #007BB8; /* main blue */
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #4B2E2E; /* dark brown */
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #007BB8;
        }

        footer {
            background-color: #4B2E2E;
            color: #fff;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        main {
            padding: 30px 20px;
        }
    </style>
</head>
<body>

    <!-- Include the responsive header -->
    @include('includes.header')

    <!-- Page Content -->
    <main>
        @yield('content')  <!-- This is where individual pages will inject their content -->
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} PAG Kenya. All rights reserved.
    </footer>

</body>
</html>
