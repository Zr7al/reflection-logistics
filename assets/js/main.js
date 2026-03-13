/**
 * REFLECTION LOGISTICS — main.js
 * Enhanced build — sanitized, secure, and logically audited.
 */

(() => {
'use strict'

/* ─────────────────────────────
CONFIG
───────────────────────────── */

const FETCH_TIMEOUT = 10000

const fetchWithTimeout = (url, options = {}) => {
  const controller = new AbortController()
  const timer = setTimeout(() => controller.abort(), FETCH_TIMEOUT)
  return fetch(url, { ...options, signal: controller.signal })
    .finally(() => clearTimeout(timer))
}


/* ─────────────────────────────
TOAST NOTIFICATIONS
───────────────────────────── */

const initToasts = () => {
  if (document.getElementById('toast-container')) return
  const container = document.createElement('div')
  container.id = 'toast-container'
  Object.assign(container.style, {
    position: 'fixed',
    bottom: '88px',
    right: '28px',
    display: 'flex',
    flexDirection: 'column',
    gap: '10px',
    zIndex: '10000',
    pointerEvents: 'none'
  })
  document.body.appendChild(container)
}

const isRTL = () => document.documentElement.dir === 'rtl'

window.showToast = (msg, type = 'info', duration = 4000) => {
  const container = document.getElementById('toast-container')
  if (!container) return

  const colors = {
    success: '#48c848',
    error:   '#c8391a',
    info:    'rgba(255,255,255,0.25)'
  }
  const border = colors[type] || colors.info
  const slideIn = isRTL() ? '-20px' : '20px'

  const toast = document.createElement('div')
  Object.assign(toast.style, {
    background: '#1a1918',
    borderLeft: `3px solid ${border}`,
    border: `1px solid rgba(255,255,255,0.08)`,
    borderLeftColor: border,
    padding: '12px 16px',
    color: '#f5f0eb',
    fontSize: '13px',
    borderRadius: '5px',
    boxShadow: '0 4px 20px rgba(0,0,0,0.4)',
    opacity: '0',
    transform: `translateX(${slideIn})`,
    transition: 'opacity .25s ease, transform .25s ease',
    pointerEvents: 'all',
    cursor: 'pointer',
    maxWidth: '300px'
  })
  toast.textContent = msg
  toast.addEventListener('click', () => removeToast(toast))
  container.appendChild(toast)

  requestAnimationFrame(() => requestAnimationFrame(() => {
    toast.style.opacity = '1'
    toast.style.transform = 'translateX(0)'
  }))

  const timer = setTimeout(() => removeToast(toast), duration)
  toast._timer = timer
}

const removeToast = toast => {
  clearTimeout(toast._timer)
  const slideOut = isRTL() ? '-20px' : '20px'
  toast.style.opacity = '0'
  toast.style.transform = `translateX(${slideOut})`
  setTimeout(() => toast.remove(), 260)
}


/* ─────────────────────────────
IMAGE LOADING
───────────────────────────── */

const initImageLoading = () => {
  const imgs = document.querySelectorAll('img')

  imgs.forEach(img => {
    const isHero = img.classList.contains('hero-img-tag') || img.closest('.hero')

    // Normalize lazy-loading for all non-hero imagery
    if (!isHero && !img.hasAttribute('loading')) {
      img.setAttribute('loading', 'lazy')
    }

    const markLoaded = () => {
      img.classList.add('img-loaded')
      const wrap = img.closest('.svc-card-img-wrap, .scard-img-wrap, .proj-card-img-wrap')
      if (wrap) wrap.classList.add('img-wrap-loaded')
    }
    if (img.complete && img.naturalWidth) return markLoaded()
    img.addEventListener('load',  markLoaded, { once: true })
    img.addEventListener('error', markLoaded, { once: true })
  })
}


/* ─────────────────────────────
SCROLL OBSERVER
handles reveal + counters
───────────────────────────── */

const runCounter = el => {
  if (el._done) return
  el._done = true
  const target   = parseInt(el.dataset.counter || el.dataset.target, 10)
  const suffix   = el.dataset.suffix || ''
  const duration = 1500
  const start    = performance.now()
  const ease     = t => 1 - Math.pow(1 - t, 3)
  const tick = now => {
    const p = Math.min((now - start) / duration, 1)
    el.textContent = Math.floor(ease(p) * target) + suffix
    if (p < 1) requestAnimationFrame(tick)
  }
  requestAnimationFrame(tick)
}

const initObserver = () => {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.reveal').forEach(e => e.classList.add('visible'))
    document.querySelectorAll('[data-counter], .stat-number, [data-target]').forEach(runCounter)
    return
  }

  const obs = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return
      const el = entry.target
      if (el.classList.contains('reveal')) el.classList.add('visible')
      if (el.dataset.counter || el.dataset.target || el.classList.contains('stat-number')) runCounter(el)
      observer.unobserve(el)
    })
  }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' })

  document.querySelectorAll('.reveal:not(.hero *), [data-counter]:not(.hero *), .stat-number:not(.hero *), [data-target]:not(.hero *)')
    .forEach(el => obs.observe(el))
}

