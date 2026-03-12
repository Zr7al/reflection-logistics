<?php
// PHP-based language detection to prevent FOUC (Flash of Untranslated Content)
$supported_langs = ['en', 'ar'];
$default_lang = 'en';
$lang = $default_lang;

if (isset($_GET['lang']) && in_array($_GET['lang'], $supported_langs)) {
    $lang = $_GET['lang'];
} elseif (isset($_COOKIE['rl_lang']) && in_array($_COOKIE['rl_lang'], $supported_langs)) {
    $lang = $_COOKIE['rl_lang'];
} else {
    $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
    if ($browser_lang === 'ar') $lang = 'ar';
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $dir; ?>" data-lang-ready="false">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reflection Logistics — Jordan's Global Freight Partner</title>
  <meta name="description" content="Reflection Logistics — Jordan's Global Freight Partner. End-to-end freight solutions connecting Jordan to the world by sea, air, and land.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://reflectionlogistics.com/">
  <meta name="theme-color" content="#c8391a">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Reflection Logistics">
  <meta property="og:locale" content="<?php echo ($lang === 'ar' ? 'ar_JO' : 'en_US'); ?>">
  <meta property="og:url" content="https://reflectionlogistics.com/">
  <meta property="og:title" content="Reflection Logistics — Jordan's Global Freight Partner">
  <meta property="og:description" content="End-to-end freight solutions connecting Jordan to the world by sea, air, and land. Air, sea, and land freight from Amman. Customs clearance at Port of Aqaba.">
  <meta property="og:image" content="https://reflectionlogistics.com/assets/images/hero.jpg">
  <meta name="twitter:card" content="summary_large_image">
  <link rel="alternate" hreflang="en" href="https://reflectionlogistics.com/">
  <link rel="alternate" hreflang="ar" href="https://reflectionlogistics.com/?lang=ar">
  <link rel="alternate" hreflang="x-default" href="https://reflectionlogistics.com/">

  <link rel="icon" type="image/jpeg" href="assets/images/rff-logo.jpg">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
  <link rel="manifest" href="assets/site.webmanifest">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="preload" as="image" href="assets/images/hero-960.webp" imagesrcset="assets/images/hero-480.webp 480w, assets/images/hero-960.webp 960w, assets/images/hero-1280.webp 1280w" imagesizes="(min-width: 1200px) 1200px, 100vw" fetchpriority="high">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;600&family=Barlow+Condensed:wght@600;800&family=Tajawal:wght@400;500;700;800&display=swap">
  
  <link rel="preload" href="assets/css/style.css" as="style">
  <link rel="stylesheet" href="assets/css/style.css">

 </head>
<body>

  <?php include 'components/nav.php'; ?>

  <main id="main-content">

  <!-- ── HERO ── -->
  <section class="hero">
    <picture>
      <source type="image/avif" srcset="assets/images/hero-480.avif 480w, assets/images/hero-960.avif 960w, assets/images/hero-1280.avif 1280w" sizes="(min-width: 1200px) 1200px, 100vw">
      <source type="image/webp" srcset="assets/images/hero-480.webp 480w, assets/images/hero-960.webp 960w, assets/images/hero-1280.webp 1280w" sizes="(min-width: 1200px) 1200px, 100vw">
      <img class="hero-img-tag" src="assets/images/hero-960.webp" alt="Reflection Logistics — Jordan's Global Freight Partner" width="1280" height="720" loading="eager" fetchpriority="high" decoding="async">
    </picture>
    <div class="hero-content">
      <div class="hero-eyebrow"><span data-i18n="hero_eyebrow">Jordan's Global Freight Partner</span></div>
      <h1 data-i18n="hero_h1">Move<br>Cargo.<br><em>Move</em><br>Markets.</h1>
      <p class="hero-sub" data-i18n="hero_sub">End-to-end freight solutions connecting Jordan to the world — by sea, air, and land. Precision at every step.</p>
    </div>
    <div class="hero-bottom">
      <div class="scroll-hint" data-i18n="scroll_hint">Scroll</div>
    </div>
  </section>

  <!-- ── TICKER ── -->
  <div class="ticker-wrap" aria-hidden="true">
    <div class="ticker-inner">
      <div class="ticker-track">
        <span>Air Freight</span><span class="sep">—</span>
        <span>Land Freight</span><span class="sep">—</span>
        <span>Sea Freight</span><span class="sep">—</span>
        <span>Customs Clearance</span><span class="sep">—</span>
        <span>Air Freight</span><span class="sep">—</span>
        <span>Land Freight</span><span class="sep">—</span>
        <span>Sea Freight</span><span class="sep">—</span>
        <span>Customs Clearance</span><span class="sep">—</span>
      </div>
    </div>
  </div>

  <!-- ── ABOUT ── -->
  <section class="about-wrap" aria-labelledby="about-heading">
    <div class="about">
      <div>
        <div class="section-eyebrow reveal"><span data-i18n="about_eyebrow">Who We Are</span></div>
        <h2 id="about-heading" class="reveal reveal-d1" data-i18n="about_h2">Built on Trust.<br>Driven by Precision.</h2>
        <p class="reveal reveal-d2" data-i18n="about_p1">Reflection Logistics is an Amman-based freight and supply chain company operating at the intersection of regional expertise and global reach. Over a decade of moving cargo across borders so our clients never have to stress about it.</p>
        <p class="reveal reveal-d2" data-i18n="about_p2">Whether it's a container out of Aqaba or urgent air cargo through Queen Alia — we handle the complexity while you handle your business.</p>
        <a href="about.php" class="read-more reveal reveal-d3">
          <span data-i18n="about_readmore">Read More</span>
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <div class="about-stats">
          <div class="astat reveal reveal-d1">
            <div class="astat-num stat-number" data-target="10" data-suffix="+">0</div>
            <div class="astat-label" data-i18n="stat_years">Years in Operation</div>
          </div>
          <div class="astat reveal reveal-d2">
            <div class="astat-num stat-number" data-target="5" data-suffix="K+">0</div>
            <div class="astat-label" data-i18n="stat_shipments">Shipments Delivered</div>
          </div>
          <div class="astat reveal reveal-d1">
            <div class="astat-num stat-number" data-target="8" data-suffix="">0</div>
            <div class="astat-label" data-i18n="stat_countries">Countries Served</div>
          </div>
          <div class="astat reveal reveal-d2">
            <div class="astat-num stat-number" data-target="24" data-suffix="/7">0</div>
            <div class="astat-label" data-i18n="stat_support">Operations Support</div>
          </div>
        </div>
      </div>
      <div class="about-imgs reveal reveal-d2">
        <picture>
          <source type="image/webp" srcset="assets/images/about-1-400.webp 400w, assets/images/about-1-800.webp 800w, assets/images/about-1-1200.webp 1200w" sizes="(min-width: 1100px) 50vw, 100vw">
          <img src="assets/images/about-1-800.webp" alt="Reflection Logistics freight operations in Amman, Jordan" loading="lazy" decoding="async" width="600" height="400">
        </picture>
        <picture>
          <source type="image/webp" srcset="assets/images/about-2-400.webp 400w, assets/images/about-2.webp 900w" sizes="(min-width: 1100px) 50vw, 100vw">
          <img src="assets/images/about-2-400.webp" alt="Reflection Logistics fleet and cargo handling in Jordan" loading="lazy" decoding="async" width="600" height="400">
        </picture>
      </div>
    </div>
  </section>

  <!-- ── SERVICES ── -->
  <section class="services-wrap" aria-labelledby="services-heading">
    <div class="services">
      <div class="section-head">
        <div class="section-eyebrow reveal"><span data-i18n="svc_eyebrow">Core Services</span></div>
        <h2 id="services-heading" class="reveal reveal-d1" data-i18n="svc_h2">Every Route.<br>Every Mode.</h2>
        <p class="reveal reveal-d2" data-i18n="svc_sub">From deep-sea containers to same-day air cargo — we've got the infrastructure to move it.</p>
      </div>
      <div class="services-grid">
        <div class="scard reveal reveal-d1">
          <div class="scard-img-wrap">
            <picture>
              <source type="image/webp" srcset="assets/images/air-400.webp 400w, assets/images/air-800.webp 800w, assets/images/air-1200.webp 1200w" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw">
              <img class="scard-img" src="assets/images/air-800.webp" alt="Air freight cargo at Queen Alia International Airport, Jordan" loading="lazy" decoding="async" width="800" height="450">
            </picture>
          </div>
          <div class="scard-body">
            <h3 data-i18n="svc_air_h">Air Freight</h3>
            <p data-i18n="svc_air_p">Time-critical shipments handled with speed and security. Direct access to major international airports with full customs support.</p>
            <a href="services.php" class="scard-btn">
              <span data-i18n="svc_learn">Learn More</span>
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
        <div class="scard reveal reveal-d2">
          <div class="scard-img-wrap">
            <picture>
              <source type="image/webp" srcset="assets/images/land-400.webp 400w, assets/images/land-800.webp 800w, assets/images/land-1200.webp 1200w" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw">
              <img class="scard-img" src="assets/images/land-800.webp" alt="Land freight truck on GCC highway for cross-border Jordan freight" loading="lazy" decoding="async" width="800" height="450">
            </picture>
          </div>
          <div class="scard-body">
            <h3 data-i18n="svc_land_h">Land Freight</h3>
            <p data-i18n="svc_land_p">Cross-border road transport covering Jordan, Saudi Arabia, UAE, and the wider GCC. Flexible FTL and LTL options with full door-to-door delivery.</p>
            <a href="services.php" class="scard-btn">
              <span data-i18n="svc_learn">Learn More</span>
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
        <div class="scard reveal reveal-d3">
          <div class="scard-img-wrap">
            <picture>
              <source type="image/webp" srcset="assets/images/sea-400.webp 400w, assets/images/sea-800.webp 800w, assets/images/sea-1200.webp 1200w" sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw">
              <img class="scard-img" src="assets/images/sea-800.webp" alt="Container shipping at Port of Aqaba, Jordan" loading="lazy" decoding="async" width="800" height="450">
            </picture>
          </div>
          <div class="scard-body">
            <h3 data-i18n="svc_sea_h">Sea Freight</h3>
            <p data-i18n="svc_sea_p">International container shipping via Aqaba and global ports. FCL and LCL options with competitive transit times and full port operations management.</p>
            <a href="services.php" class="scard-btn">
              <span data-i18n="svc_learn">Learn More</span>
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pre-footer CTA -->
  <section class="index-prefooter-cta" aria-labelledby="cta-heading">
    <div class="index-prefooter-inner">
      <div class="index-prefooter-left">
        <div class="section-eyebrow"><span data-i18n="cta_eyebrow">Ready to Ship?</span></div>
        <h2 id="cta-heading" data-i18n="cta_h">Let's Move<br><em>Your Cargo.</em></h2>
      </div>
      <div class="index-prefooter-right">
        <p data-i18n="cta_p">Tell us what you need to ship and our team will get back to you with a tailored freight solution within 24 hours.</p>
        <a href="contact.php" class="index-prefooter-btn">
          <span data-i18n="cta_btn">Get In Touch</span>
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>

  </main>
  
  <?php include 'components/footer.php'; ?>

<script src="assets/js/I18n.js" defer></script>
<script src="assets/js/main.js" defer></script>
</body>
</html>
