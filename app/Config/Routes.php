<?php

use CodeIgniter\Router\RouteCollection;

/**
 * The Bridal Photography — Routes
 * SEO-corrected per TheBridalPhotography_SEO_Audit_FINAL.pptx
 * All URLs use trailing slash. No .html extensions.
 */

/** @var RouteCollection $routes */

// Homepage
$routes->get('/', 'Home::index');

// Core Pages
$routes->get('/services/', 'Pages::services');
$routes->get('/faq/', 'Pages::faq');
$routes->get('/wedding-films/', 'Pages::weddingFilms');
$routes->get('/contact/', 'Pages::contact');
$routes->post('/contact/send/', 'Pages::contactSend');
$routes->get('/about-us/', 'Pages::aboutUs');

// ── PRE-WEDDING ────────────────────────────────────────────────────────────
// AUTHORITY URL — 3,448 clicks · 183K impressions (audit slide 4)
$routes->get('/pre-wedding-shoot-locations-in-pune/', 'Pages::preWeddingLocations');

// SEO fix Sept 2026 (D1): /pre-wedding-photography-packages/ owns "pre wedding shoot in pune"
$routes->get('/pre-wedding-shoot/', function () {
    return redirect()->to('/pre-wedding-photography-packages/', 301);
});

$routes->get('/pre-wedding-photography-packages/',     'Pages::preWeddingPackages');
$routes->get('/pre-wedding-shoot-pune-under-10000/',   'Pages::preWeddingBudget');
$routes->get('/pre-wedding-shoot-satara/',             'Pages::preWeddingSatara');
$routes->get('/when-to-take-pre-wedding-shoot/',       'Pages::whenPreWedding');
$routes->get('/pre-wedding-shoot-locations-in-goa/',   'Pages::preWeddingGoa');
$routes->get('/pre-wedding-shoot-locations-mumbai/', 'Pages::preWeddingMumbai');
// 301: legacy URLs -> new canonical (preserve SEO equity for any old inbound links)
// SEO fix Sept 2026 (Step 3): turned back on. Both old URLs got impressions in GSC and returned 404
$routes->get('/pre-wedding-shoot-mumbai-locations/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-mumbai/', 301);
});
$routes->get('/pre-wedding-shoot-locations-in-mumbai/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-mumbai/', 301);
});

// Destination pages (Phase 2 URL renames — audit slide 8)
$routes->get('/pre-wedding-shoot-mahabaleshwar/', 'Pages::preWeddingMahabaleshwar');
$routes->get('/pre-wedding-shoot-lonavala/',      'Pages::preWeddingLonavala');
$routes->get('/pre-wedding-shoot-mulshi/',        'Pages::preWeddingMulshi');
$routes->get('/pre-wedding-shoot-lavasa/',        'Pages::preWeddingLavasa');
$routes->get('/pre-wedding-shoot-lakshadweep/',   'Pages::preWeddingLakshadweep');

// ── WEDDING ────────────────────────────────────────────────────────────────
$routes->get('/wedding-photography-packages/', 'Pages::weddingPackages');
$routes->get('/best-destination-wedding-venues-pune/', 'Pages::destinationWeddingVenues');

// ── ENGAGEMENT & ROKA ──────────────────────────────────────────────────────
$routes->get('/engagement-photography-packages/',     'Pages::engagementPackages');
$routes->get('/roka-ring-ceremony-photography-pune/', 'Pages::rokaPackages');

// ── MATERNITY & BABY ───────────────────────────────────────────────────────
$routes->get('/maternity-photographer-pune/',         'Pages::maternityPhotographer');
$routes->get('/maternity-photoshoot-locations-pune/', 'Pages::maternityLocations');
$routes->get('/baby-shower-photography-packages/',    'Pages::babyShowerPackages');
$routes->get('/baby-photoshoot-pune/',                'Pages::babyPhotoshoot');

// ── OTHER SERVICES ─────────────────────────────────────────────────────────
$routes->get('/fashion-and-product-photography/',  'Pages::productPhotography');
$routes->get('/birthday-photography-pune/',        'Pages::birthdayPhotography');
$routes->get('/newborn-photography-pune/',         'Pages::newbornPhotography');
$routes->get('/housewarming-photography-pune/',    'Pages::housewarmingPhotography');

