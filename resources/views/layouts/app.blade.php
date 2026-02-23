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
<!-- Footer -->
<footer class="site-footer">
    <div class="footer-top">
        <!-- Quick Links -->
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('giving.public') }}">Giving/Donations</a></li>
                <li><a href="{{ route('devotions.public.index') }}">Daily Devotions</a></li>
                <li><a href="{{ route('news.index') }}">News & Updates</a></li>
            </ul>
        </div>

        <!-- Contact Us -->
        <div class="footer-section">
            <h4>Contact Us</h4>
            <p>PAG - K Kenya Headquarters</p>
            <p>Email: 
                <a href="mailto:{{ $contactInfo->official_email ?? 'info@pagkenya.org' }}">
                    {{ $contactInfo->official_email ?? 'info@pagkenya.org' }}
                </a>
            </p>
            <p>Phone: 
                <a href="tel:{{ $contactInfo->customer_care_number ?? '+254700000000' }}">
                    {{ $contactInfo->customer_care_number ?? '+254700000000' }}
                </a>
            </p>
        </div>

        <!-- Follow Us -->
        <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <!-- Facebook -->
                <a href="#" target="_blank" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#007BB8" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 1 0-11 9.95V14h-2v-2h2v-1.5a3 3 0 0 1 3-3h2v2h-2a1 1 0 0 0-1 1V12h3l-1 2h-2v7.95A10 10 0 0 0 22 12z"/>
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="#" target="_blank" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#E1306C" viewBox="0 0 24 24">
                        <path d="M12 2.2c3.2 0 3.584.012 4.85.07 1.17.056 1.97.24 2.43.398a4.9 4.9 0 0 1 1.74 1.13 4.9 4.9 0 0 1 1.13 1.74c.158.46.342 1.26.398 2.43.058 1.266.07 1.65.07 4.85s-.012 3.584-.07 4.85c-.056 1.17-.24 1.97-.398 2.43a4.9 4.9 0 0 1-1.13 1.74 4.9 4.9 0 0 1-1.74 1.13c-.46.158-1.26.342-2.43.398-1.266.058-1.65.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.056-1.97-.24-2.43-.398a4.9 4.9 0 0 1-1.74-1.13 4.9 4.9 0 0 1-1.13-1.74c-.158-.46-.342-1.26-.398-2.43C2.212 15.584 2.2 15.2 2.2 12s.012-3.584.07-4.85c.056-1.17.24-1.97.398-2.43a4.9 4.9 0 0 1 1.13-1.74 4.9 4.9 0 0 1 1.74-1.13c.46-.158 1.26-.342 2.43-.398C8.416 2.212 8.8 2.2 12 2.2zm0-2.2C8.735 0 8.332.012 7.052.07c-1.28.058-2.15.25-2.91.532a7.098 7.098 0 0 0-2.57 1.49A7.098 7.098 0 0 0 .072 4.662c-.282.76-.474 1.63-.532 2.91C-.012 8.332 0 8.735 0 12c0 3.265.012 3.668.07 4.948.058 1.28.25 2.15.532 2.91a7.098 7.098 0 0 0 1.49 2.57 7.098 7.098 0 0 0 2.57 1.49c.76.282 1.63.474 2.91.532C8.332 23.988 8.735 24 12 24s3.668-.012 4.948-.07c1.28-.058 2.15-.25 2.91-.532a7.098 7.098 0 0 0 2.57-1.49 7.098 7.098 0 0 0 1.49-2.57c.282-.76.474-1.63.532-2.91C23.988 15.668 24 15.265 24 12s-.012-3.668-.07-4.948c-.058-1.28-.25-2.15-.532-2.91a7.098 7.098 0 0 0-1.49-2.57 7.098 7.098 0 0 0-2.57-1.49c-.76-.282-1.63-.474-2.91-.532C15.668.012 15.265 0 12 0z"/>
                        <circle cx="12" cy="12" r="3.2"/>
                        <circle cx="18.4" cy="5.6" r="1.44"/>
                    </svg>
                </a>
                <!-- YouTube -->
                <a href="#" target="_blank" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FF0000" viewBox="0 0 24 24">
                        <path d="M23.5 6.2a2.81 2.81 0 0 0-1.97-2c-1.73-.46-8.63-.46-8.63-.46s-6.9 0-8.63.46A2.81 2.81 0 0 0 .5 6.2 29.8 29.8 0 0 0 0 12a29.8 29.8 0 0 0 .5 5.8 2.81 2.81 0 0 0 1.97 2c1.73.46 8.63.46 8.63.46s6.9 0 8.63-.46a2.81 2.81 0 0 0 1.97-2 29.8 29.8 0 0 0 .5-5.8 29.8 29.8 0 0 0-.5-5.8zm-14.5 9.8V8l6 3.5-6 3.5z"/>
                    </svg>
                </a>
                <!-- X (Twitter) -->
                <a href="#" target="_blank" aria-label="X">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#1DA1F2" viewBox="0 0 24 24">
                        <path d="M23 3a10.9 10.9 0 0 1-3.14.86 4.48 4.48 0 0 0 1.95-2.48 9.72 9.72 0 0 1-3.1 1.18 4.86 4.86 0 0 0-8.3 4.44 13.8 13.8 0 0 1-10-5.07 4.86 4.86 0 0 0 1.5 6.5 4.83 4.83 0 0 1-2.2-.61v.06a4.87 4.87 0 0 0 3.9 4.77 4.9 4.9 0 0 1-2.19.08 4.88 4.88 0 0 0 4.55 3.38 9.76 9.76 0 0 1-6 2.06A10.85 10.85 0 0 1 0 19.54a13.79 13.79 0 0 0 7.49 2.2c8.99 0 13.91-7.46 13.91-13.91 0-.21 0-.42-.02-.63A9.93 9.93 0 0 0 23 3z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        &copy; {{ date('Y') }} PAG Kenya. All rights reserved. | Developed by 
        <a href="mailto:brianosieku@gmail.com">brianosieku@gmail.com</a>
    </div>

    <!-- Footer CSS -->
   <style>
