@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="contact-page" id="contact">
    <h1 class="contact-title">Contact Us</h1>

    @if($contact)
        <div class="contact-grid">
            <!-- Customer Care Number -->
            <div class="contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon phone-icon" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                             19.79 19.79 0 0 1-8.63-3.07
                             19.5 19.5 0 0 1-6-6
                             19.79 19.79 0 0 1-3.07-8.67A2
                             2 0 0 1 4.11 2h3a2 2 0 0 1
                             2 1.72c.12.89.32 1.76.59 2.59
                             a2 2 0 0 1-.45 2.11L8.09 9.91
                             a16 16 0 0 0 6 6l1.49-1.16
                             a2 2 0 0 1 2.11-.45c.83.27
                             1.7.47 2.59.59A2 2 0 0 1 22 16.92z"/>
                </svg>
                <div>
                    <h3>Customer Care</h3>
                    <p>{{ $contact->customer_care_number ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- General Superintendent PA -->
            <div class="contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon gs-icon" viewBox="0 0 24 24" fill="none" stroke="#1DD1A1" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M8 12h8M12 8v8"/>
                </svg>
                <div>
                    <h3>Office of the General Superintendent</h3>
                    <p>{{ $contact->general_superintendent_pa_number ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Email -->
            <div class="contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon email-icon" viewBox="0 0 24 24" fill="none" stroke="#54A0FF" stroke-width="2">
                    <path d="M4 4h16v16H4z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <div>
                    <h3>Email</h3>
                    <p><a href="mailto:{{ $contact->official_email }}">{{ $contact->official_email ?? 'N/A' }}</a></p>
                </div>
            </div>

            <!-- Website -->
            <div class="contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon web-icon" viewBox="0 0 24 24" fill="none" stroke="#F9CA24" stroke-width="2">
                    <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/>
                    <path d="M2 12h20"/>
                    <path d="M12 2a10 10 0 0 1 0 20"/>
                </svg>
                <div>
                    <h3>Website</h3>
                    <p><a href="{{ $contact->website_url }}" target="_blank">{{ $contact->website_url ?? 'N/A' }}</a></p>
                </div>
            </div>

            <!-- Postal Address -->
            <div class="contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon address-icon" viewBox="0 0 24 24" fill="none" stroke="#FF9F43" stroke-width="2">
                    <path d="M21 10V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4"/>
                    <path d="M21 10l-9 6-9-6"/>
                </svg>
                <div>
                    <h3>Postal Address</h3>
                    <p>{{ $contact->postal_address ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon hours-icon" viewBox="0 0 24 24" fill="none" stroke="#9B59B6" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                <div>
                    <h3>Office Hours</h3>
                    <p>{{ $contact->working_hours ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

{{-- ================= AI CHAT WIDGET ================= --}}
<div id="chat-widget">
    <div class="chat-header" onclick="toggleChat()">
        <span>Ask PAG Assistant</span>
        <span id="chat-toggle-icon">+</span>
    </div>

    <div class="chat-body" id="chat-body" style="display:none;">
        <div id="chat-messages" class="chat-messages"></div>

        <form id="chat-form">
            @csrf
            <textarea name="message" placeholder="Type your message..." required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</div>

<style>
#chat-widget {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 340px;
    max-width: 95%;
    font-family: 'Inter', sans-serif;
    z-index: 9999;
}
.chat-header {
    background-color: #0F3C78;
    color: #fff;
    padding: 12px;
    border-radius: 12px 12px 0 0;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
}
.chat-body {
    background: #fff;
    border: 1px solid #0F3C78;
    border-radius: 0 0 12px 12px;
    max-height: 420px;
    display: flex;
    flex-direction: column;
}
.chat-messages {
    padding: 12px;
    flex: 1;
    overflow-y: auto;
}
.user-msg {
    background: #e0edf1;
    padding: 8px 12px;
    margin-bottom: 8px;
    border-radius: 12px;
    font-size: 0.9rem;
}
.ai-msg {
    background: #0F3C78;
    color: #fff;
    padding: 8px 12px;
    margin-bottom: 8px;
    border-radius: 12px;
    font-size: 0.9rem;
}
#chat-form {
    display: flex;
    padding: 10px;
    gap: 8px;
}
#chat-form textarea {
    flex: 1;
    resize: none;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 0.9rem;
}
#chat-form button {
    background-color: #0F3C78;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
}
#chat-form button:hover {
    background-color: #0d2f5f;
}
</style>

<script>
// Toggle chat open/close
function toggleChat() {
    const body = document.getElementById('chat-body');
    const icon = document.getElementById('chat-toggle-icon');
    if(body.style.display === 'none'){
        body.style.display = 'flex';
        icon.textContent = '-';
    } else {
        body.style.display = 'none';
        icon.textContent = '+';
    }
}

// DOM elements
const chatForm = document.getElementById('chat-form');
const chatMessages = document.getElementById('chat-messages');
const messageInput = chatForm.querySelector('textarea');

// Append messages
function appendUserMessage(message){
    const div = document.createElement('div');
    div.className = 'user-msg';
    div.innerHTML = `<strong>You:</strong> ${message}`;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function appendBotMessage(message){
    const div = document.createElement('div');
    div.className = 'ai-msg';
    div.innerHTML = `<strong>PAG Assistant:</strong> ${message}`;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

chatForm.addEventListener('submit', async function(e){
    e.preventDefault();
    const userMessage = messageInput.value.trim();
    if(!userMessage) return;

    appendUserMessage(userMessage);
    messageInput.value = '';

    // Typing placeholder
    const typingDiv = document.createElement('div');
    typingDiv.className = 'ai-msg';
    typingDiv.innerHTML = `<strong>PAG Assistant:</strong> Typing...`;
    chatMessages.appendChild(typingDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    try {
        const res = await fetch('/ai-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ message: userMessage })
        });

        const data = await res.json();

        // Replace typing placeholder with real response
        typingDiv.innerHTML = `<strong>PAG Assistant:</strong> ${data.reply}`;

    } catch(err){
        typingDiv.innerHTML = `<strong>PAG Assistant:</strong> Sorry, something went wrong.`;
        console.error(err);
    }
});
</script>
        <!-- Google Map -->
        @if($contact->google_map_embed)
            <div class="map-container">
                <iframe src="{{ $contact->google_map_embed }}" width="100%" height="400" style="border:0; border-radius:10px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        @endif

    @else
        <p style="text-align:center; color:#fff;">No contact details available at the moment.</p>
    @endif
</div>

<style>
html, body {
    height: 100%;
    margin: 0;
    background-color: #e0edf1; /* full-page shade of blue */
    font-family: 'Inter', sans-serif;
}

.contact-page {
    padding: 60px 20px;
    max-width: 1100px;
    margin: 0 auto;
    color: #fff;
}

.contact-title {
    text-align: center;
    color: #0F3C78;      /* Blue text */
    font-size: 2rem;
    margin-bottom: 40px;
    position: relative;
    display: inline-block;      /* important for ::after positioning */
    padding-bottom: 8px;
}

.contact-title::after {
    content: '';
    position: absolute;
    left: 50%;                  /* start at center */
    bottom: 0;                  /* place below text */
    transform: translateX(-50%) scaleX(0); /* center & start small */
    transform-origin: center;   /* grow from center */
    width: 15vw;                 /* responsive width */
    max-width: 120px;
    min-width: 60px;
    height: 4px;                 /* thickness of the line */
    background-color: #FF6F00;   /* dark orange */
    border-radius: 2px;
    transition: transform 0.6s ease-out;
}

/* Animate on page load */
.contact-title.animate-underline::after {
    transform: translateX(-50%) scaleX(1); /* full width from center */
}

/* Hover effect (optional) */
.contact-title:hover::after {
    transform: translateX(-50%) scaleX(1.1); /* slightly longer on hover */
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .contact-title {
        font-size: 1.5rem;
    }
    .contact-title::after {
        width: 25vw;
        height: 3px;
    }
}


.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.contact-card {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    transition: transform 0.3s, box-shadow 0.3s;
    color: #333;
}
.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}
.contact-card .icon {
    width: 36px;
    height: 36px;
    flex-shrink: 0;
}
.contact-card h3 {
    margin: 0 0 5px;
    font-size: 1.1rem;
    color: #0F3C78;
}
.contact-card p, .contact-card a {
    margin: 0;
    font-size: 0.95rem;
    color: #333;
    text-decoration: none;
}
.contact-card a:hover {
    color: #d4af37;
}

.map-container {
    margin-top: 40px;
    width: 100%;
    height: 400px;
}
.map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .contact-title { font-size: 1.7rem; }
    .contact-card { gap: 12px; padding: 15px; }
    .contact-card .icon { width: 28px; height: 28px; }
}
@media (max-width: 480px) {
    .contact-grid { grid-template-columns: 1fr; gap: 15px; }
    .contact-card { gap: 10px; padding: 12px; }
    .contact-card h3 { font-size: 1rem; }
    .contact-card p { font-size: 0.9rem; }
}
</style>
@endsection
