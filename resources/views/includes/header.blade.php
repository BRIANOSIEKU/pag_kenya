<!-- Premium Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

@php
use App\Models\Department;
$departments = Department::all();
@endphp
@php
use App\Models\ContactInfo;

// Fetch the first row (assuming you have only one contact info record)
$contact = ContactInfo::first();
@endphp
<header id="mainHeader" class="header">

  <div class="header-inner">

    <!-- Top Row -->
    <div class="top-row">

      <!-- Logo and Title Wrapper -->
      <div class="logo-title-wrapper">
        <img src="{{ asset('images/pagk_logo.png') }}" alt="PAG Kenya Logo" class="header-logo">
        <div class="header-title-wrapper">
          <div class="header-title">THE PENTECOSTAL ASSEMBLIES<br>OF GOD - KENYA</div>
          <div class="header-slogan">Empowering communities through faith and service</div>
        </div>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobileMenuBtn" class="mobile-menu-btn"></button>

      <!-- Contact Info -->
<div class="contact-info">
    <span>
        <svg width="16" height="16" fill="none" stroke="white" stroke-width="1.6" viewBox="0 0 24 24">
            <path d="M4 4h16v16H4z"/>
            <polyline points="22,6 12,13 2,6"/>
        </svg> 
        {{ $contact->official_email ?? 'info@pagkenya.org' }}
    </span>
    <span>
        <svg width="16" height="16" fill="none" stroke="white" stroke-width="1.6" viewBox="0 0 24 24">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.89.32 1.76.59 2.59a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.49-1.16a2 2 0 0 1 2.11-.45c.83.27 1.7.47 2.59.59A2 2 0 0 1 22 16.92z"/>
        </svg> 
        {{ $contact->customer_care_number ?? '+254 700 000 000' }}
    </span>
</div>

    </div>

    <!-- Navigation Row -->
    <div class="nav-row">

      <!-- Mobile Close Button -->
      <button id="mobileCloseBtn" class="mobile-close-btn">✕</button>

      <div class="nav-dropdown"><a href="{{ url('/') }}" class="nav-link">Home</a></div>
      <div class="nav-dropdown"><a href="{{ route('church.profile') }}" class="nav-link">Church Profile</a></div>

      <div class="nav-dropdown">
        <button type="button" class="nav-link dropdown-toggle-btn">Administrative Structure <span class="arrow">▾</span></button>
        <div class="dropdown-menu">
          <a href="{{ route('leadership.public', 'executive-committee') }}">Executive Committee</a>
          <a href="{{ route('leadership.public', 'church-council') }}">Church Council</a>
          <a href="{{ route('church.overseers') }}">Church Overseers</a>
          <a href="{{ route('hq.staff.public') }}">PAG Kenya HQ Staff</a>
        </div>
      </div>

      <div class="nav-dropdown">
        <button type="button" class="nav-link dropdown-toggle-btn">Departments <span class="arrow">▾</span></button>
        <div class="dropdown-menu">
          @foreach($departments as $dept)
            <a href="{{ route('departments.public.show', $dept->id) }}">{{ $dept->name }}</a>
          @endforeach
        </div>
      </div>

      <div class="nav-dropdown"><a href="{{ route('news.index') }}" class="nav-link">News</a></div>
      <div class="nav-dropdown"><a href="{{ route('projects.public.index') }}" class="nav-link">Projects</a></div>
      <div class="nav-dropdown"><a href="{{ route('devotions.public.index') }}" class="nav-link">Daily Devotions</a></div>
      <div class="nav-dropdown"><a href="{{ route('giving.public') }}" class="nav-link">Giving / Donations</a></div>
      <div class="nav-dropdown"><a href="{{ route('partners.index') }}" class="nav-link">Partners</a></div>
      <div class="nav-dropdown"><a href="{{ route('contact.public') }}" class="nav-link">Contact</a></div>

    </div>
  </div>
</header>

<div id="menuOverlay"></div>

