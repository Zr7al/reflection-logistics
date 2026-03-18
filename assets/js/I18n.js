/* ============================================================
   i18n.js — Bilingual EN/AR for Reflection Logistics
   Scalable: translations in /locales/en.json, /locales/ar.json
   ============================================================ */

const SUPPORTED_LANGS = ['en', 'ar'];
const DEFAULT_LANG = 'en';
const STORAGE_KEY = 'rl_lang';
const LOCALES_BASE = 'locales';

/* ── 1. DETERMINE LANGUAGE (URL > localStorage > browser > default) ── */
function resolveLang() {
  const params = new URLSearchParams(location.search);
  const urlLang = params.get('lang');
  if (urlLang && SUPPORTED_LANGS.includes(urlLang)) return urlLang;

  try {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored && SUPPORTED_LANGS.includes(stored)) return stored;
  } catch (e) {}

  const browser = (navigator.language || navigator.userLanguage || '').toLowerCase();
  if (browser.startsWith('ar')) return 'ar';
  return DEFAULT_LANG;
}

/* ── 2. SET DIRECTION IMMEDIATELY (Fixed for RTL Scroll Bug) ── */
const initialLang = resolveLang();
document.documentElement.lang = initialLang;
document.documentElement.dir = initialLang === 'ar' ? 'rtl' : 'ltr';
document.documentElement.dataset.langReady = 'false';

if (initialLang === 'ar') {
  // Force the browser to recognize the right edge as the starting point
  document.documentElement.style.scrollBehavior = 'auto';
  window.scrollTo(document.documentElement.scrollWidth, 0);
  
  requestAnimationFrame(() => {
    document.documentElement.scrollLeft = 0;
    if (document.body) document.body.scrollLeft = 0;
    document.documentElement.style.scrollBehavior = 'smooth';
  });
}

/* ── 3. LOAD TRANSLATIONS FROM JSON ── */
let translations = { en: null, ar: null };

function getLocalesPath(lang) {
  const base = location.pathname.replace(/\/[^/]*$/, '') || '';
  return (base ? base + '/' : './') + LOCALES_BASE + '/' + lang + '.json';
}

async function loadLocale(lang) {
  if (translations[lang]) return translations[lang];
  const res = await fetch(getLocalesPath(lang));
  if (!res.ok) throw new Error('Locale load failed: ' + lang);
  translations[lang] = await res.json();
  return translations[lang];
}

/* ── 4. TRANSLATION RENDERER ── */
const ATTR_MAP = [
  { attr: 'data-i18n', set: (el, v) => { el.innerHTML = v; } },
  { attr: 'data-i18n-placeholder', set: (el, v) => { el.placeholder = v; } },
  { attr: 'data-i18n-title', set: (el, v) => { el.setAttribute('title', v); } },
  { attr: 'data-i18n-alt', set: (el, v) => { el.setAttribute('alt', v); } }
];

function getT(key, lang) {
  const t = translations[lang];
  return (t && t[key]) || (translations.en && translations.en[key]) || '';
}

function applyTranslations(lang) {
  ATTR_MAP.forEach(({ attr, set }) => {
    const keyAttr = attr === 'data-i18n' ? 'i18n' : 'i18n' + attr.replace('data-i18n-', '').replace(/-([a-z])/g, (_, c) => c.toUpperCase()).replace(/^./, c => c.toUpperCase());
    document.querySelectorAll('[' + attr + ']').forEach(el => {
      const key = el.dataset[keyAttr] ?? el.getAttribute(attr);
      if (!key) return;
      const value = getT(key, lang);
      if (value) set(el, value);
    });
  });
}

document.addEventListener('i18nApply', () => {
  const lang = document.documentElement.lang || DEFAULT_LANG;
  applyTranslations(lang);
});

/* ── 5. MAIN ENTRY POINT ── */
async function applyLang(lang) {
  if (!SUPPORTED_LANGS.includes(lang)) lang = DEFAULT_LANG;

  try {
    await loadLocale(lang);
    if (lang !== 'en') await loadLocale('en'); // fallback
  } catch (e) {
    console.warn('I18n: locale load failed', e);
    if (!translations.en) translations.en = {};
    if (!translations[lang]) translations[lang] = {};
  }

  applyTranslations(lang);

  document.documentElement.lang = lang;

  const path = (location.pathname.split('/').pop() || '').toLowerCase();
  if (path === 'careers.html') {
    // Keep careers page layout LTR even when Arabic text is active
    document.documentElement.dir = 'ltr';
  } else {
    document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
  }

  if (lang === 'ar') {
    requestAnimationFrame(() => {
      document.documentElement.scrollLeft = 0;
      document.body.scrollLeft = 0;
    });
  }

  try {
    localStorage.setItem(STORAGE_KEY, lang);
  } catch (e) {}

  const btn = document.getElementById('langToggle');
  if (btn) {
    // If we're on careers page, keep button label but make it visually/semantically disabled.
    const isCareers = location.pathname.split('/').pop().split('?')[0] === 'careers.html';
    btn.textContent = lang === 'ar' ? 'EN' : 'عربي';
    btn.setAttribute('aria-label', lang === 'ar' ? 'Switch to English' : 'التبديل إلى العربية');
    if (isCareers) {
      btn.setAttribute('aria-disabled', 'true');
      btn.style.opacity = '0.4';
      btn.style.cursor = 'not-allowed';
    } else {
      btn.removeAttribute('aria-disabled');
      btn.style.opacity = '';
      btn.style.cursor = '';
    }
  }

  const t = translations[lang];
  const inner = document.querySelector('.ticker-inner');
  if (inner && t && Array.isArray(t.ticker_items)) {
    const track = document.createElement('div');
    track.className = 'ticker-track';
    track.replaceChildren(...t.ticker_items.map(item => {
      const span = document.createElement('span');
      if (item === '—') span.className = 'sep';
      span.textContent = item;
      return span;
    }));
    const clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    inner.replaceChildren(track, clone);
  }

  document.documentElement.dataset.langReady = 'true';

  if (typeof renderProject === 'function' && typeof getProjectId === 'function') {
    try {
      renderProject(getProjectId());
    } catch (e) {}
  }
}

/* ── 6. INIT (runs after nav/footer components loaded) ── */
async function initI18n() {
  const lang = resolveLang();
  await applyLang(lang);

  const btn = document.getElementById('langToggle');
  if (btn) {
    btn.addEventListener('click', () => {
      const isCareers = location.pathname.split('/').pop().split('?')[0] === 'careers.html';
      if (isCareers) return; // disabled on careers page
      const current = (() => {
        try { return localStorage.getItem(STORAGE_KEY); } catch (e) { return ''; }
      })() || DEFAULT_LANG;
      applyLang(current === 'en' ? 'ar' : 'en');
    });
  }
}

document.addEventListener('componentsLoaded', initI18n);