// ── MUMBAI CITY HUB ────────────────────────────────────────────────────────
// Audit: Keep /mumbai/ hub + /pre-wedding-shoot-locations-mumbai/ + /mumbai/engagement-photography-packages/
$routes->get('/mumbai/',                               'CityHub::mumbai');
$routes->get('/mumbai/engagement-photography-packages/', 'CityHub::mumbaiEngagement');

// FIX: /mumbai/pre-wedding-shoot/ and /mumbai/wedding-photographers/ REMOVED (audit slide 6)
// Page review Oct 2026: the locations page is the one Mumbai pre-wedding page. Keep this 301 as is
$routes->get('/mumbai/pre-wedding-shoot/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-mumbai/', 301);
});
// Page review Oct 2026: /mumbai/ is the Mumbai wedding page. Keep this 301 as is
$routes->get('/mumbai/wedding-photographers/', function () {
    return redirect()->to('/mumbai/', 301);
});

// ── AHILYANAGAR CITY HUB ───────────────────────────────────────────────────
$routes->get('/ahilyanagar/',                              'CityHub::ahilyanagar');
$routes->get('/ahilyanagar/pre-wedding-shoot/',            'CityHub::ahilyanagaPreWedding');
$routes->get('/ahilyanagar/wedding-photographers/',        'CityHub::ahilyanagaWedding');
$routes->get('/ahilyanagar/engagement-photographers/',     'CityHub::ahilyanagaEngagement');
$routes->get('/ahilyanagar/maternity-photographer/',       'CityHub::ahilyanagaMaternity');
$routes->get('/ahilyanagar/baby-photoshoot/',              'CityHub::ahilyanagaBaby');
$routes->get('/ahilyanagar/corporate-event-meeting-shoot/', 'CityHub::ahilyanagaCorporate');

// ── MAHABALESHWAR CITY HUB ─────────────────────────────────────────────────
$routes->get('/mahabaleshwar/',                          'CityHub::mahabaleshwar');
$routes->get('/mahabaleshwar/wedding-photographers/',    'CityHub::mahabaleshwarWedding');
// SEO fix Sept 2026 (Step 4): merged into /pre-wedding-shoot-mahabaleshwar/ (duplicate keyword)
$routes->get('/mahabaleshwar/pre-wedding-shoot/', function () {
    return redirect()->to('/pre-wedding-shoot-mahabaleshwar/', 301);
});
$routes->get('/mahabaleshwar/engagement-photographers/', 'CityHub::mahabaleshwarEngagement');

// ── LONAVALA CITY HUB ──────────────────────────────────────────────────────
$routes->get('/lonavala/',                          'CityHub::lonavala');
$routes->get('/lonavala/wedding-photographers/',    'CityHub::lonavalaWedding');
// SEO fix Sept 2026 (Step 4): merged into /pre-wedding-shoot-lonavala/ (duplicate keyword)
$routes->get('/lonavala/pre-wedding-shoot/', function () {
    return redirect()->to('/pre-wedding-shoot-lonavala/', 301);
});
$routes->get('/lonavala/engagement-photographers/', 'CityHub::lonavalaEngagement');

// ── NASHIK CITY HUB ────────────────────────────────────────────────────────
$routes->get('/nashik/',                          'CityHub::nashik');
$routes->get('/nashik/wedding-photographers/',    'CityHub::nashikWedding');
$routes->get('/nashik/pre-wedding-shoot/',        'CityHub::nashikPreWedding');
$routes->get('/nashik/engagement-photographers/', 'CityHub::nashikEngagement');

// ── CHHATRAPATI SAMBHAJINAGAR CITY HUB ─────────────────────────────────────
$routes->get('/chhatrapati-sambhajinagar/',                          'CityHub::sambhajinagar');
$routes->get('/chhatrapati-sambhajinagar/wedding-photographers/',    'CityHub::sambhajinagarWedding');
$routes->get('/chhatrapati-sambhajinagar/pre-wedding-shoot/',        'CityHub::sambhajinagarPreWedding');
$routes->get('/chhatrapati-sambhajinagar/engagement-photographers/', 'CityHub::sambhajinagarEngagement');