.site-footer {
    background-color: #4B2E2E;
    color: #fff;
    padding: 28px 20px 12px; /* reduced from 40px 20px 20px */
    font-size: 0.95rem;
}

.site-footer a {
    color: #007BB8;
    text-decoration: none;
}

.site-footer a:hover {
    text-decoration: underline;
}

.footer-top {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 12px; /* reduced from 20px */
}

.footer-section {
    flex: 1 1 200px;
    margin: 6px 10px; /* reduced vertical spacing */
}

.footer-section h4 {
    font-size: 1.05rem;
    margin-bottom: 6px; /* reduced from 10px */
    color: #fff;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 4px; /* reduced from 5px */
}

/* Social Icons */
.social-icons {
    display: flex;
    gap: 12px; /* slightly tighter */
    align-items: center;
}

.social-icons a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s, opacity 0.3s;
}

.social-icons a svg {
    width: 30px;  /* slightly reduced from 32px */
    height: 30px;
}

.social-icons a:hover {
    transform: scale(1.2);
    opacity: 0.85;
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.3);
    padding-top: 8px; /* reduced from 10px */
    margin-top: 8px;
    text-align: center;
    font-size: 0.82rem;
}

/* Mobile */
@media (max-width: 768px) {

    .site-footer {
        padding: 20px 15px 10px;
    }

    .footer-top {
        display: grid;
        grid-template-columns: 1fr 1fr; /* 2 columns instead of stacking */
        gap: 15px;
        text-align: left;
        margin-bottom: 10px;
    }

    .footer-section {
        margin: 0;
    }

    /* Make Social section full width */
    .footer-section:last-child {
        grid-column: span 2;
        text-align: center;
        margin-top: 5px;
    }

    .social-icons {
        justify-content: center;
        gap: 12px;
    }

    .footer-bottom {
        margin-top: 10px;
        padding-top: 8px;
        font-size: 0.8rem;
    }
}
</style>
</footer>

</body>
</html>
