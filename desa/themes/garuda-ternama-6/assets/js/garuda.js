/*! Garuda Theme — interaksi (vanilla ES6, koeksistensi dengan jQuery/Alpine) */
(function () {
  'use strict';

  /* ---------- Mode gelap ---------- */
  var root = document.documentElement;

  function currentTheme() {
    return root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  }
  function syncToggleIcons(t) {
    document.querySelectorAll('[data-grd-darktoggle]').forEach(function (btn) {
      var icon = btn.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-moon', t === 'light');
        icon.classList.toggle('fa-sun', t === 'dark');
      }
      btn.setAttribute('aria-pressed', t === 'dark' ? 'true' : 'false');
    });
  }
  function applyTheme(t) {
    root.setAttribute('data-theme', t);
    try { localStorage.setItem('garuda-theme', t); } catch (e) {}
    syncToggleIcons(t);
  }
  // saat load: hanya sinkron ikon, JANGAN tulis localStorage (biar default tetap terang)
  document.addEventListener('DOMContentLoaded', function () { syncToggleIcons(currentTheme()); });
  // delegasi klik
  document.addEventListener('click', function (e) {
    var toggle = e.target.closest('[data-grd-darktoggle]');
    if (!toggle) return;
    e.preventDefault();
    applyTheme(currentTheme() === 'dark' ? 'light' : 'dark');
  });

  /* ---------- Hitung mundur event ---------- */
  function pad(n) { return n < 10 ? '0' + n : '' + n; }
  function initCountdowns() {
    var nodes = document.querySelectorAll('[data-grd-countdown]');
    if (!nodes.length) return;
    function tick() {
      var now = new Date().getTime();
      nodes.forEach(function (el) {
        var target = new Date(el.getAttribute('data-grd-countdown')).getTime();
        if (isNaN(target)) { el.style.display = 'none'; return; }
        var diff = target - now;
        if (diff <= 0) {
          var done = el.getAttribute('data-grd-done');
          if (done) { el.textContent = done; el.classList.add('grd-countdown__done'); }
          else { el.style.display = 'none'; }
          return;
        }
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var set = function (k, v) { var t = el.querySelector('[data-cd="' + k + '"]'); if (t) t.textContent = pad(v); };
        set('hari', d); set('jam', h); set('menit', m); set('detik', s);
      });
    }
    tick();
    setInterval(tick, 1000);
  }
  document.addEventListener('DOMContentLoaded', initCountdowns);

  /* ---------- Back-to-top fallback (jika Alpine tak tersedia) ---------- */
  document.addEventListener('DOMContentLoaded', function () {
    var bt = document.querySelector('[data-grd-backtotop]');
    if (!bt) return;
    window.addEventListener('scroll', function () {
      bt.classList.toggle('grd-show', window.scrollY > 500);
    }, { passive: true });
    bt.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });
})();