// ── BLOG ───────────────────────────────────────────────────────────────────
// 301: Deleted blog posts -> relevant location pages (must come BEFORE /blog/(:segment)/)
$routes->get('/blog/pre-wedding-shoot-locations-in-mumbai/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-mumbai/', 301);
});
$routes->get('/blog/top-7-pre-wedding-shoot-location-in-satara/', function () {
    return redirect()->to('/pre-wedding-shoot-satara/', 301);
});
$routes->get('/blog/5-destinations-for-a-pre-wedding-shoot-in-goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});

// SEO fix Sept 2026 (Step 4): duplicate article. Main page is kept, blog post set to archived
$routes->get('/blog/when-should-i-take-my-pre-wedding-shoot/', function () {
    return redirect()->to('/when-to-take-pre-wedding-shoot/', 301);
});

$routes->get('/blog/',           'Blog::index');
$routes->get('/blog/(:segment)/', 'Blog::detail/$1');

// ── LEGACY 301 REDIRECTS (old WP slugs) ───────────────────────────────────

// Pre-wedding cannibalization cluster (audit slide 4)
$routes->get('/10-beautiful-pre-wedding-photoshoot-locations-in-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/10-beautiful-pre-wedding-shoot-locations-in-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/pre-wedding-shoot-locations-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/what-happens-in-pre-wedding/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/pre-wedding-props-ideas-and-trends-in-2024/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/pre-wedding-photography-in-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/prewedding-shoot-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/pre-wedding-photoshoot-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/pre-wedding-photographer-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});
$routes->get('/outdoor-pre-wedding-shoot-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-pune/', 301);
});

// Destination URL renames (audit slide 8)
$routes->get('/pre-wedding-destinations-in-mahabaleshwar/', function () {
    return redirect()->to('/pre-wedding-shoot-mahabaleshwar/', 301);
});
// SEO fix Sept 2026 (D5): old wedding URL goes to the Mahabaleshwar wedding page
$routes->get('/wedding-photography-mahabaleshwar/', function () {
    return redirect()->to('/mahabaleshwar/wedding-photographers/', 301);
});
$routes->get('/the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography/', function () {
    return redirect()->to('/pre-wedding-shoot-mahabaleshwar/', 301);
});
$routes->get('/pre-wedding-destination-mahabaleshwar/', function () {
    return redirect()->to('/pre-wedding-shoot-mahabaleshwar/', 301);
});
$routes->get('/capturing-love-in-the-lap-of-luxury-trending-pre-wedding-destinations-in-lonavala/', function () {
    return redirect()->to('/pre-wedding-shoot-lonavala/', 301);
});
$routes->get('/capturing-love-in-the-lap-of-luxury-in-lonavala/', function () {
    return redirect()->to('/pre-wedding-shoot-lonavala/', 301);
});
$routes->get('/capturing-love-in-the-serenity-of-mulshi/', function () {
    return redirect()->to('/pre-wedding-shoot-mulshi/', 301);
});
$routes->get('/lavasa-city-a-prewedding-paradise-for-couples/', function () {
    return redirect()->to('/pre-wedding-shoot-lavasa/', 301);
});
$routes->get('/pre-wedding-photoshoots-in-lakshadweep-island-india/', function () {
    return redirect()->to('/pre-wedding-shoot-lakshadweep/', 301);
});
$routes->get('/pre-wedding-shoot-lakshadweep-island/', function () {
    return redirect()->to('/pre-wedding-shoot-lakshadweep/', 301);
});
$routes->get('/pre-wedding-shoot-location-satara/', function () {
    return redirect()->to('/pre-wedding-shoot-satara/', 301);
});
$routes->get('/pre-wedding-shoot-locations-satara/', function () {
    return redirect()->to('/pre-wedding-shoot-satara/', 301);
});
$routes->get('/budget-pre-wedding-shoot-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-pune-under-10000/', 301);
});
$routes->get('/affordable-pre-wedding-shoot-pune/', function () {
    return redirect()->to('/pre-wedding-shoot-pune-under-10000/', 301);
});
$routes->get('/when-should-i-take-my-pre-wedding-shoot/', function () {
    return redirect()->to('/when-to-take-pre-wedding-shoot/', 301);
});
$routes->get('/when-should-i-take-my-pre-wedding-shoot-2024/', function () {
    return redirect()->to('/when-to-take-pre-wedding-shoot/', 301);
});