const tagRevealTargets = () => {
  const selectors = [
    '.svc-card',
    '.proj-card',
    '.trust-item',
    '.con-form-col',
    '.con-sidebar'
  ]
  selectors.forEach(sel => {
    document.querySelectorAll(sel).forEach(el => el.classList.add('reveal'))
  })
}


/* ─────────────────────────────
NAVIGATION
───────────────────────────── */

const initNav = () => {
  const hamburger = document.getElementById('hamburger')
  const navLinks  = document.getElementById('navLinks')
  const overlay   = document.getElementById('nav-overlay')
  if (!hamburger || !navLinks) return

  const toggle = open => {
    const isOpen = navLinks.classList.contains('open')
    if (open === isOpen) return

    navLinks.classList.toggle('open', open)
    hamburger.classList.toggle('open', open)
    overlay?.classList.toggle('visible', open)
    overlay?.setAttribute('aria-hidden', String(!open))
    document.body.style.overflowY = open ? 'hidden' : ''
    hamburger.setAttribute('aria-expanded', String(open))
  }

  hamburger.addEventListener('click', (e) => {
    e.stopPropagation()
    toggle(!navLinks.classList.contains('open'))
  })
  
  if (overlay) overlay.addEventListener('click', () => toggle(false))

  navLinks.querySelectorAll('a').forEach((a, i) => {
    a.style.setProperty('--nav-item-delay', `${i * 0.04}s`)
    a.addEventListener('click', () => toggle(false))
  })

  document.addEventListener('click', e => {
    if (navLinks.classList.contains('open')
      && !navLinks.contains(e.target)
      && !hamburger.contains(e.target)) toggle(false)
  })

  // Active link — improved matching for subdirectories and query params
  const currentPath = location.pathname.split('/').pop() || 'index.html'
  const currentBase = currentPath.toLowerCase()

  document.querySelectorAll('.nav-links a').forEach(a => {
    const href = a.getAttribute('href')
    if (!href) return
    const linkBase = href.split('/').pop().split('?')[0].toLowerCase()
    
    if (linkBase === currentBase) {
      a.classList.add('active')
    } else if (currentBase === 'project-detail.html' && linkBase === 'projects.html') {
      a.classList.add('active')
    }
  })
}

const initNavScrollState = () => {
  const navEl = document.querySelector('nav')
  if (!navEl) return

  const threshold = 24
  let isScrolled = null
  const update = () => {
    const scrolled = window.scrollY > threshold
    if (scrolled === isScrolled) return
    isScrolled = scrolled
    navEl.classList.toggle('nav-scrolled', scrolled)
  }

  update()
  window.addEventListener('scroll', update, { passive: true })
}


/* ─────────────────────────────
CAREERS EMPTY STATE
───────────────────────────── */

const initCareers = () => {
  const jobs = document.getElementById('jobsList')
  if (jobs && !jobs.querySelector('.job-item')) {
    jobs.innerHTML = `
      <div class="no-jobs reveal visible">
        <h3>No Active Openings</h3>
        <p>Send general applications to
          <a href="mailto:careers@reflectionlogistics.com">careers@reflectionlogistics.com</a>
        </p>
      </div>`
  }
}


/* ─────────────────────────────
CONTACT FORM
───────────────────────────── */

const initContactForm = () => {
  const form = document.getElementById('contactForm')
  if (!form) return

  const successEl = document.getElementById('formSuccess')
  const errorEl   = document.getElementById('formError')

  // Accounting fields toggle
  const serviceSelect   = document.getElementById('serviceSelect')
  const accountingFields = document.getElementById('accountingFields')
  const dateFrom        = document.getElementById('dateFrom')
  const dateTo          = document.getElementById('dateTo')

  if (serviceSelect && accountingFields) {
    const setAccountingState = isAcct => {
      accountingFields.classList.toggle('visible', isAcct)
      accountingFields.setAttribute('aria-hidden', String(!isAcct))
      accountingFields.querySelectorAll('input, select, textarea').forEach(f => {
        f.disabled = !isAcct
      })
      if (dateFrom) dateFrom.required = isAcct
      if (dateTo)   dateTo.required   = isAcct
      if (!isAcct && dateFrom) dateFrom.value = ''
      if (!isAcct && dateTo)   dateTo.value   = ''
    }
    serviceSelect.addEventListener('change', () => setAccountingState(serviceSelect.value === 'accounting'))
    setAccountingState(serviceSelect.value === 'accounting')
  }

  // Inline blur validation
  form.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
    field.addEventListener('blur', () => validateField(field))
    field.addEventListener('input', () => {
      if (field.classList.contains('error')) validateField(field)
    })
  })

  form.addEventListener('submit', async e => {
    e.preventDefault()

    const honey = document.getElementById('honeypot')
    if (honey && honey.value) return

    let firstInvalid = null
    form.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
      if (!validateField(field) && !firstInvalid) firstInvalid = field
    })
    
    if (firstInvalid) {
      firstInvalid.focus()
      if (errorEl) {
        errorEl.textContent = 'Please fix the highlighted fields.'
        errorEl.classList.add('visible')
      }
      return
    }

    if (errorEl) errorEl.classList.remove('visible')

    const btn   = form.querySelector('.submit-btn')
    const label = btn && btn.querySelector('[data-i18n]')
    const orig  = label ? label.textContent : (btn ? btn.textContent : 'Send Message')
    
    if (btn) btn.disabled = true
    if (label) label.textContent = 'Sending…'

    try {
      const res  = await fetchWithTimeout('send.php', { method: 'POST', body: new FormData(form) })
      const data = await res.json()

      if (data.success) {
        form.style.display = 'none'
        if (successEl) {
          successEl.classList.add('visible')
          successEl.style.display = 'flex'
        }
        showToast('Message sent! We\'ll be in touch within 24 hours.', 'success', 5000)
      } else {
        throw new Error(data.message || 'Server error')
      }
    } catch (err) {
      const msg = err.message === 'Server error' ? 'Something went wrong. Please try again.' : 
                 (err.name === 'AbortError' ? 'Request timed out. Check your connection.' : 'Network error. Please try again.')
      
      if (errorEl) { errorEl.textContent = msg; errorEl.classList.add('visible') }
      if (label) label.textContent = orig
      if (btn) btn.disabled = false
      showToast(msg, 'error')
    }
  })
}


/* ─────────────────────────────
FIELD VALIDATION
───────────────────────────── */

const validateField = field => {
  if (!field.willValidate) return true
  const acct = field.closest('#accountingFields')
  if (acct && !acct.classList.contains('visible')) return true

  const { validity } = field
  if (validity.valid) {
    field.classList.remove('error')
    field.removeAttribute('aria-invalid')
    const err = document.getElementById(field.id + '-error')
    if (err) err.textContent = ''
    return true
  }

  field.classList.add('error')
  field.setAttribute('aria-invalid', 'true')
  const errId = field.id + '-error'
  let errEl = document.getElementById(errId)
  if (!errEl) {
    errEl = document.createElement('span')
    errEl.id = errId
    errEl.className = 'field-error'
    errEl.setAttribute('role', 'alert')
    field.parentNode.appendChild(errEl)
    field.setAttribute('aria-describedby', errId)
  }

  if (validity.valueMissing)   errEl.textContent = 'This field is required.'
  else if (validity.typeMismatch) errEl.textContent = 'Please enter a valid value.'
  else errEl.textContent = field.validationMessage || 'Please check this field.'

  return false
}


/* ─────────────────────────────
CV VALIDATION & DRAG DROP
───────────────────────────── */

/**
 * Validates a CV file based on extension and size.
 * Uses extension-first approach for better cross-browser reliability.
 */
const validateCVFile = (file) => {
  if (!file) return { valid: false };

  // 1. Extension Check
  const allowedExts = ['pdf', 'doc', 'docx'];
  const fileName = file.name || '';
  const ext = fileName.split('.').pop().toLowerCase();

  if (!allowedExts.includes(ext)) {
    return { 
      valid: false, 
      message: 'Invalid file type. Only PDF, DOC, or DOCX accepted.' 
    };
  }

  // 2. Size Check (5MB)
  const MAX_SIZE = 5 * 1024 * 1024;
  if (file.size > MAX_SIZE) {
    return { 
      valid: false, 
      message: 'File too large. Maximum allowed size is 5MB.' 
    };
  }

  return { valid: true };
};

/**
 * Updates the CV upload UI state and handles validation errors.
 */
const updateCVUploadUI = (file) => {
  const zone   = document.getElementById('cvZone');
  const nameEl = document.getElementById('cvFilename');
  const input  = document.getElementById('cvFile');

  // Case: No file (e.g., cleared or modal opened)
  if (!file) {
    zone?.classList.remove('has-file');
    if (nameEl) nameEl.textContent = '';
    return;
  }

  const result = validateCVFile(file);

  if (!result.valid) {
    // Show error and reset everything
    showToast(result.message, 'error');
    if (input) input.value = ''; // Important: clear the input
    zone?.classList.remove('has-file');
    if (nameEl) nameEl.textContent = '';
    return false;
  }

  // Success: Update UI
  zone?.classList.add('has-file');
  if (nameEl) nameEl.textContent = '✓ ' + file.name;
  return true;
};

const initCVUpload = () => {
  const zone   = document.getElementById('cvZone');
  const input  = document.getElementById('cvFile');
  if (!zone || !input) return;

  // Drag visual feedback
  zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
  zone.addEventListener('dragleave', ()  => zone.classList.remove('drag-over'));
  
  // Handle Drop
  zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('drag-over');
    
    const file = e.dataTransfer.files[0];
    if (file) {
      const result = validateCVFile(file);
      if (result.valid) {
        try {
          // Attempt to sync the dropped file to the file input
          const dt = new DataTransfer();
          dt.items.add(file);
          input.files = dt.files;
          updateCVUploadUI(file);
        } catch (err) {
          // If DataTransfer fails (rare), fall back to input selection
          console.warn('DataTransfer not supported, falling back.');
          handleFileSelect(input);
        }
      } else {
        showToast(result.message, 'error');
      }
    }
  });

  // Handle traditional selection
  input.addEventListener('change', () => updateCVUploadUI(input.files[0]));
};


/* ─────────────────────────────
JOB DRAWER
───────────────────────────── */

window.toggleJob = row => {
  const item   = row.closest('.job-item')
  if (!item) return
  const isOpen = item.classList.contains('active')

  document.querySelectorAll('.job-item.active').forEach(j => {
    j.classList.remove('active')
    j.querySelector('.job-row')?.setAttribute('aria-expanded', 'false')
  })

  if (!isOpen) {
    item.classList.add('active')
    row.setAttribute('aria-expanded', 'true')
  }
}


/* ─────────────────────────────
APPLY MODAL
───────────────────────────── */

let _currentJob = ''

window.openApplyModal = title => {
  const modal = document.getElementById('applyModal')
  if (!modal) return
  _currentJob = title
  const titleEl = document.getElementById('modalJobTitle')
  if (titleEl) titleEl.textContent = 'Position: ' + title

  const form    = document.getElementById('modalForm')
  const success = document.getElementById('modalSuccess')
  const errEl   = document.getElementById('modalError')
  if (form)    { form.style.display = ''; form.reset() }
  if (success) { success.hidden = true }
  if (errEl)   { errEl.classList.remove('visible') }
  
  updateCVUploadUI(null);

  modal.classList.add('visible')
  modal.setAttribute('aria-hidden', 'false')
  document.body.style.overflow = 'hidden'
  setTimeout(() => modal.querySelector('input, button')?.focus(), 60)
}

window.closeApplyModal = () => {
  const modal = document.getElementById('applyModal')
  if (!modal) return
  modal.classList.remove('visible')
  modal.setAttribute('aria-hidden', 'true')
  document.body.style.overflow = ''
  _currentJob = ''
}

document.addEventListener('click', e => {
  const modal = document.getElementById('applyModal')
  if (e.target === modal) window.closeApplyModal()
})
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') window.closeApplyModal()
})

window.handleFileSelect = input => {
  updateCVUploadUI(input?.files[0]);
}

window.submitApplication = async e => {
  if (e) e.preventDefault()

  const btn     = document.getElementById('modalSubmitBtn')
  const errEl   = document.getElementById('modalError')
  const nameEl  = document.getElementById('applicantName')
  const emailEl = document.getElementById('applicantEmail')
  const cvFile  = document.getElementById('cvFile')
  const honey   = document.getElementById('modalHoneypot')

  if (honey && honey.value) return

  if (!nameEl?.value.trim()) {
    showToast('Please enter your full name.', 'error')
    nameEl?.focus()
    return
  }
  if (!emailEl?.value.trim() || !emailEl.value.includes('@')) {
    showToast('Please enter a valid email address.', 'error')
    emailEl?.focus()
    return
  }
  
  if (!cvFile?.files.length) {
    showToast('Please attach your CV before submitting.', 'error')
    return
  }
  
  const cvValidation = validateCVFile(cvFile.files[0]);
  if (!cvValidation.valid) {
    showToast(cvValidation.message || 'Invalid CV file.', 'error');
    return;
  }

  if (errEl) errEl.classList.remove('visible')
  if (btn) { btn.disabled = true; btn.textContent = 'Sending…' }

  const fd = new FormData()
  fd.append('applicant_name',  nameEl.value.trim())
  fd.append('applicant_email', emailEl.value.trim())
  fd.append('position',        _currentJob)
  fd.append('cv',              cvFile.files[0])

  const phoneEl = document.getElementById('applicantPhone')
  if (phoneEl?.value) fd.append('applicant_phone', phoneEl.value)

  try {
    const res  = await fetchWithTimeout('send_cv.php', { method: 'POST', body: fd })
    const data = await res.json()

    if (data.success) {
      const form    = document.getElementById('modalForm')
      const success = document.getElementById('modalSuccess')
      if (form)    form.style.display = 'none'
      if (success) success.hidden = false
      showToast('Application sent! We will be in touch.', 'success', 5000)
    } else {
      throw new Error(data.message || 'Server error')
    }
  } catch (err) {
    const msg = err.message === 'Server error' ? 'Something went wrong. Please try again.' : 
               (err.name === 'AbortError' ? 'Request timed out. Check your connection.' : 'Network error. Please try again.')
    if (errEl) { errEl.textContent = msg; errEl.classList.add('visible') }
    if (btn)   { btn.disabled = false; btn.textContent = 'Submit Application' }
    showToast(msg, 'error')
  }
}


/* ─────────────────────────────
PROJECTS FILTER
───────────────────────────── */

const initProjectsFilter = () => {
  const filterBtns = document.querySelectorAll('.filter-btn')
  const cards      = document.querySelectorAll('.proj-card')
  if (!filterBtns.length) return

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'))
      btn.classList.add('active')
      const filter = btn.dataset.filter
      cards.forEach(card => {
        const show = filter === 'all' || card.dataset.category === filter
        card.style.display = show ? '' : 'none'
      })
    })
  })
}


/* ─────────────────────────────
PARALLAX (subtle hero scroll effect)
───────────────────────────── */

const initParallax = () => {
  const heroImg = document.querySelector('.hero-img-tag') || document.querySelector('.hero picture img')
  if (!heroImg) return

  let ticking = false
  const update = () => {
    const scrolled = Math.min(window.scrollY, 400)
    const rate = 0.08
    heroImg.style.transform = `translate3d(0, ${scrolled * rate}px, 0)`
    ticking = false
  }

  window.addEventListener('scroll', () => {
    if (ticking) return
    ticking = true
    requestAnimationFrame(update)
  }, { passive: true })
  update()
}

/* ─────────────────────────────
PAGE TRANSITIONS
───────────────────────────── */

