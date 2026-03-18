/**
 * components.js — Nav and footer are now inlined in each HTML page.
 * This file only dispatches "componentsLoaded" so main.js and I18n.js can init.
 */
document.addEventListener('DOMContentLoaded', function() {
  document.dispatchEvent(new Event('componentsLoaded'));
});