// SEO fix Sept 2026 (Step 4): duplicate article, the /blog/ version is kept
$routes->get('/candid-birthday-photography-tips/', function () {
    return redirect()->to('/blog/candid-birthday-photography-tips/', 301);
});

// SEO fix Sept 2026 (Step 3): pages that moved into /blog/ (Appendix). These were
// only in htaccess-server (never deployed), so live returned 404
$routes->get('/pre-wedding-shoot-at-snap-city-pune/', function () {
    return redirect()->to('/blog/prewedding-shoot-at-snap-city-pune/', 301);
});
$routes->get('/pre-wedding-shoot-pba-film-city/', function () {
    return redirect()->to('/blog/pre-wedding-shoot-in-pba-film-city-pune/', 301);
});

// Wedding
$routes->get('/packages/', function () {
    return redirect()->to('/wedding-photography-packages/', 301);
});
// SEO fix Sept 2026 (D2): the homepage owns "wedding photographer in pune"
$routes->get('/wedding-photographer-pune/', function () {
    return redirect()->to('/', 301);
});

// Engagement
$routes->get('/engagement-photo-shoot/', function () {
    return redirect()->to('/engagement-photography-packages/', 301);
});
$routes->get('/engagement-photography/', function () {
    return redirect()->to('/engagement-photography-packages/', 301);
});
$routes->get('/engagement-photographer-pune/', function () {
    return redirect()->to('/engagement-photography-packages/', 301);
});
$routes->get('/roka-ceremony-shoot-ring-ceremony-shoot-in-pune/', function () {
    return redirect()->to('/roka-ring-ceremony-photography-pune/', 301);
});
$routes->get('/roka-ceremony-shoot-in-pune/', function () {
    return redirect()->to('/roka-ring-ceremony-photography-pune/', 301);
});
$routes->get('/ring-ceremony-photography-pune/', function () {
    return redirect()->to('/roka-ring-ceremony-photography-pune/', 301);
});

// Baby Shower
$routes->get('/baby-shower-shoot/', function () {
    return redirect()->to('/baby-shower-photography-packages/', 301);
});
$routes->get('/professional-baby-shower-photoshoot/', function () {
    return redirect()->to('/baby-shower-photography-packages/', 301);
});

// Maternity
$routes->get('/maternity-photography-packages/', function () {
    return redirect()->to('/maternity-photographer-pune/', 301);
});
$routes->get('/best-locations-for-a-maternity-photoshoot-in-pune/', function () {
    return redirect()->to('/maternity-photoshoot-locations-pune/', 301);
});

// Service renames
$routes->get('/birthday-photography-services/', function () {
    return redirect()->to('/birthday-photography-pune/', 301);
});
$routes->get('/newborn-photography-services/', function () {
    return redirect()->to('/newborn-photography-pune/', 301);
});
$routes->get('/newborn-photoshoot-pune/', function () {
    return redirect()->to('/newborn-photography-pune/', 301);
});
$routes->get('/housewarming-ceremony-photography-services/', function () {
    return redirect()->to('/housewarming-photography-pune/', 301);
});

