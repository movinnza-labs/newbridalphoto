<!-- ══ GOOGLE REVIEWS (Trustindex widget, lazy-loaded on scroll) ══════ -->
<link rel="preconnect" href="https://cdn.trustindex.io" crossorigin>
<section class="section section-white google-reviews-section">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow" style="margin-bottom:.7rem;">Trusted by 1,179+ couples</p>
      <div class="rule-center" style="margin-bottom:1.4rem;"></div>
      <h2 class="section-title">Excellent <em>Google Reviews</em></h2>
    </div>
    <div class="google-reviews-widget-wrap"
         data-template-url="<?= base_url('assets/templates/trustindex-google-widget.html?v=150526.1') ?>">
      <div data-src="https://cdn.trustindex.io/loader.js?wp-widget" data-template-id="trustindex-google-widget-html" data-css-url="<?= base_url('uploads/trustindex-google-widget.css') ?>"></div>
    </div>
  </div>
</section>
<script>
(function () {
  var section = document.querySelector('.google-reviews-section');
  if (!section) return;
  var wrap = section.querySelector('.google-reviews-widget-wrap');
  if (!wrap) return;
  var templateUrl = wrap.getAttribute('data-template-url');
  var loaded = false;

  function loadTrustindexScript() {
    var s = document.createElement('script');
    s.src = 'https://cdn.trustindex.io/loader.js?ver=1';
    s.async = true;
    document.head.appendChild(s);
  }

  function loadWidget() {
    if (loaded) return;
    loaded = true;
    if (!templateUrl) { loadTrustindexScript(); return; }
    fetch(templateUrl, { credentials: 'same-origin' })
      .then(function (r) { return r.ok ? r.text() : ''; })
      .then(function (html) {
        if (html) {
          // Insert the <pre><template>...</template></pre> markup at the
          // start of the wrapper so the Trustindex loader can find
          // #trustindex-google-widget-html when it runs.
          wrap.insertAdjacentHTML('afterbegin', html);
        }
        loadTrustindexScript();
      })
      .catch(function () { loadTrustindexScript(); });
  }

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      for (var i = 0; i < entries.length; i++) {
        if (entries[i].isIntersecting) {
          loadWidget();
          io.disconnect();
          break;
        }
      }
    }, { rootMargin: '200px 0px' });
    io.observe(section);
  } else {
    loadWidget();
  }
})();
</script>
