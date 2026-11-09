/* ==========================================================================
   Labantik — landing.js (vanilla, tanpa dependensi)
   Animasi mengikuti prototype Figma "Instrument Design Studio":
   - spring hero 3,19 dtk (stiffness 10.24, damping 4.8)
   - spring hover 1,53 dtk (stiffness 44.44, damping 10)
   - marquee 10 dtk in-out cubic, scroll halus out-cubic
   ========================================================================== */
(function () {
  'use strict';

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var root = document.documentElement;
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---------- Spring → CSS linear() ---------- */
  function spring(k, c, dur) {
    var w = Math.sqrt(k), z = c / (2 * Math.sqrt(k)), wd = w * Math.sqrt(Math.max(0, 1 - z * z));
    function f(t) {
      return z < 1
        ? 1 - Math.exp(-z * w * t) * (Math.cos(wd * t) + (z * w / wd) * Math.sin(wd * t))
        : 1 - Math.exp(-w * t) * (1 + w * t);
    }
    var n = Math.max(24, Math.round(dur * 60)), pts = [];
    for (var i = 0; i <= n; i++) pts.push((i === n ? 1 : f(i / n * dur)).toFixed(4));
    return { css: 'linear(' + pts.join(',') + ')', fn: function (p) { return p >= 1 ? 1 : f(p * dur); } };
  }
  var heroSpring = spring(10.24, 4.8, 3.194);
  var uiSpring = spring(44.44, 10, 1.533);
  if (window.CSS && CSS.supports && CSS.supports('transition-timing-function', 'linear(0,1)')) {
    root.style.setProperty('--spring-ui', uiSpring.css);
  }

  /* ---------- cubic-bezier ---------- */
  function bezier(x1, y1, x2, y2) {
    function A(a, b) { return 1 - 3 * b + 3 * a }
    function B(a, b) { return 3 * b - 6 * a }
    function C(a) { return 3 * a }
    function at(t, a, b) { return ((A(a, b) * t + B(a, b)) * t + C(a)) * t }
    function sl(t, a, b) { return 3 * A(a, b) * t * t + 2 * B(a, b) * t + C(a) }
    return function (x) {
      if (x <= 0) return 0; if (x >= 1) return 1;
      var t = x;
      for (var i = 0; i < 8; i++) { var s = sl(t, x1, x2); if (Math.abs(s) < 1e-6) break; t -= (at(t, x1, x2) - x) / s; }
      return at(t, y1, y2);
    };
  }
  var outCubic = bezier(0, 0, .58, 1), inOut = bezier(.42, 0, .58, 1);

  /* ---------- Navigasi: menu mobile + scroll halus ---------- */
  var nav = $('#nav'), tog = nav && $('.tog', nav);
  function closeNav() { if (nav) { nav.classList.remove('open'); if (tog) tog.setAttribute('aria-expanded', 'false'); } }
  if (tog) tog.addEventListener('click', function () {
    var open = nav.classList.toggle('open');
    tog.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  document.addEventListener('click', function (e) { if (nav && !nav.contains(e.target)) closeNav(); });

  function scrollToY(target, dur) {
    target = Math.max(0, Math.min(target, document.documentElement.scrollHeight - innerHeight));
    if (reduce) { window.scrollTo(0, target); return; }
    var from = window.pageYOffset, dist = target - from, t0 = null;
    (function step(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / (dur * 1000));
      window.scrollTo(0, from + dist * outCubic(p));
      if (p < 1) requestAnimationFrame(step);
    })(performance.now());
  }
  $$('[data-go]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('data-go');
      var el = id === 'top' ? document.body : document.getElementById(id);
      if (!el) return;                       // bukan di halaman ini → ikuti href biasa
      e.preventDefault();
      closeNav();
      var off = parseFloat(a.getAttribute('data-off') || 0);
      var y = id === 'top' ? 0 : el.getBoundingClientRect().top + window.pageYOffset + off;
      scrollToY(y, id === 'kontak' ? 1.3 : .9);
      if (history.replaceState) history.replaceState(null, '', id === 'top' ? location.pathname : '#' + id);
    });
  });

  /* ---------- Hero: judul menyesuaikan layar + gambar berpindah dengan spring ---------- */
  var stage = $('#stage'), img = $('#heroImg');
  // Ukur lebar alami teks pada font 100px, lalu skalakan agar pas di layar.
  function naturalWidth(el, holder) {
    var prev = holder.style.maxWidth; holder.style.maxWidth = 'none';
    var w = 0;
    $$('.row', el).concat(el.classList.contains('big-type') ? [el] : []).forEach(function (r) {
      w = Math.max(w, r.scrollWidth);
    });
    holder.style.maxWidth = prev;
    return w;
  }
  function fitHero() {
    if (!stage) return;
    var h1 = $('h1', stage);
    stage.style.setProperty('--fs', '100px');
    var em = naturalWidth(h1, stage) / 100;
    var fs = Math.min(128, (document.documentElement.clientWidth - 32) / em);
    stage.style.setProperty('--fs', fs.toFixed(2) + 'px');
  }
  // Judul besar di "Tentang": ukuran mengikuti baris terpanjang
  function fitBig() {
    $$('.big-type').forEach(function (el) {
      var lines = $$('.bt-line', el);
      var originalStyles = lines.map(function (line) {
        return { width: line.style.width, whiteSpace: line.style.whiteSpace };
      });
      el.style.fontSize = '100px';
      lines.forEach(function (line) {
        line.style.width = 'max-content';
        line.style.whiteSpace = 'nowrap';
      });
      var w = Math.max.apply(null, lines.map(function (line) { return line.scrollWidth; }));
      lines.forEach(function (line, index) {
        line.style.width = originalStyles[index].width;
        line.style.whiteSpace = originalStyles[index].whiteSpace;
      });
      var mobile = window.matchMedia('(max-width:719px)').matches;
      var availableWidth = document.documentElement.clientWidth - (mobile ? 48 : 32);
      el.style.fontSize = Math.min(170, Math.min(availableWidth, 1190) / (w / 100)).toFixed(2) + 'px';
    });
  }
  fitBig();
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(fitBig);
  window.addEventListener('resize', fitBig);

  if (stage && img) {
    // 4 posisi dari varian Figma. x = pecahan ruang bebas (lebar judul − lebar gambar), y dalam em.
    var mobileHero = window.matchMedia('(max-width:719px)');
    var U = [.333, .802, 1.183, .064];
    var Y = [150, -45, 212, -36].map(function (v) { return v / 128; });
    var idx = 0, cur = { x: 0, y: 0 }, from, to, t0;
    var pos = function (i) {
      var fs = parseFloat(getComputedStyle(stage).fontSize);
      var iw = img.offsetWidth, sw = stage.offsetWidth, sl = stage.getBoundingClientRect().left;
      if (mobileHero.matches) {
        var stageRect = stage.getBoundingClientRect();
        var imageRect = img.getBoundingClientRect();
        var titleRect = $('h1', stage).getBoundingClientRect();
        var copyRect = $('.hero-copy', stage).getBoundingClientRect();
        var min = 12 - sl, max = document.documentElement.clientWidth - 12 - iw - sl;
        var targetX = Math.max(min, Math.min(max, U[i] * (sw - iw)));
        var imageTop = imageRect.top - cur.y;
        var targetTop = titleRect.top + Y[i] * fs;
        targetTop = Math.max(stageRect.top - fs * .25, Math.min(copyRect.top - img.offsetHeight - 8, targetTop));
        var targetY = targetTop - imageTop;

        return { x: targetX - (sw - iw) / 2, y: targetY };
      }
      var x = U[i] * (sw - iw);
      var min = 12 - sl, max = document.documentElement.clientWidth - 12 - iw - sl;
      return { x: Math.max(min, Math.min(max, x)), y: Y[i] * fs };
    };
    var place = function (p) { img.style.transform = 'translate3d(' + p.x.toFixed(1) + 'px,' + p.y.toFixed(1) + 'px,0)'; };
    var layout = function () {
      fitHero();
      cur = pos(idx);
      place(cur);
    };
    layout();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(layout);
    window.addEventListener('resize', function () {
      fitHero();
      cur = pos(idx);
      from = cur;
      to = pos((idx + 1) % 4);
      t0 = performance.now();
      place(cur);
    });

    if (!reduce) {
      var STEP = 3194, next = (idx + 1) % 4;
      from = cur;
      to = pos(next);
      t0 = performance.now();
      (function tick(now) {
        var p = Math.min(1, (now - t0) / STEP), e = heroSpring.fn(p);
        cur = { x: from.x + (to.x - from.x) * e, y: from.y + (to.y - from.y) * e };
        place(cur);
        if (p >= 1) {
          idx = next;
          from = to;
          next = (idx + 1) % 4;
          to = pos(next);
          t0 = now;
        }
        requestAnimationFrame(tick);
      })(performance.now());
    }
  } else { fitHero(); }

  /* ---------- Marquee (10 dtk in-out cubic, berulang tanpa putus) ---------- */
  function marquee(track) {
    if (!track) return;
    var set = $('.set', track), shiftEm = parseFloat(track.dataset.shift), cycle = parseFloat(track.dataset.cycle) * 1000;
    var fs = 16, period = 1;
    function measure() {
      fs = parseFloat(getComputedStyle(track).fontSize);
      period = set.getBoundingClientRect().width;
      var need = Math.ceil((innerWidth * 1.3) / Math.max(1, period)) + 2;
      while (track.children.length < need) { var c = set.cloneNode(true); c.setAttribute('aria-hidden', 'true'); track.appendChild(c); }
    }
    measure();
    window.addEventListener('resize', measure);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(measure);
    if (reduce) return;
    var t0 = performance.now();
    (function loop(now) {
      var t = now - t0, n = Math.floor(t / cycle), f = (t % cycle) / cycle;
      var off = ((n + inOut(f)) * shiftEm * fs) % period;
      track.style.transform = 'translate3d(' + (-off).toFixed(2) + 'px,0,0)';
      requestAnimationFrame(loop);
    })(t0);
  }
  marquee($('#divTrack'));
  marquee($('#mailTrack'));

  /* ---------- Galeri: lightbox ---------- */
  var gal = $('#gal'), lb = $('#lb');
  if (gal && lb) {
    var items = $$('button', gal), li = 0, lbImg = $('#lbImg'), lbCap = $('#lbCap'), lastFocus = null;
    var show = function (i) {
      li = (i + items.length) % items.length;
      lbImg.src = items[li].dataset.full;
      lbImg.alt = items[li].dataset.cap || '';
      lbCap.textContent = items[li].dataset.cap || '';
    };
    var open = function (i) { lastFocus = document.activeElement; show(i); lb.classList.add('open'); document.body.style.overflow = 'hidden'; $('[data-lb="close"]', lb).focus(); };
    var close = function () { lb.classList.remove('open'); document.body.style.overflow = ''; lbImg.src = ''; if (lastFocus) lastFocus.focus(); };
    items.forEach(function (b, i) { b.addEventListener('click', function () { open(i); }); });
    lb.addEventListener('click', function (e) {
      var a = e.target.getAttribute && e.target.getAttribute('data-lb');
      if (a === 'prev') show(li - 1); else if (a === 'next') show(li + 1); else if (a === 'close' || e.target === lb) close();
    });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') close(); else if (e.key === 'ArrowLeft') show(li - 1); else if (e.key === 'ArrowRight') show(li + 1);
    });
    var sx = null;
    lb.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
      if (sx === null) return; var dx = e.changedTouches[0].clientX - sx; sx = null;
      if (Math.abs(dx) > 50) show(li + (dx < 0 ? 1 : -1));
    });
  }

  /* ---------- Struktur organisasi: pilih angkatan (AJAX) + geser carousel ---------- */
  var sec = $('#struktur'), track = $('#mtrack');
  if (sec && track) {
    var base = sec.dataset.url, cache = {}, busy = false;
    var chips = $$('.chip', sec);
    var activeId = (chips.filter(function (c) { return c.getAttribute('aria-pressed') === 'true'; })[0] || {}).dataset;
    if (activeId) cache[activeId.gen] = track.innerHTML;
    chips.forEach(function (chip) {
      chip.addEventListener('click', function () {
        var id = chip.dataset.gen;
        if (busy || chip.getAttribute('aria-pressed') === 'true') return;
        busy = true;
        chips.forEach(function (c) { c.setAttribute('aria-pressed', c === chip ? 'true' : 'false'); });
        var load = cache[id] ? Promise.resolve(cache[id])
          : fetch(base + '/' + id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
              .then(function (r) { if (!r.ok) throw new Error(r.status); return r.text(); })
              .then(function (h) { cache[id] = h; return h; });
        track.classList.add('swap');
        Promise.all([load, new Promise(function (r) { setTimeout(r, 300); })]).then(function (res) {
          track.innerHTML = res[0]; track.scrollLeft = 0;
        }).catch(function () {
          track.innerHTML = '<p class="empty">Gagal memuat data angkatan. Coba lagi.</p>';
        }).then(function () { track.classList.remove('swap'); busy = false; });
      });
    });
    $$('[data-mv]', sec).forEach(function (b) {
      b.addEventListener('click', function () {
        var card = $('.mc', track), step = (card ? card.offsetWidth : 240) + 16;
        track.scrollBy({ left: step * parseInt(b.dataset.mv, 10) * 2, behavior: reduce ? 'auto' : 'smooth' });
      });
    });
  }

  /* ---------- Testimoni: slider ---------- */
  var tm = $('#tm');
  if (tm) {
    var slides = $$('.slide', tm), dots = $$('[data-dot]', tm), si = 0, timer = null;
    var go = function (i) {
      si = (i + slides.length) % slides.length;
      slides.forEach(function (s, k) { s.classList.toggle('on', k === si); });
      dots.forEach(function (d, k) { d.setAttribute('aria-current', k === si ? 'true' : 'false'); });
    };
    var play = function () { if (reduce || slides.length < 2) return; stop(); timer = setInterval(function () { go(si + 1); }, 7000); };
    var stop = function () { if (timer) { clearInterval(timer); timer = null; } };
    $$('[data-tm]', tm).forEach(function (b) { b.addEventListener('click', function () { go(si + parseInt(b.dataset.tm, 10)); play(); }); });
    dots.forEach(function (d) { d.addEventListener('click', function () { go(parseInt(d.dataset.dot, 10)); play(); }); });
    tm.addEventListener('mouseenter', stop); tm.addEventListener('mouseleave', play);
    tm.addEventListener('focusin', stop); tm.addEventListener('focusout', play);
    play();
  }
})();