// Goa consolidation
$routes->get('/5-destination-for-a-pre-wedding-shoot-in-goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});
$routes->get('/goa/pre-wedding-shoot-in-goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});
$routes->get('/goa/wedding-photoraphers-in-goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});
// SEO fix Sept 2026 (D4): Goa page is the closest match (no Goa engagement page)
$routes->get('/goa/engagement-photographers-in-goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});
$routes->get('/goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});
$routes->get('/mumbai/pre-wedding-shoot-in-goa/', function () {
    return redirect()->to('/pre-wedding-shoot-locations-in-goa/', 301);
});

// Mumbai
$routes->get('/mumbai/engagement-photo-shoot/', function () {
    return redirect()->to('/mumbai/engagement-photography-packages/', 301);
});

// Ahilyanagar typo fixes
$routes->get('/ahilyanagar/wedding-photoraphers-in-ahilyanagar-thebridal-photoraphy/', function () {
    return redirect()->to('/ahilyanagar/wedding-photographers/', 301);
});
$routes->get('/ahilyanagar/wedding-photographers-in-ahilyanagar/', function () {
    return redirect()->to('/ahilyanagar/wedding-photographers/', 301);
});
$routes->get('/ahilyanagar/pre-wedding-shoot-in-ahilyanagar/', function () {
    return redirect()->to('/ahilyanagar/pre-wedding-shoot/', 301);
});
$routes->get('/ahilyanagar/engagement-photographers-in-ahilyanagar/', function () {
    return redirect()->to('/ahilyanagar/engagement-photographers/', 301);
});
$routes->get('/ahilyanagar/maternity-photographers-ahilyanagar/', function () {
    return redirect()->to('/ahilyanagar/maternity-photographer/', 301);
});

// SEO fix Sept 2026 (Step 2): no private jet page exists. /services/ is the only
// page that shows private jet shoots (the homepage "Private Jet" card links there too)
$routes->get('/private-jet-shoot/', function () {
    return redirect()->to('/services/', 301);
});

// Off-brand pages removed
// SEO fix Sept 2026 (D10): /services/ lists event decor (homepage card links there too)
$routes->get('/event-decorators-in-pune/', function () {
    return redirect()->to('/services/', 301);
});
// SEO fix Sept 2026 (D10): /services/ lists political events (homepage card links there too)
$routes->get('/political-events-photoshoot/', function () {
    return redirect()->to('/services/', 301);
});
$routes->get('/bridal-photography-pune/', function () {
    return redirect()->to('/', 301);
});


// Page review Oct 2026: old URLs that returned 404 but still show in GSC
foreach ([
    '/maternity-photoshoot-pune/'                       => '/maternity-photographer-pune/',
    '/pre-wedding-packages/'                            => '/pre-wedding-photography-packages/',
    '/baby-photography-packages/'                       => '/baby-photoshoot-pune/',
    '/stories/'                                         => '/blog/',
    '/lonavala/corporate-event-meeting-shoot/'          => '/lonavala/',
    '/photography-bts/'                                 => '/about-us/',
    '/our-team/'                                        => '/about-us/',
    '/our-branches/'                                    => '/contact/',
    '/choosing-the-best-wedding-photographer-in-pune/'  => '/',
] as $from => $to) {
    $routes->get($from, static fn () => redirect()->to($to, 301));
}

// ── ADMIN ──────────────────────────────────────────────────────────────────
// Login / logout are public; everything else under /admin/ needs a logged-in admin
$routes->get('admin/login/',  'Admin\Auth::login');
$routes->post('admin/login/', 'Admin\Auth::attempt');
$routes->get('admin/logout/', 'Admin\Auth::logout');

    $routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('blogs/', 'Blogs::index');
    $routes->get('blogs/create/', 'Blogs::create');
    $routes->post('blogs/store/', 'Blogs::store');
    $routes->get('blogs/edit/(:num)/', 'Blogs::edit/$1');
    $routes->post('blogs/update/(:num)/', 'Blogs::update/$1');
    $routes->post('blogs/delete/(:num)/', 'Blogs::delete/$1');
    $routes->post('blogs/upload-image/', 'Blogs::uploadImage');

    // Per-post CTA management
    $routes->get('blogs/(:num)/ctas/',                        'BlogCtas::index/$1');
    $routes->get('blogs/(:num)/ctas/create/',                 'BlogCtas::create/$1');
    $routes->post('blogs/(:num)/ctas/store/',                 'BlogCtas::store/$1');
    $routes->get('blogs/(:num)/ctas/edit/(:num)/',            'BlogCtas::edit/$1/$2');
    $routes->post('blogs/(:num)/ctas/update/(:num)/',         'BlogCtas::update/$1/$2');
    $routes->post('blogs/(:num)/ctas/delete/(:num)/',         'BlogCtas::delete/$1/$2');
});