@extends('layouts.app')

@section('content')

<style>
:root {
    --primary: #0f172a;
    --accent: #044887;
    --bg: #f4f6fa;
    --card: #ffffff;
    --text: #1f2937;
    --muted: #6b7280;
    --border: #e5e7eb;
}

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text);
}

/* ================= PAGE WRAPPER ================= */
.contact-page {
    padding: 60px 20px;
}

/* ================= CONTAINER ================= */
.contact-container {
    max-width: 1150px;
    margin: auto;
}

/* ================= HEADER ================= */
.contact-header {
    text-align: center;
    margin-bottom: 40px;
}

.contact-header h2 {
    font-size: 34px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 8px;
}

.contact-header p {
    font-size: 15px;
    color: var(--muted);
}

/* ================= GRID ================= */
.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 18px;
    margin-bottom: 35px;
}

/* ================= CARD ================= */
.contact-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.04);
    transition: all 0.25s ease;
}

.contact-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    border-color: rgba(13,110,253,0.3);
}

/* ================= TITLE (UPDATED BIGGER + BOLDER) ================= */
.contact-card h4 {
    font-size: 15px;              /* 🔥 increased from 12px */
    font-weight: 800;            /* 🔥 bolder */
    letter-spacing: 0.6px;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 10px;
}

/* ================= TEXT ================= */
.contact-card p {
    font-size: 15px;
    line-height: 1.6;
    color: var(--text);
    margin: 0;
    word-break: break-word;
}

/* ================= MAP ================= */
.map-box {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 22px rgba(0,0,0,0.05);
}

.map-title {
    padding: 14px 18px;
    font-size: 15px;
    font-weight: 800;   /* 🔥 also made bold for consistency */
    color: var(--accent);
    border-bottom: 1px solid var(--border);
}

.map-container {
    width: 100%;
    height: 420px;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {

    .contact-header h2 {
        font-size: 26px;
    }

    .map-container {
        height: 300px;
    }
}

@media (max-width: 480px) {

    .contact-page {
        padding: 40px 12px;
    }

    .contact-card {
        padding: 16px;
    }

    .contact-card h4 {
        font-size: 14px; /* keep readable on small screens */
    }

    .contact-card p {
        font-size: 14px;
    }

    .map-container {
        height: 260px;
    }
}

</style>

<div class="contact-page">
    <div class="contact-container">

        <!-- HEADER -->
        <div class="contact-header">
            <h2>Contact Us</h2>
            <p>We are available to support you through any of the channels below.</p>
        </div>

        <!-- CONTACT GRID -->
        <div class="contact-grid">

            <div class="contact-card">
                <h4>Website</h4>
                <p>{{ $contact->website_url ?? 'Not available' }}</p>
            </div>

            <div class="contact-card">
                <h4>Email</h4>
                <p>{{ $contact->official_email ?? 'Not available' }}</p>
            </div>

            <div class="contact-card">
                <h4>Customer Care</h4>
                <p>{{ $contact->customer_care_number ?? 'Not available' }}</p>
            </div>

            <div class="contact-card">
                <h4>General Superintendent Office</h4>
                <p>{{ $contact->general_superintendent_pa_number ?? 'Not available' }}</p>
            </div>

            <div class="contact-card">
                <h4>Postal Address</h4>
                <p>{{ $contact->postal_address ?? 'Not available' }}</p>
            </div>

            <div class="contact-card">
                <h4>Office Hours</h4>
                <p>{{ $contact->working_hours ?? 'Not available' }}</p>
            </div>

        </div>

        <!-- MAP -->
        <div class="map-box">
            <div class="map-title">Our Location</div>

            <div class="map-container">
                @if($contact && $contact->google_map_embed)
                    <iframe
                        src="{{ $contact->google_map_embed }}"
                        loading="lazy"
                        allowfullscreen>
                    </iframe>
                @else
                    <div style="padding:20px;">Map not available</div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection