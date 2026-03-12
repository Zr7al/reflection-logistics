# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Reflection Freight Forwarding & Logistic Services** — a multi-page, bilingual (EN/AR) logistics company website. Vanilla JS frontend, PHP backend for email handling, deployed on XAMPP/Apache.

## Development Environment

- **Server:** XAMPP (Apache + PHP). Pages must be served via `http://localhost/rff-demo/` — not opened as local files — for PHP (`send.php`, `send_cv.php`) to work.
- **PHP dependency:** PHPMailer is installed via Composer in `/vendor/`. Run `composer install` to restore if missing.
- **No build step:** HTML, CSS, and JS are served as-is. Edit and refresh.
- **Optional image optimization:** Run `npm install && npm run build:images` to generate WebP and responsive image sizes for better performance. Requires Node.js.
- **Email config:** Update `config.php` with real SMTP credentials (Microsoft 365) before testing contact/CV forms.

## Architecture

### Page Structure
Each `.html` file is a standalone page (no templating engine). Navigation, footer, and `<head>` are duplicated across pages. Pages: `index`, `about`, `services`, `projects`, `project-detail`, `contact`, `careers`.

### JavaScript (`assets/js/`)
- **`main.js`** — Single IIFE that initializes all page modules on `DOMContentLoaded`. Modules are scoped functions: toasts, image lazy-loading, scroll reveal/counter animations, nav, contact form, CV upload, job drawer/modal, project filtering.
  - Several functions are exposed globally (`window.toggleJob`, `window.openApplyModal`, etc.) for inline HTML `onclick` handlers.
  - Forms submit asynchronously via `fetchWithTimeout()` (10s timeout) to `send.php` / `send_cv.php`.
- **`I18n.js`** — Standalone translation system. Loads translations from `/locales/en.json` and `/locales/ar.json`. Supports `data-i18n` (innerHTML), `data-i18n-placeholder`, `data-i18n-title`, `data-i18n-alt`. Language: URL `?lang=` > localStorage (`rl_lang`) > browser (`navigator.language`) > default (en). RTL via `document.documentElement.dir`. Content hidden until `data-lang-ready="true"`.

### CSS (`assets/css/`)
- **`style.css`** — Primary stylesheet (68 KB). Uses CSS custom properties for design tokens (`--black`, `--red`, `--white`, etc.). Handles RTL layout via `.rtl` body class and `dir` attribute on `<html>`.
- Page-specific overrides (e.g., `about.css`) are loaded in addition to `style.css`.

### PHP Backend
- `config.php` — Defines SMTP constants (`SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASS`, `CONTACT_RECEIVER`).
- `send.php` — Handles contact form POST, includes honeypot validation and PHPMailer.
- `send_cv.php` — Handles job application POST with CV file upload.

## i18n Pattern

To add a new translatable string:
1. Add a `data-i18n="key"` attribute to the HTML element (or `data-i18n-placeholder`, `data-i18n-title`, `data-i18n-alt` for those attributes).
2. Add the key with EN and AR values to `/locales/en.json` and `/locales/ar.json`.
3. For formatted strings (HTML), the value in JSON can include tags like `<br>`, `<em>`.

## Key Conventions

- **No JS frameworks.** Keep everything in vanilla JS.
- **RTL support required.** Any new layout must be tested with Arabic (RTL) active. Use the `.rtl` class on `body` and `dir` attribute on `<html>` for direction-aware CSS.
- **Fonts:** English → Barlow / Bebas Neue; Arabic → Tajawal. Both loaded via Google Fonts.
- **Form security:** Client-side validation in `main.js` + server-side sanitization (`strip_tags`, `filter_var`) in PHP. Honeypot field (`website` input) must remain present in contact/career forms.
- **File uploads:** CV uploads validated client-side (PDF/Word only, 5 MB max) and server-side.
