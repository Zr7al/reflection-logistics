<?php
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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Freight & Logistics Services in Jordan | Reflection Logistics</title>
  <meta name="description" content="Comprehensive Air, Sea, and Land Freight Services in Amman, Jordan. Custom clearance, warehousing, and end-to-end logistics solutions for your supply chain.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://reflectionlogistics.com/services.php">
  <meta name="theme-color" content="#c8391a">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Reflection Logistics">
  <meta property="og:locale" content="<?php echo ($lang === 'ar' ? 'ar_JO' : 'en_US'); ?>">
  <meta property="og:url" content="https://reflectionlogistics.com/services.php">
  <meta property="og:title" content="Freight & Logistics Services — Reflection Logistics">
  <meta property="og:description" content="Comprehensive Air, Sea, and Land Freight Services in Amman, Jordan. Custom clearance and end-to-end logistics solutions.">
  <meta property="og:image" content="https://reflectionlogistics.com/assets/images/air.jpg">
  <link rel="alternate" hreflang="en" href="https://reflectionlogistics.com/services.php">
  <link rel="alternate" hreflang="ar" href="https://reflectionlogistics.com/services.php?lang=ar">
  <link rel="alternate" hreflang="x-default" href="https://reflectionlogistics.com/services.php">

  <link rel="icon" type="image/jpeg" href="assets/images/rff-logo.jpg">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
  <link rel="manifest" href="assets/site.webmanifest">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="image" href="assets/images/logo.png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;600&family=Barlow+Condensed:wght@600;800&family=Tajawal:wght@400;500;700;800&display=swap">
  <link rel="preload" href="assets/css/style.css" as="style">
  <link rel="stylesheet" href="assets/css/style.css">

 </head>
<body>
<?php include 'components/nav.php'; ?>

<main id="main-content">

<!-- ── PAGE HERO ── -->
<section class="page-hero" aria-labelledby="services-hero-heading">
  <div class="page-hero-inner">
    <div class="section-eyebrow"><span data-i18n="svcp_eyebrow">What We Do</span></div>
    <h1 id="services-hero-heading" data-i18n="svcp_h1">Every Route.<br><em>Every Mode.</em></h1>
    <p data-i18n="svcp_sub">From urgent air cargo to full container loads out of Aqaba — we run the full freight stack so your supply chain never skips a beat.</p>
  </div>
 </section>

