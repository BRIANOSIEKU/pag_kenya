<!-- Premium Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<header id="mainHeader" class="header">

  <div class="header-inner">

    <!-- Decorative Lines -->
    <div class="line-decoration line-1"></div>
    <div class="line-decoration line-2"></div>

    <!-- Top Row -->
    <div class="top-row">

      <!-- Logo -->
      <img src="{{ asset('images/pagk_logo.png') }}" alt="PAG Kenya Logo" class="header-logo">

      <!-- Title + Slogan -->
      <div class="title-wrapper">
        <div class="header-title">
          THE PENTECOSTAL ASSEMBLIES OF GOD - KENYA
        </div>
        <div class="header-slogan">
          Empowering communities through faith and service
        </div>
      </div>

      <!-- Contact -->
      <div class="contact-info">
        <span>
          <svg width="16" height="16" fill="none" stroke="white" stroke-width="1.6" viewBox="0 0 24 24">
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
          +254 700 000 000
        </span>

        <span>
          <svg width="16" height="16" fill="none" stroke="white" stroke-width="1.6" viewBox="0 0 24 24">
            <path d="M4 4h16v16H4z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
          info@pagkenya.org
        </span>
      </div>
    </div>

    <!-- Centered Navigation -->
    <div class="nav-row">
      <div class="nav-dropdown">
        <a href="{{ url('/') }}" class="nav-link">Home</a>
      </div>
      <div class="nav-dropdown">
        <a href="#church-profile" class="nav-link">Church Profile</a>
        <div class="dropdown-menu">
          <a href="#overview">Overview</a>
          <a href="#vision-mission">Vision & Mission</a>
          <a href="#core-values">Core Values</a>
          <a href="#statement-of-faith">Statement of Faith</a>
        </div>
      </div>
      <div class="nav-dropdown">
        <a href="#leadership" class="nav-link">Leadership</a>
        <div class="dropdown-menu">
          <a href="#executive-committee">Executive Committee</a>
          <a href="#church-council">Church Council</a>
          <a href="#hq-staff">PAG Kenya HQ Staff</a>
        </div>
      </div>
      <div class="nav-dropdown">
        <a href="#departments" class="nav-link">Departments</a>
        <div class="dropdown-menu">
          <a href="#national-women">National Women Dept</a>
          <a href="#ceyd">National CEYD</a>
          <a href="#missions">Missions Dept</a>
          <a href="#education">Education Dept</a>
          <a href="#special-programs">Special Programs</a>
          <a href="#pbc">Pentecostal Bible College</a>
          <a href="#goibei-hospital">Goibei Mission Hospital</a>
          <a href="#radio-matumaini">Radio Matumaini</a>
          <a href="#nitc">NITC</a>
        </div>
      </div>
      <div class="nav-dropdown">
        <a href="#news" class="nav-link">News</a>
      </div>
      <div class="nav-dropdown">
        <a href="#projects" class="nav-link">Projects</a>
      </div>
      <div class="nav-dropdown">
        <a href="#devotions" class="nav-link">Daily Devotions</a>
      </div>
      <div class="nav-dropdown">
        <a href="#giving" class="nav-link">Giving / Donations</a>
      </div>
      <div class="nav-dropdown">
        <a href="#contact" class="nav-link">Contact</a>
      </div>
    </div>

  </div>
</header>

<style>
/* HEADER BASE */
.header {
  background: rgba(15, 60, 120, 0.95); /* Blue */
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  position: sticky;
  top: 0;
  z-index: 1000;
  transition: all 0.4s ease;
  border-bottom: 2px solid rgba(212,175,55,0.35); /* Gold accent */
}

/* Header inner container */
.header-inner {
  max-width: 1300px;
  margin: 0 auto;
  padding: 16px 30px 10px;
  position: relative;
}

/* Decorative Lines */
.line-decoration {
  position: absolute;
  height: 2px;
  background: linear-gradient(90deg, rgba(212,175,55,0.45), transparent);
}
.line-1 { width: 90px; top: 18px; left: 30px; transform: rotate(18deg); }
.line-2 { width: 60px; top: 40px; left: 150px; transform: rotate(-15deg); }

/* Top Layout */
.top-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 25px;
}

/* Logo */
.header-logo {
  height: 130px;
  transition: all 0.4s ease;
  object-fit: contain;
}

/* Typography */
.header-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  color: #F5F5F5; /* Soft Ivory */
  line-height: 1.1;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.2), 0 0 6px rgba(255,255,255,0.1);
}

.header-slogan {
  font-family: 'Inter', sans-serif;
  font-size: 0.9rem;
  margin-top: 4px;
  font-style: italic;
  color: #d4af37; /* Gold */
  text-shadow: none;
}

/* Contact */
.contact-info {
  display: flex;
  gap: 20px;
  font-size: 0.85rem;
  color: #fff;
  font-family: 'Inter', sans-serif;
}

/* Centered Navigation */
.nav-row {
  margin-top: 10px;
  display: flex;
  justify-content: center;
  gap: 40px;
  font-family: 'Inter', sans-serif;
  font-weight: 500;
}

/* Nav Links */
.nav-link {
  text-decoration: none;
  color: #fff;
  position: relative;
  font-size: 0.9rem;
  background: transparent !important;
  transition: color 0.3s ease;
}

.nav-link::after {
  content: "";
  position: absolute;
  width: 100%;
  height: 2px;
  bottom: -6px;
  left: 0;
  background: linear-gradient(90deg, #d4af37, #b8860b);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s ease;
}

.nav-link:hover {
  color: #d4af37;
}
.nav-link:hover::after { transform: scaleX(1); }

/* Dropdown */
.nav-dropdown { position: relative; }
.dropdown-menu {
  position: absolute;
  top: 32px;
  left: 0;
  display: none;
  flex-direction: column;
  background: #4CAF50; /* Grass Green background */
  padding: 8px 0;
  min-width: 180px;
  z-index: 1001;
  border-radius: 4px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.dropdown-menu a {
  padding: 8px 20px;
  color: #fff;
  font-size: 0.85rem;
  text-decoration: none;
  transition: background 0.3s ease, color 0.3s ease;
}
.dropdown-menu a:hover {
  color: #fff;
  background: rgba(255,255,255,0.15);
}
.nav-dropdown:hover .dropdown-menu { display: flex; flex-direction: column; }

/* Scroll Shrink Effect */
.header.shrink .header-inner { padding: 8px 30px 6px; }
.header.shrink .header-logo { height: 95px; }
.header.shrink .nav-row { margin-top: 8px; }

/* Responsive tweaks */
@media (max-width: 992px) {
  .top-row { flex-direction: column; align-items: flex-start; gap: 12px; }
  .header-logo { height: 100px !important; }
  .header-title { font-size: 1.25rem !important; }
  .header-slogan { font-size: 0.85rem !important; }
  .nav-row { gap: 25px; flex-wrap: wrap; }
  .dropdown-menu { min-width: 140px; }
}

@media (max-width: 600px) {
  .header-logo { height: 80px !important; }
  .header-title { font-size: 1rem !important; }
  .header-slogan { font-size: 0.75rem !important; }
  .nav-row { gap: 15px; }
  .dropdown-menu { min-width: 120px; }
}
</style>

<script>
window.addEventListener("scroll", function() {
  const header = document.getElementById("mainHeader");
  if (window.scrollY > 80) { header.classList.add("shrink"); }
  else { header.classList.remove("shrink"); }
});
</script>