<style>
/* ================= HEADER ================= */
.header { background: #034469; position: sticky; top: 0; z-index: 1000; }
.header-inner { max-width: 1300px; margin: 0 auto; padding: 16px 30px 10px; }
.top-row { display: flex; align-items: center; justify-content: space-between; }
.logo-title-wrapper { display: flex; align-items: center; gap:15px; }
.header-logo { height: 150px; transition: all 0.3s ease; }
.header-title-wrapper { display: flex; flex-direction: column; }
.header-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.6rem; color: #fff; }
.header-slogan { font-family: 'Inter', sans-serif; font-style: italic; font-size: 0.95rem; color: gold; }
.contact-info { display: flex; flex-direction: column; font-family: 'Inter', sans-serif; font-size: 0.85rem; color: #fff; gap:4px; align-items: flex-end; }

/* ================= NAVIGATION ================= */
.nav-row { margin-top: 10px; display: flex; justify-content: center; gap: 35px; font-family: 'Inter', sans-serif; position: relative; }
.nav-dropdown { position: relative; }
.nav-link { color: #fff; text-decoration: none; font-weight: 500; transition: color 0.3s; cursor: pointer; }
.nav-link:hover { color: #d4af37; }
.dropdown-toggle-btn { background: none; border: none; color: #fff; font-weight: 500; cursor: pointer; transition: color 0.3s; }
.dropdown-toggle-btn:hover { color: #d4af37; }
.dropdown-menu { position: absolute; top: 100%; left: 0; display: none; flex-direction: column; background: #4CAF50; min-width: 200px; z-index: 9999; margin-top: 0; }
.dropdown-menu.show { display: flex; }
.dropdown-menu a { padding: 10px 20px; color: #fff; text-decoration: none; white-space: nowrap; }
.dropdown-menu a:hover { background: #d4af37; color: #000; }

/* ================= MOBILE ONLY ================= */
@media (max-width: 992px) {
  .top-row { flex-direction: column; align-items: center; gap:5px; }
  .logo-title-wrapper { flex-direction: column; align-items: center; text-align: center; }
  .header-logo { height: 150px; }
  .header-title { font-size: 1.2rem; line-height: 1.2; }
  .header-slogan { font-size: 0.85rem; margin-bottom:5px; }
  .contact-info { flex-direction: row; gap:20px; justify-content:center; margin-bottom:5px; }

  .mobile-menu-btn { display: block; width: 40px; height: 40px; background: #d4af37; border: none; border-radius: 4px; position: absolute; top: 10px; right: 15px; }
  .mobile-menu-btn::before { content: "\2630"; font-size: 1.6rem; color: #000; }

  /* Mobile Close Button */
  .mobile-close-btn {
    display: none;
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #fff;
    cursor: pointer;
    z-index: 2100;
  }

  /* Only show X when menu is open */
  .nav-row.show .mobile-close-btn { display: block; }

  .nav-row {
    flex-direction: column;
    position: fixed;
    top: 0;
    right: -100%;
    width: 280px;
    height: 100vh;
    background: #065f88;
    padding-top: 100px;
    transition: 0.4s ease;
    z-index: 2000;
    overflow-y: auto;
  }
  .nav-row.show { right: 0; }

  .nav-dropdown { width: 100%; border-bottom: 1px solid rgba(255,255,255,0.1); }
  .nav-dropdown a,
  .nav-dropdown button { display: block; width: 100%; padding: 10px 25px; text-align: left; font-weight: 500; color: #fff; text-decoration: none; }
  .nav-dropdown a:hover,
  .nav-dropdown button:hover { background: #d4af37; color: #000; }

  /* Mobile slide-down dropdowns */
  .dropdown-menu { 
    position: static; 
    max-height: 0; 
    overflow: hidden; 
    background: #065f92; 
    flex-direction: column; 
    transition: max-height 0.3s ease; 
  }
  .dropdown-menu a { padding-left: 30px; padding-top: 8px; padding-bottom: 8px; }
  .dropdown-menu a:hover { background: #d4af37; color: #000; }
  .dropdown-menu.show { max-height: 1000px; }

  /* Arrow rotation */
  .arrow { display: inline-block; transition: transform 0.3s ease; margin-left: 5px; }
  .dropdown-toggle-btn.open .arrow { transform: rotate(180deg); } 
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const mobileBtn = document.getElementById("mobileMenuBtn");
  const closeBtn = document.getElementById("mobileCloseBtn");
  const navRow = document.querySelector(".nav-row");
  const overlay = document.getElementById("menuOverlay");

  // ================= MOBILE MENU TOGGLE =================
  function openMobileMenu() {
    navRow.classList.add("show");
    overlay.style.display = "block";
  }
  function closeMobileMenu() {
    navRow.classList.remove("show");
    overlay.style.display = "none";
  }

  mobileBtn.addEventListener("click", openMobileMenu);
  closeBtn.addEventListener("click", closeMobileMenu);
  overlay.addEventListener("click", closeMobileMenu);

  // ================= DROPDOWN TOGGLE (Desktop & Mobile) =================
  const dropdownBtns = document.querySelectorAll(".dropdown-toggle-btn");
  dropdownBtns.forEach(btn => {
    btn.addEventListener("click", function(e) {
      e.preventDefault();
      const dropdown = this.nextElementSibling;

      dropdown.classList.toggle("show");
      this.classList.toggle("open");

      dropdownBtns.forEach(otherBtn => {
        if (otherBtn !== btn) {
          otherBtn.nextElementSibling.classList.remove("show");
          otherBtn.classList.remove("open");
        }
      });
    });
  });

  document.addEventListener("click", function(e) {
    dropdownBtns.forEach(btn => {
      if (!btn.contains(e.target) && !btn.nextElementSibling.contains(e.target)) {
        btn.nextElementSibling.classList.remove("show");
        btn.classList.remove("open");
      }
    });
  });

});
</script>