<!-- ── SERVICES ── -->
<section class="svc-wrap" aria-labelledby="svc-active-heading">
  <div class="svc-inner">

    <h2 id="svc-active-heading" class="sr-only">Active Freight Services</h2>
    <div class="svc-section-label">
      <div class="dot"></div>
      <span data-i18n="svcp_active">Active Services</span>
    </div>

    <div class="svc-grid">

      <!-- Air Freight card -->
      <div class="svc-card">
        <a href="contact.php" class="svc-card-img-link">
          <div class="svc-card-img-wrap">
            <span class="svc-badge"><span class="bdot"></span> Active</span>

            <div class="svc-slider" data-slider>
              <div class="svc-slides">
                <div class="svc-slide" data-slide-index="0">
                  <picture>
                    <source type="image/webp" srcset="assets/images/air-400.webp 400w, assets/images/air-800.webp 800w, assets/images/air-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" src="assets/images/air-800.webp" alt="Air freight cargo at Queen Alia International Airport, Jordan" width="800" height="450" loading="lazy" decoding="async">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="1">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/air2-400.webp 400w, assets/images/air2-800.webp 800w, assets/images/air2-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/air2-800.webp" alt="Air cargo handling for international freight from Jordan" width="800" height="450" loading="lazy" decoding="async" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="2">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/air3-400.webp 400w, assets/images/air3-800.webp 800w, assets/images/air3-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/air3-800.webp" alt="Freight aircraft for time-critical shipments" width="800" height="450" loading="lazy" decoding="async" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
              </div>

              <div class="slider-nav">
                <button class="s-prev" type="button" aria-label="Previous image"></button>
                <button class="s-next" type="button" aria-label="Next image"></button>
              </div>

              <div class="slider-dots">
                <button class="dot active" type="button" data-dot-index="0" aria-label="Slide 1"></button>
                <button class="dot" type="button" data-dot-index="1" aria-label="Slide 2"></button>
                <button class="dot" type="button" data-dot-index="2" aria-label="Slide 3"></button>
              </div>
            </div>
          </div>
        </a>
        <div class="svc-card-body">
          <h3 data-i18n="svcp_air_h">Air Freight</h3>
          <p class="svc-desc" data-i18n="svcp_air_p">Time-critical shipments handled with speed and security. Direct access to major international airports including Queen Alia with full customs support, door-to-door delivery.</p>
          <a href="contact.php" class="svc-cta">
            <span data-i18n="svcp_quote">Get a Quote</span>
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>

      <!-- Sea Freight slider -->
      <div class="svc-card">
        <a href="contact.php" class="svc-card-img-link">
          <div class="svc-card-img-wrap">
            <span class="svc-badge"><span class="bdot"></span> Active</span>

            <div class="svc-slider" data-slider>
              <div class="svc-slides">
                <div class="svc-slide" data-slide-index="0">
                  <picture>
                    <source type="image/webp" srcset="assets/images/sea-400.webp 400w, assets/images/sea-800.webp 800w, assets/images/sea-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" src="assets/images/sea-800.webp" alt="Sea freight container ship at the Port of Aqaba, Jordan" loading="lazy" decoding="async" width="800" height="450">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="1">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/sea2-400.webp 400w, assets/images/sea2-800.webp 800w, assets/images/sea2-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/sea2-800.webp" alt="Container vessel at sea for international freight" loading="lazy" decoding="async" width="800" height="450" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="2">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/sea3-400.webp 400w, assets/images/sea3-800.webp 800w, assets/images/sea3-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/sea3-800.webp" alt="Port operations with stacked shipping containers" loading="lazy" decoding="async" width="800" height="450" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
              </div>

              <div class="slider-nav">
                <button class="s-prev" type="button" aria-label="Previous image"></button>
                <button class="s-next" type="button" aria-label="Next image"></button>
              </div>

              <div class="slider-dots">
                <button class="dot active" type="button" data-dot-index="0" aria-label="Slide 1"></button>
                <button class="dot" type="button" data-dot-index="1" aria-label="Slide 2"></button>
                <button class="dot" type="button" data-dot-index="2" aria-label="Slide 3"></button>
              </div>
            </div>
          </div>
        </a>
        <div class="svc-card-body">
          <h3 data-i18n="svcp_sea_h">Sea Freight</h3>
          <p class="svc-desc" data-i18n="svcp_sea_p">International container shipping via the Port of Aqaba and major global ports. FCL and LCL options with competitive transit times, full port operations management, and end-to-end cargo visibility from origin to destination.</p>
          <a href="contact.php" class="svc-cta">
            <span data-i18n="svcp_quote">Get a Quote</span>
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>

      <!-- Land Freight slider -->
      <div class="svc-card">
        <a href="contact.php" class="svc-card-img-link">
          <div class="svc-card-img-wrap">
            <span class="svc-badge"><span class="bdot"></span> Active</span>

            <div class="svc-slider" data-slider>
              <div class="svc-slides">
                <div class="svc-slide" data-slide-index="0">
                  <picture>
                    <source type="image/webp" srcset="assets/images/land-400.webp 400w, assets/images/land-800.webp 800w, assets/images/land-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" src="assets/images/land-800.webp" alt="Land freight truck crossing Jordan-Saudi Arabia border on GCC highway" loading="lazy" decoding="async" width="800" height="450">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="1">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/land2-400.webp 400w, assets/images/land2-800.webp 800w, assets/images/land2-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/land2-800.webp" alt="Fleet of trucks prepared for regional land freight" loading="lazy" decoding="async" width="800" height="450" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="2">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/land3-400.webp 400w, assets/images/land3-800.webp 800w, assets/images/land3-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/land3-800.webp" alt="Truck driving along GCC logistics corridor at sunset" loading="lazy" decoding="async" width="800" height="450" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
              </div>

              <div class="slider-nav">
                <button class="s-prev" type="button" aria-label="Previous image"></button>
                <button class="s-next" type="button" aria-label="Next image"></button>
              </div>

              <div class="slider-dots">
                <button class="dot active" type="button" data-dot-index="0" aria-label="Slide 1"></button>
                <button class="dot" type="button" data-dot-index="1" aria-label="Slide 2"></button>
                <button class="dot" type="button" data-dot-index="2" aria-label="Slide 3"></button>
              </div>
            </div>
          </div>
        </a>    
        <div class="svc-card-body">
          <h3 data-i18n="svcp_land_h">Land Freight</h3>
          <p class="svc-desc" data-i18n="svcp_land_p">Cross-border road transport covering Jordan, Saudi Arabia, UAE, and the wider GCC. Flexible FTL and LTL options with full door-to-door delivery and dedicated fleet management across all major corridors.</p>
          <a href="contact.php" class="svc-cta">
            <span data-i18n="svcp_quote">Get a Quote</span>
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>

      <!-- Customs Clearance slider -->
      <div class="svc-card">
        <a href="contact.php" class="svc-card-img-link">
          <div class="svc-card-img-wrap">
            <span class="svc-badge"><span class="bdot"></span> Active</span>

            <div class="svc-slider" data-slider>
              <div class="svc-slides">
                <div class="svc-slide" data-slide-index="0">
                  <picture>
                    <source type="image/webp" srcset="assets/images/customs-400.webp 400w, assets/images/customs.webp 600w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" src="assets/images/customs-400.webp" alt="Customs clearance documentation and inspection at Jordanian port of entry" loading="lazy" decoding="async" width="800" height="450">
                  </picture>
                </div>
                <div class="svc-slide" data-slide-index="1">
                  <picture>
                    <source type="image/webp" data-srcset="assets/images/customs3-400.webp 400w, assets/images/customs3-800.webp 800w, assets/images/customs3-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
                    <img class="svc-card-img" data-src="assets/images/customs3-800.webp" alt="Customs documentation and tariff classification for Jordan imports" loading="lazy" decoding="async" width="800" height="450" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==">
                  </picture>
                </div>
              </div>

              <div class="slider-nav">
                <button class="s-prev" type="button" aria-label="Previous image"></button>
                <button class="s-next" type="button" aria-label="Next image"></button>
              </div>

              <div class="slider-dots">
                <button class="dot active" type="button" data-dot-index="0" aria-label="Slide 1"></button>
                <button class="dot" type="button" data-dot-index="1" aria-label="Slide 2"></button>
              </div>

            </div>
          </div>
        </a>
        <div class="svc-card-body">
          <h3 data-i18n="svcp_customs_h">Customs Clearance</h3>
          <p class="svc-desc" data-i18n="svcp_customs_p">Full customs brokerage and documentation handling at all Jordanian ports of entry. We manage tariff classification, duty assessment, and regulatory compliance so your cargo clears without delays or penalties.</p>
          <a href="contact.php" class="svc-cta">
            <span data-i18n="svcp_quote">Get a Quote</span>
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>

    </div>

    <div class="svc-section-label soon">
      <div class="dot"></div>
      <span data-i18n="svcp_soon">Coming Soon</span>
    </div>

    <div class="svc-grid">
      <div class="svc-card coming-soon">
        <div class="svc-card-img-wrap">
          <span class="svc-badge coming"><span class="bdot"></span> <span data-i18n="svcp_soon">Coming Soon</span></span>
          <picture>
            <source type="image/webp" srcset="assets/images/warehousing-400.webp 400w, assets/images/warehousing-800.webp 800w, assets/images/warehousing-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
            <img class="svc-card-img" src="assets/images/warehousing-800.webp" alt="Managed warehousing and inventory facility in Amman, Jordan" loading="lazy" decoding="async" width="600" height="400">
          </picture>
          <div class="coming-overlay"><div class="coming-overlay-tag" data-i18n="svcp_soon">Coming Soon</div></div>
        </div>
        <div class="svc-card-body">
          <h3 data-i18n="svcp_wh_h">Warehousing</h3>
          <p class="svc-desc" data-i18n="svcp_wh_p">Secure, managed storage facilities with inventory control, pick-and-pack operations, and seamless integration with your freight movements. Launching soon across strategic locations in Jordan.</p>
          <button type="button" class="svc-cta disabled" disabled data-i18n="svcp_notyet">Not Available Yet</button>
        </div>
      </div>

      <div class="svc-card coming-soon">
        <div class="svc-card-img-wrap">
          <span class="svc-badge coming"><span class="bdot"></span> <span data-i18n="svcp_soon">Coming Soon</span></span>
          <picture>
            <source type="image/webp" srcset="assets/images/project-400.webp 400w, assets/images/project-800.webp 800w, assets/images/project-1200.webp 1200w" sizes="(min-width: 1024px) 50vw, 100vw">
            <img class="svc-card-img" src="assets/images/project-800.webp" alt="Heavy lift project cargo and oversized freight transport for industrial projects" loading="lazy" decoding="async" width="600" height="400">
          </picture>
          <div class="coming-overlay"><div class="coming-overlay-tag" data-i18n="svcp_soon">Coming Soon</div></div>
        </div>
        <div class="svc-card-body">
          <h3 data-i18n="svcp_proj_h">Project Cargo</h3>
          <p class="svc-desc" data-i18n="svcp_proj_p">Heavy lift, oversized, and out-of-gauge cargo solutions for large-scale industrial and infrastructure projects. Custom engineered transport plans, specialized equipment, and dedicated project management.</p>
          <button type="button" class="svc-cta disabled" disabled data-i18n="svcp_notyet">Not Available Yet</button>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ── TRUST / CERTIFICATIONS STRIP ── -->
