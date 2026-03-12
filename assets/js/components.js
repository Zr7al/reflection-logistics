/**
 * components.js — Load nav and footer components dynamically
 * Must run before I18n.js and main.js. Dispatches "componentsLoaded" when done.
 */
(function() {
  'use strict';

  document.addEventListener('DOMContentLoaded', function() {
    Promise.all([
      fetch('components/nav.html').then(function(r) {
        if (!r.ok) throw new Error('Nav fetch failed');
        return r.text();
      }),
      fetch('components/footer.html').then(function(r) {
        if (!r.ok) throw new Error('Footer fetch failed');
        return r.text();
      })
    ]).then(function(results) {
      const navHtml = results[0];
      const footerHtml = results[1];

      const navPlaceholder = document.getElementById('nav-placeholder');
      const footerPlaceholder = document.getElementById('footer-placeholder');

      if (navPlaceholder) navPlaceholder.outerHTML = navHtml;
      if (footerPlaceholder) footerPlaceholder.outerHTML = footerHtml;

      document.dispatchEvent(new Event('componentsLoaded'));
    }).catch(function(err) {
      console.error('Components load error:', err);
      document.dispatchEvent(new Event('componentsLoaded'));
    });
  });
})();