const initPageTransitions = () => {
  // Clear exiting class if navigating back (safari/chrome cache)
  window.addEventListener('pageshow', (event) => {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
      document.body.classList.remove('page-exiting');
    }
  });

  // Handle browser back/forward buttons immediately
  window.addEventListener('popstate', () => {
    document.body.classList.remove('page-exiting');
  });

  document.addEventListener('click', e => {
    if (e.defaultPrevented) return
    const a = e.target.closest('a')
    if (!a) return

    const href = a.getAttribute('href')
    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return
    if (a.target === '_blank' || a.hasAttribute('download')) return
    
    try {
      const url = new URL(href, location.origin)
      if (url.origin !== location.origin || url.pathname === location.pathname) return
    } catch (_) { return }

    e.preventDefault()
    document.body.classList.add('page-exiting')
    // Wait for 220ms to match CSS opacity transition
    setTimeout(() => { location.href = href }, 220)
  })
}


/* ─────────────────────────────
INIT
───────────────────────────── */

document.addEventListener('componentsLoaded', () => {
  initToasts()
  initImageLoading()
  initNav()
  initContactForm()

  const runNonCritical = () => {
    try {
      tagRevealTargets()
      initObserver()
      initCareers()
      initCVUpload()
      initProjectsFilter()
      initServiceSliders()
      initPageTransitions()
      initParallax()
      initNavScrollState()
    } catch (e) {
      console.warn('Non-critical init failed:', e)
    }
  }

  if ('requestIdleCallback' in window) {
    requestIdleCallback(runNonCritical, { timeout: 3000 })
  } else {
    setTimeout(runNonCritical, 0)
  }
})

})()

/**
 * Service Slider logic — kept outside IIFE for easy call/reload
 */
function ensureSliderImageLoaded(slide) {
  if (!slide || slide._loaded) return;
  const img = slide.querySelector('img[data-src]');
  const source = slide.querySelector('source[data-srcset]');
  if (source && !source.srcset && source.dataset.srcset) {
    source.srcset = source.dataset.srcset;
  }
  if (img && img.dataset.src && img.src.indexOf('data:image') === 0) {
    img.src = img.dataset.src;
  }
  slide._loaded = true;
}

function currentServiceSlideIndex(slider) {
  const dots = slider.querySelectorAll('.dot');
  const idx = Array.from(dots).findIndex(dot => dot.classList.contains('active'));
  return idx < 0 ? 0 : idx;
}

function goToServiceSlide(slider, index) {
  const slides = slider.querySelectorAll('.svc-slide');
  const dots = slider.querySelectorAll('.dot');
  const total = slides.length;
  if (!total) return;

  const next = (index + total) % total;

  slides.forEach((slide, i) => {
    slide.style.display = i === next ? 'block' : 'none';
  });

  dots.forEach((dot, i) => {
    dot.classList.toggle('active', i === next);
  });

  ensureSliderImageLoaded(slides[next]);
}

function initServiceSliders() {
  const sliders = document.querySelectorAll('.svc-slider[data-slider]');
  sliders.forEach(slider => {
    if (slider.dataset.sliderInit === 'true') return;
    slider.dataset.sliderInit = 'true';

    const slides = slider.querySelectorAll('.svc-slide');
    if (!slides.length) return;

    ensureSliderImageLoaded(slides[0]);
    goToServiceSlide(slider, 0);

    const prev = slider.querySelector('.s-prev');
    const next = slider.querySelector('.s-next');
    const dots = slider.querySelectorAll('.dot');

    prev?.addEventListener("click", (e) => {
      e.preventDefault(); e.stopPropagation();
      goToServiceSlide(slider, currentServiceSlideIndex(slider) - 1);
    });

    next?.addEventListener("click", (e) => {
      e.preventDefault(); e.stopPropagation();
      goToServiceSlide(slider, currentServiceSlideIndex(slider) + 1);
    });

    dots.forEach(dot => {
      dot.addEventListener("click", (e) => {
          e.preventDefault(); e.stopPropagation();
          const idx = parseInt(dot.dataset.dotIndex || "0", 10);
          goToServiceSlide(slider, idx);
      });
    });

    slider.setAttribute('tabindex', '0');
    slider.addEventListener('keydown', e => {
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        goToServiceSlide(slider, currentServiceSlideIndex(slider) - 1);
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        goToServiceSlide(slider, currentServiceSlideIndex(slider) + 1);
      }
    });
  });
}