<div class="trust-strip">
  <div class="trust-strip-inner">
    <p class="trust-label" data-i18n="trust_label">Memberships & Certifications</p>
    <div class="trust-logos">
      <div class="trust-item" title="Jordan International Freight Forwarders Association">
        <div class="trust-item-badge">JIFFA</div>
        <span class="trust-item-label">Member</span>
      </div>
      <div class="trust-item" title="International Air Transport Association">
        <div class="trust-item-badge">IATA</div>
        <span class="trust-item-label">Accredited</span>
      </div>
      <div class="trust-item" title="International Federation of Freight Forwarders Associations">
        <div class="trust-item-badge">FIATA</div>
        <span class="trust-item-label">Member</span>
      </div>
      <div class="trust-item" title="ISO 9001 Quality Management">
        <div class="trust-item-badge">ISO<br>9001</div>
        <span class="trust-item-label">Certified</span>
      </div>
      <div class="trust-item" title="Authorized Economic Operator">
        <div class="trust-item-badge">AEO</div>
        <span class="trust-item-label">Authorized</span>
      </div>
    </div>
  </div>
</div>

<!-- ── CTA STRIP ── -->
<div class="svc-cta-strip">
  <div class="svc-cta-strip-inner">
    <div>
      <h2 data-i18n="svcp_cta_h">Ready to Move<br><em>Your Cargo?</em></h2>
      <p data-i18n="svcp_cta_p">Tell us what you need to ship and our team will get back to you with a tailored solution within 24 hours.</p>
    </div>
    <a href="contact.php" class="svc-cta-strip-btn">
      <span data-i18n="svcp_cta_btn">Contact Us</span>
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
 </div>

</main>

<?php include 'components/footer.php'; ?>

<script src="assets/js/I18n.js" defer></script>
<script src="assets/js/main.js" defer></script>
</body>
</html>
