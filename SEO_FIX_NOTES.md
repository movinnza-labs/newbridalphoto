# SEO Fix Notes: thebridal.photography

Work log for the fixes in `Bridal_Photography_Traffic_Drop_Analysis.docx` (Sections 8, 9, 10, 11, 13 and the Appendix).
Nothing here has been deployed. All testing is on localhost (`http://localhost:8080/thebridal/`).

**Read this first:** Steps 0–9 are the first round. Some items there say "waits on D1" and so on. Those decisions were answered and applied on 29 Sept 2026. See **DECISIONS**, **Round 2**, **Step 10 (re-run)**, the **.htaccess diff** and the **FINAL REPORT** (with the deploy checklist) at the end. Those sections are the current state.

---

## Step 0. What the project looks like (read only, nothing changed)

**Framework:** CodeIgniter 4.7.2, PHP 8.2. The project root is the web root (`index.php` sits in the root, not in `public/`).

**Live site:** already runs this same CodeIgniter code. A check of the live site on 29 Sept 2026 gave the same results as localhost for every old URL.

### Routes
- All routes are in `app/Config/Routes.php`. There are no other route files.
- Page routes point to 4 controllers: `Home`, `Pages`, `CityHub`, `Blog`.
- Old URL redirects are closures in `Routes.php` (`return redirect()->to('/new/', 301)`). This is the main redirect system.
- Blog posts come from the database table `tb_blogs` and use the route `/blog/(:segment)/`.

### Where redirects live today
| Place | Used on | What it does |
|---|---|---|
| `app/Config/Routes.php` | local + live | About 70 old-URL 301s (the main list) |
| `.htaccess` (root) | localhost | Adds trailing slash (301). No HTTPS or www rule |
| `htaccess-server` | meant for live, **not deployed yet** | Same as `.htaccess` plus www to non-www, plus 7 `Redirect 301` lines (some are wrong, see below) |
| `public/.htaccess` | not used | The site does not run from `public/` |
| Database | none | No redirect table |

Proof that `htaccess-server` is not live: it redirects `/candid-birthday-photography-tips/` to the blog, but live returns 404 for that URL.

**Problems found in `htaccess-server`:**
- `/when-should-i-take-my-pre-wedding-shoot-2024/` goes to the /blog/ copy. It should go to `/when-to-take-pre-wedding-shoot/` (the page to KEEP).
- `/wedding-photography-mahabaleshwar/` goes to a blog post. Step 2 asks for `/mahabaleshwar/`.
- `Redirect 301` lines run before the router, so they override the routes. Keeping all redirects in one place (Routes.php) is safer.

### Titles, meta descriptions, canonical, H1
- Title, meta description and canonical are set in each controller method (`title`, `description`, `canonical`) and printed by the shared layout `app/Views/layouts/main.php`.
- The layout already prints `<link rel="canonical" href="https://thebridal.photography<?= $canonical ?>">` on every page. All 66 live pages have a correct self-referencing canonical with a trailing slash.
- Blog posts use `meta_title` / `meta_description` from the database.
- H1s are hard-coded inside each page view in `app/Views/pages/...`.
- `/pre-wedding-photography-packages/` has **no meta description** (it falls back to the generic site text).
- Many titles are over 60 characters (full list in Step 5).

### Homepage (`app/Views/pages/home.php`)
- **Instagram feed:** there is no Instagram feed widget in the current code. The "No feed with the ID 1" error was from the old WordPress site. The current live homepage does not show it.
- **Counters:** already plain numbers in the HTML (1,179+ couples, 10+ years, 1251+ happy clients). No JavaScript count-up. Nothing shows "1+".
- **WhatsApp:** the link is built in PHP in the layout, with the real site name, page name and URL. No `{SITE}` placeholders anywhere in the code.
- **Spelling:** "Crafting Timeless Memorie" is still in `home.php` line 256. Needs a fix.
- So most of Section 11 was fixed during the move. Only the spelling is left (Step 7).

### Sitemap and robots
- `sitemap.xml` in the root is a **static file** made by xml-sitemaps.com (61 URLs, all lastmod 2026-06-29). No controller builds it.
- `robots.txt` allows everything except `/demo/` and points to the sitemap. OK.

### Live page list (66 URLs return 200)
Home, 6 core pages, 14 pre-wedding pages, 2 wedding pages, 2 engagement pages, 4 maternity/baby pages, 4 other service pages, 5 city hubs + 21 city sub pages, blog index + 7 blog posts. Full table is in Step 5.

### Other things found
1. **HEAD requests return 404 on every page (local and live).** Routes only answer GET. `curl -I` and some SEO tools use HEAD, so they see 404 on pages that are fine. Googlebot uses GET, so rankings are not hit directly, but checks and some crawlers give wrong results.
2. **HTTP is not forced to HTTPS on live.** `http://thebridal.photography/` returns 200 (no redirect). `http://www...` redirects to `https://` in one hop, but without a slash it then needs a second hop.
3. **A test blog post is live:** `/blog/odio-non-quo-rerum-a/` ("Sunt molestiae vitae", lorem ipsum text) returns 200 on live. Should be set to draft (needs your OK).
4. **Blog posts link to old URLs** inside their content: `/pre-wedding-shoot/`, `/wedding-photographer-pune/`, `/5-destination-for-a-pre-wedding-shoot-in-goa/`, `/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/`.
5. **`/mumbai/pre-wedding-shoot/` is a redirect, not a page.** Routes send it to `/mumbai/`. The view `pages/city/mumbai-prewedding.php` exists but is thin (3 locations, 2 FAQs). The brief says to keep it as the service page. See NEEDS DECISION.
6. `/private-jet-shoot/`, `/pre-wedding-shoot-at-snap-city-pune/`, `/pre-wedding-shoot-pba-film-city/` and `/candid-birthday-photography-tips/` return **404** on live.
7. `/pre-wedding-shoot-locations-in-mumbai` (no slash) goes to the slash version, which is a **404**.
8. Many backup copies sit next to real files (`Routes.php13-5-26`, `Pages.php1-6-26` and so on). They are not loaded by the app. I left them alone.

### Redirect baseline (before any change)
`tools/check_redirects.sh` was run on localhost and live. Results were the same. 34 of 40 URLs were already one clean 301 to a 200 page. Problems:
```
/private-jet-shoot/                              404
/pre-wedding-shoot-at-snap-city-pune/            404
/pre-wedding-shoot-pba-film-city/                404
/blog/when-should-i-take-my-pre-wedding-shoot/   200 (duplicate, should 301)
/candid-birthday-photography-tips/               404
/pre-wedding-shoot-locations-in-mumbai           301 -> 404
```
Some 301s work but go to the wrong page (for example `/pre-wedding-shoot/` goes to the locations guide). These are covered in Step 2.

---

## Step 1. Trailing slash, HTTPS, canonical (Section 8.6, Action 8)

**Changed files**
| File | Change | Why |
|---|---|---|
| `index.php` | HEAD requests are treated as GET (4 lines at the top) | Every HEAD request returned 404. Now `curl -I` and crawlers that use HEAD see the real status |
| `.htaccess` (local) | New one-hop rule for `http://` and `www.` to `https://thebridal.photography`, adding the slash in the same hop. It only fires for the live domain, so localhost works as before. Trailing-slash rule now skips any URL with a file extension (it had missed `.xml`, `.txt`, `.php`) and `/admin` | Section 8.6, one hop |
| `htaccess-server` (for live) | Same block. Replaces the old www rule and the commented-out HTTPS rule | Old rules gave 2 hops (`http://www/x` then `/x/`), and plain `http://` was never sent to HTTPS |
| `app/Views/layouts/main.php` | If a controller forgets `canonical`, the layout now uses the page's own URL with a slash. Before, it fell back to `/` (homepage) | Every page must have a self canonical. All 66 pages already had one, so nothing changes on the page today |

**Tests (localhost)**
```
/pre-wedding-shoot-locations-in-pune     301 -> /pre-wedding-shoot-locations-in-pune/   (200, canonical ok)
/maternity-photographer-pune             301 -> /maternity-photographer-pune/           (200, canonical ok)
/pre-wedding-shoot-locations-mumbai      301 -> /pre-wedding-shoot-locations-mumbai/    (200, canonical ok)
/when-to-take-pre-wedding-shoot          301 -> /when-to-take-pre-wedding-shoot/        (200, canonical ok)
/mumbai                                  301 -> /mumbai/                                (200, canonical ok)
/maternity-photographer-pune?x=1         301 -> /maternity-photographer-pune/?x=1       (query string kept)
/assets/css/main.css, /sitemap.xml, /robots.txt   200 (no slash added)
/admin/login                             200 (no slash added)
Host www.thebridal.photography /maternity-photographer-pune   301 -> https://thebridal.photography/maternity-photographer-pune/  (one hop)
Host thebridal.photography (http) /                           301 -> https://thebridal.photography/                            (one hop)
HEAD /  200,  HEAD /pre-wedding-shoot/  301,  HEAD /no-such-page/  404
```
All 66 pages: canonical = own URL, https, trailing slash.

**Manual check after deploy:** the live `.htaccess` must be replaced with `htaccess-server` (renamed to `.htaccess`). Then test `http://thebridal.photography/`, `http://www.thebridal.photography/maternity-photographer-pune` and `https://www.thebridal.photography/`. Each must be one 301 to `https://thebridal.photography/.../`. If the host's panel also forces HTTPS, it will still be one hop, because our rule sends straight to the final URL.

---

## Step 2. Old URLs with no clear new home (Section 8.5, Action 6)

| Old URL | Before | Now | Status |
|---|---|---|---|
| `/pre-wedding-shoot/` | 301 to `/pre-wedding-shoot-locations-in-pune/` | unchanged for now | **NEEDS DECISION** (D1). It must go to the page that owns "pre wedding shoot in pune" |
| `/wedding-photographer-pune/` | 301 to `/wedding-photography-packages/` | unchanged for now | **NEEDS DECISION** (D2) |
| `/packages/` | 301 to `/wedding-photography-packages/` | unchanged | **NEEDS DECISION** (D3). No packages hub page exists |
| `/mumbai/wedding-photographers/` | 301 to `/mumbai/` | unchanged, correct | `/mumbai/` is the Mumbai service page ("Photographers in Mumbai") |
| `/maternity-photography-packages/` | 301 to `/maternity-photographer-pune/` | unchanged, correct | Maternity service page |
| `/goa/engagement-photographers-in-goa/` | 301 to `/engagement-photography-packages/` | unchanged | No Goa engagement page exists. Current target is the closest. See D4 |
| `/private-jet-shoot/` | **404** | **301 to `/services/`** | No private jet page. `/services/` is the only page with private jet work, and the homepage "Private Jet" card already links there |
| `/wedding-photography-mahabaleshwar/` | 301 to `/pre-wedding-shoot-mahabaleshwar/` | **301 to `/mahabaleshwar/`** | As asked. Note: `/mahabaleshwar/wedding-photographers/` is an even closer match for a "wedding" URL, see D5 |

Changed: `app/Config/Routes.php` (2 routes).

---

## Step 3. Redirect chains and double moves (Section 8.1, Actions 1 and 2)

**3.1 Double moves.** All six were already one hop to the final page (checked local and live). No change needed:
```
/blog/pre-wedding-shoot-locations-in-mumbai/          301 -> /pre-wedding-shoot-locations-mumbai/
/blog/top-7-pre-wedding-shoot-location-in-satara/     301 -> /pre-wedding-shoot-satara/
/pre-wedding-shoot-location-satara/                   301 -> /pre-wedding-shoot-satara/
/blog/5-destinations-for-a-pre-wedding-shoot-in-goa/  301 -> /pre-wedding-shoot-locations-in-goa/
/5-destination-for-a-pre-wedding-shoot-in-goa/        301 -> /pre-wedding-shoot-locations-in-goa/
/goa/pre-wedding-shoot-in-goa/                        301 -> /pre-wedding-shoot-locations-in-goa/
```

**3.2 Appendix rows.** All rows were one 301 to the listed page, except:
| Old URL | Before | Now |
|---|---|---|
| `/pre-wedding-shoot-at-snap-city-pune/` | 404 on live | 301 to `/blog/prewedding-shoot-at-snap-city-pune/` |
| `/pre-wedding-shoot-pba-film-city/` | 404 on live | 301 to `/blog/pre-wedding-shoot-in-pba-film-city-pune/` |
| `/maternity-photography-packages/` ("Not clear") | 301 to `/maternity-photographer-pune/` | unchanged, matches Step 2 |

These two were only in `htaccess-server`, which was never deployed.

**Also fixed**
- `/pre-wedding-shoot-locations-in-mumbai/` and `/pre-wedding-shoot-mumbai-locations/` returned 404. Their redirects were commented out in Routes.php. Turned back on: 301 to `/pre-wedding-shoot-locations-mumbai/`.
- `/pre-wedding-shoot-locations-in-mumbai` (no slash, in GSC) gave 2 hops. Added one targeted rule in both .htaccess files so it is one hop.
- Removed the 7 `Redirect 301` lines from `htaccess-server`. Every old-URL redirect is now in `Routes.php` only. Two of those lines were wrong: the `-2024` "when" URL pointed to the /blog/ copy, and the Mahabaleshwar wedding URL pointed to a blog post.

**3.3 Misspelled URLs.** Both already one 301:
`/goa/wedding-photoraphers-in-goa/` goes to `/pre-wedding-shoot-locations-in-goa/` (no Goa wedding page exists).
`/ahilyanagar/wedding-photoraphers-in-ahilyanagar-thebridal-photoraphy/` goes to `/ahilyanagar/wedding-photographers/`.

**3.4 Internal links to old URLs.** Views, menus, footer and sitemap had none. Old links were only inside blog post content (database):
| Post | Link | Anchor text | Action |
|---|---|---|---|
| PBA Film City | `/5-destination-for-a-pre-wedding-shoot-in-goa/` | "5 Pre-wedding Destinations In Goa" | **Fixed** to `/pre-wedding-shoot-locations-in-goa/` |
| PBA Film City | `/pre-wedding-shoot/` | "Pre wedding shoot Pune" | Waits on D1 (money keyword anchor) |
| Snap City | `/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/` | "pre wedding shoot Pune" | Waits on D1 |
| Mahabaleshwar charm | `/pre-wedding-shoot/` | "pre-wedding photography" | Waits on D1 |
| Mahabaleshwar charm | `/wedding-photographer-pune/` | "wedding photographers in Pune" | Waits on D2 |

Database changes are collected in **`tools/seo_fix_db_updates.sql`**. They must be run on the live database, because copying files will not move them.

**Known small gap:** an old URL typed **without** its slash (for example `/pre-wedding-shoot`) still takes 2 hops: slash first, then the final page. Only `/pre-wedding-shoot-locations-in-mumbai` shows up this way in GSC, and that one is fixed.

**3.5 Script:** `tools/check_redirects.sh`. Run with `bash tools/check_redirects.sh http://localhost:8080/thebridal` or with `https://thebridal.photography` after deploy. The final results are in Step 10.

---

## Step 4. Duplicate pages and articles (Section 10, Action 7)

| Kept page | Removed page (now 301 to kept) | Content moved | Notes |
|---|---|---|---|
| `/when-to-take-pre-wedding-shoot/` | `/blog/when-should-i-take-my-pre-wedding-shoot/` | None needed | Same article. The blog copy is a longer wording of the same sections, with no extra photos, FAQ or prices. The blog post is set to `archived` so the blog list and "related articles" stop linking to it. `/when-should-i-take-my-pre-wedding-shoot-2024/` already went to the kept page in one hop |
| `/blog/candid-birthday-photography-tips/` | `/candid-birthday-photography-tips/` | None | The root URL was already a 404 (no page), so there was nothing to merge. Now it is a 301 |
| **`/pre-wedding-shoot-lonavala/`** | `/lonavala/pre-wedding-shoot/` | Gallery (9 photos, shared gallery block), 3 FAQs (best places incl. Lion's Point; poses and outfits; number of photos) | See "which Lonavala page I kept" below |
| **`/pre-wedding-shoot-mahabaleshwar/`** | `/mahabaleshwar/pre-wedding-shoot/` | Location grid (Arthur Seat, Wilson Point, Elephant's Head, Mapro Garden, Lingmala Waterfall, Venna Lake), 5 FAQs (best place, best time, poses and outfit guide, what the package includes plus price, number of photos), gallery | The root page had no FAQ at all before |
| `/mumbai/pre-wedding-shoot/` and `/pre-wedding-shoot-locations-mumbai/` | none | none | Not merged, as asked. **But `/mumbai/pre-wedding-shoot/` is not a live page today.** It 301s to `/mumbai/`. See D6 |

**Which Lonavala and Mahabaleshwar pages I kept, and why**

| | Root page (kept) | City folder page (redirected) |
|---|---|---|
| Lonavala: internal links | 9 (from 7 location pages) | 5 (only from the 3 Lonavala city pages) |
| Lonavala: words on page | about 660 | about 1,100 (mostly general copy) |
| Lonavala: GSC position (doc) | 19.9 | 53.8 |
| Mahabaleshwar: internal links | 10 | 5 |
| Mahabaleshwar: words on page | about 590 before merge | about 1,250 |
| Old WordPress URLs that 301 here | yes (3 Lonavala, 4 Mahabaleshwar) | none |

The root pages have more internal links, rank better, and already receive the old WordPress redirects. Keeping them means no existing redirect has to change, and no chains appear. The folder pages had more words, so their useful parts were moved into the root pages. Generic parts ("why choose us", "our process", unnamed testimonials) were not moved.

**Links updated (href only, anchor text unchanged):** 5 links in `city/lonavala/index.php`, `wedding.php`, `engagement.php`, and 5 in `city/mahabaleshwar/index.php`, `wedding.php`, `engagement.php`.

**Files changed:** `Routes.php` (3 routes changed to 301s, 1 added), `pages/pre-wedding-lonavala.php`, `pages/pre-wedding-mahabaleshwar.php`, 6 city views (hrefs only), database (1 post archived, in `tools/seo_fix_db_updates.sql`).
The unused controller methods `CityHub::lonavalaPreWedding` / `mahabaleshwarPreWedding` and their views were left in place, so this is easy to undo.

**Manual check:** open `/pre-wedding-shoot-lonavala/` and `/pre-wedding-shoot-mahabaleshwar/` in a browser. Check that the new FAQ blocks open and close, and that the gallery looks right on mobile.

---

## Step 5. Keyword ownership: titles, H1, meta (Sections 9 and 10, Actions 3, 5, 7)

**Status: APPLIED on 29 Sept 2026 (approved as D11).** Titles and descriptions are in the controllers, H1s in the views. The table below shows the old and new values. The packages page first paragraph was NOT changed (see Round 2).

### Who owns "pre wedding shoot in pune"?
There is **no dedicated Pune pre-wedding service page** today. The old `/pre-wedding-shoot/` page is gone. It now 301s to the locations guide, so the guide, the under-10000 page, the packages page and the homepage all compete.

**My proposal: `/pre-wedding-photography-packages/` owns "pre wedding shoot in pune", "pre wedding photoshoot in pune", "pre wedding shoot packages" and "price".** Reasons:
- It is the only Pune pre-wedding page with commercial intent (packages, prices, booking).
- It matches the doc's own rule (Section 10: "pre wedding shoot in [city]" and "packages/price" go to the packages page).
- The locations guide keeps its strong "locations" ranking (position 2.3) without being pulled in two directions.
- It has no meta description today, so it gains the most from a clear title and description.
- The homepage then owns "wedding photographer in pune", and `/wedding-photography-packages/` owns "wedding photography packages / price".

If you approve, these follow automatically:
- `/pre-wedding-shoot/` 301s to `/pre-wedding-photography-packages/` (D1)
- the Step 6 "pre wedding shoot in Pune" links point there
- the blog links in Step 3.4 point there

### Titles and H1s (applied)
"(keep)" means the H1 already fits and I would not change it. Title limit 60, description limit 155. There are no em dashes. Old descriptions that had em dashes are replaced.

| Page | Old title | New title | Old H1 | New H1 |
|---|---|---|---|---|
| `/` | The Bridal Photography &#124; Best Wedding Photographers in Pune & Mumbai (68) | **Wedding Photographer in Pune &#124; The Bridal Photography** (53) | Pune's Premier Photography Studio | Wedding Photographers in Pune |
| `/pre-wedding-photography-packages/` | Pre-Wedding Photography Packages Pune 2026 &#124; The Bridal Photography (67) | **Pre Wedding Shoot in Pune &#124; Packages and Price 2026** (51) | Pre-Wedding Photo Shoot Packages: Capturing the Essence of Your Love Story | Pre Wedding Shoot in Pune: Packages and Prices |
| `/pre-wedding-shoot-locations-in-pune/` | 20 Best Pre-Wedding Shoot Locations in Pune [2026] &#124; The Bridal Photography (75) | **20 Best Pre Wedding Shoot Locations in Pune (2026)** (50) | Pre-Wedding Photography | Pre Wedding Shoot Locations in Pune |
| `/pre-wedding-shoot-pune-under-10000/` | Pre-Wedding Shoot in Pune Under ₹10,000 &#124; Budget Packages &#124; The Bridal (70) | **Pre Wedding Shoot Under 10000 in Pune &#124; Budget Package** (54) | Pre Wedding Shoot Under Rs.10000/- in Pune | Budget Pre Wedding Shoot Under Rs 10,000 in Pune |
| `/wedding-photography-packages/` | Wedding Photography Packages Pune &#124; Gold ₹35K · Platinum ₹55K · Diamond ₹75K (76) | **Wedding Photography Packages in Pune &#124; Price 2026** (49) | We 'The Bridal Photography' - Select the Most Appropriate Wedding Photography Packages | Wedding Photography Packages and Prices in Pune |
| `/maternity-photographer-pune/` | Maternity Photographer in Pune &#124; Packages from ₹6,000 &#124; The Bridal Photography (78) | **Maternity Photographer in Pune &#124; Photoshoot from Rs 6,000** (57) | Maternity Photoshoot in Pune: Cherishing the Beauty of Your Pregnancy | (keep) Maternity Photoshoot in Pune: Cherishing the Beauty of Your Pregnancy |
| `/maternity-photoshoot-locations-pune/` | Maternity Photoshoot Locations in Pune &#124; Best Spots &#124; The Bridal Photography (76) | **Best Maternity Photoshoot Locations in Pune (2026)** (50) | What are the best locations for a maternity photo shoot in Pune | Best Maternity Photoshoot Locations in Pune |
| `/pre-wedding-shoot-satara/` | Pre-Wedding Shoot in Satara &#124; Kaas Plateau & More &#124; The Bridal Photography (74) | **7 Best Pre Wedding Shoot Locations in Satara (2026)** (51) | Top 7 Pre Wedding Shoot Location in Satara | Top 7 Pre Wedding Shoot Locations in Satara |
| `/pre-wedding-shoot-locations-mumbai/` | Pre-Wedding Shoot Locations in Mumbai &#124; The Bridal Photography (62) | **Best Pre Wedding Shoot Locations in Mumbai (2026)** (49) | Pre-Wedding Shoot Locations in Mumbai: A guide to choosing the perfect Spot | Pre Wedding Shoot Locations in Mumbai |
| `/pre-wedding-shoot-locations-in-goa/` | Pre-Wedding Shoot in Goa &#124; Best Locations & Packages &#124; The Bridal Photography (77) | **Pre Wedding Shoot in Goa &#124; Best Locations and Packages** (54) | 5 Destinations for a Pre-Wedding Shoot In Goa | (keep) 5 Destinations for a Pre-Wedding Shoot In Goa |
| `/pre-wedding-shoot-mahabaleshwar/` | Pre-Wedding Shoot in Mahabaleshwar &#124; The Bridal Photography (59) | **Pre Wedding Shoot in Mahabaleshwar &#124; Best Locations** (51) | Mahabaleshwar Pre-Wedding Destination | Pre Wedding Shoot in Mahabaleshwar |
| `/pre-wedding-shoot-lonavala/` | Pre-Wedding Shoot in Lonavala &#124; The Bridal Photography (54) | **Pre Wedding Shoot in Lonavala &#124; Best Locations** (46) | Pre-Wedding Shoot in Lonavala | (keep) Pre-Wedding Shoot in Lonavala |
| `/mumbai/` | Photographers in Mumbai &#124; Wedding & Pre-Wedding &#124; The Bridal (60) | **Photographers in Mumbai &#124; The Bridal Photography** (48) | Photoshoot in Mumbai | Photographers in Mumbai |
| `/mahabaleshwar/` | Photoshoot in Mahabaleshwar &#124; Wedding, Pre-Wedding & Engagement &#124; The Bridal Photography (88) | **Photographers in Mahabaleshwar &#124; The Bridal Photography** (55) | Photoshoot in Mahabaleshwar | Photographers in Mahabaleshwar |
| `/lonavala/` | Photoshoot in Lonavala &#124; Wedding, Pre-Wedding & Engagement &#124; The Bridal Photography (83) | **Photographers in Lonavala &#124; The Bridal Photography** (50) | Photoshoot in Lonavala | Photographers in Lonavala |
| `/nashik/` | Photoshoot in Nashik &#124; Wedding, Pre-Wedding & Engagement &#124; The Bridal Photography (81) | **Photographers in Nashik &#124; The Bridal Photography** (48) | Photoshoot in Nashik | Photographers in Nashik |
| `/chhatrapati-sambhajinagar/` | Photographers in Chhatrapati Sambhajinagar &#124; Wedding, Pre-Wedding & Engagement &#124; The Bridal Photography (103) | **Photographers in Chhatrapati Sambhajinagar &#124; The Bridal** (55) | Photographers in Sambhajinagar | Photographers in Chhatrapati Sambhajinagar |
| `/ahilyanagar/` | Photographer in Ahilyanagar &#124; Wedding & More &#124; The Bridal (57) | **Photographers in Ahilyanagar &#124; The Bridal Photography** (53) | Professional Photoshoot in Ahilyanagar - Capture Your Special Moments Perfectly | Photographers in Ahilyanagar |
| `/nashik/pre-wedding-shoot/` | Pre-Wedding Shoot in Nashik &#124; Best Locations & Packages &#124; The Bridal Photography (80) | **Pre Wedding Shoot in Nashik &#124; The Bridal Photography** (52) | Pre-Wedding Shoot in Nashik | (keep) Pre-Wedding Shoot in Nashik |
| `/chhatrapati-sambhajinagar/pre-wedding-shoot/` | Pre Wedding Shoot in Chhatrapati Sambhaji Nagar &#124; The Bridal Photography (72) | **Pre Wedding Shoot in Chhatrapati Sambhajinagar** (46) | Pre Wedding Shoot in Chhatrapati Sambhaji Nagar | Pre Wedding Shoot in Chhatrapati Sambhajinagar |
| `/ahilyanagar/pre-wedding-shoot/` | Pre-Wedding Shoot in Ahilyanagar &#124; Best Locations & Packages &#124; The Bridal (73) | **Pre Wedding Shoot in Ahilyanagar &#124; The Bridal** (45) | The Best Pre-wedding Shoot In Ahilyanagar | Pre Wedding Shoot in Ahilyanagar |

**Meta descriptions**

| Page | Old meta description | New meta description |
|---|---|---|
| `/` | Award-winning wedding, pre-wedding & maternity photography in Pune & Mumbai. 4.9★ · 1,179 reviews. Packages from ₹6,000. Book: +91 83903 67637. | Wedding photographer in Pune since 2014. Wedding, pre wedding and maternity shoots in Pune, Mumbai and Goa. 4.9 stars from 1,179 reviews. From Rs 6,000. (152) |
| `/pre-wedding-photography-packages/` | Award-winning wedding & pre-wedding photography in Pune & Mumbai. | Pre wedding shoot in Pune from Rs 14,999. Silver, Gold and Diamond packages with 50 to 300 edited photos at the best Pune locations. Call +91 83903 67637. (154) |
| `/pre-wedding-shoot-locations-in-pune/` | Discover Pune's most stunning pre-wedding locations — hills, heritage forts & scenic film sets. Packages from ₹14,999. Book: +91 83903 67637. | The 20 best pre wedding shoot locations in Pune, from forts and gardens to film sets like Snapcity and PBA. Cost and features of each spot. (139) |
| `/pre-wedding-shoot-pune-under-10000/` | Budget pre-wedding shoot in Pune under ₹10,000. Professional Sony cameras. 35 edited photos. Book: +91 83903 67637. | Cheap pre wedding shoot under Rs 10,000 in Pune. A budget package with pro Sony cameras and 35 edited photos. Call +91 83903 67637 to book. (139) |
| `/wedding-photography-packages/` | Wedding photography packages in Pune from ₹35,000/day. Gold, Platinum & Diamond. 250 photos + videographer included. 4.9★. | Wedding photography packages in Pune from Rs 35,000 per day. Gold, Platinum and Diamond price list, 250 photos and a videographer included. 4.9 stars. (150) |
| `/maternity-photographer-pune/` | Maternity photography in Pune from ₹6,000. Designer gowns provided free. Studio & outdoor. 4.9★. Book: +91 83903 67637. | Maternity photographer in Pune. Maternity photoshoot packages from Rs 6,000 with free designer gowns, studio and outdoor shoots. 4.9 stars. Call to book. (153) |
| `/maternity-photoshoot-locations-pune/` | Best maternity photoshoot locations in Pune — Mulshi Lake, Empress Garden, Pavana & more. Book: +91 83903 67637. | Best maternity photoshoot locations in Pune: Osho Garden, Empress Garden, Pashan Lake, Vetal Tekdi, University of Pune and more, with tips for each. (148) |
| `/pre-wedding-shoot-satara/` | Pre-wedding shoot in Satara — Kaas Plateau, Thoseghar Falls, Sajjangad Fort. Packages from ₹14,999. Book: +91 83903 67637. | Kaas Plateau, Thoseghar, Vajrai Waterfall, Ajinkyatara Fort and 3 more pre wedding shoot locations in Satara. Best season and prices from Rs 14,999. (148) |
| `/pre-wedding-shoot-locations-mumbai/` | Marine Drive, Bandra, Film City & more. 6 curated Mumbai pre-wedding locations. Packages from ₹14,999. | Best pre wedding shoot locations in Mumbai: Marine Drive, Bandra, Film City and more. Best timings and tips for each spot. Packages from Rs 14,999. (147) |
| `/pre-wedding-shoot-locations-in-goa/` | Pre-wedding shoot in Goa — beaches, forts, heritage. Best Oct–Feb. Packages from ₹14,999. Book: +91 83903 67637. | Pre wedding shoot in Goa at beaches, forts and heritage spots. Best from October to February. Packages from Rs 14,999. Book: +91 83903 67637. (141) |
| `/pre-wedding-shoot-mahabaleshwar/` | Pre-wedding shoot in Mahabaleshwar at Venna Lake, Arthur Seat, Mapro Garden and Wilson Point. Packages from Rs 14,999. Book: +91 83903 67637. | Pre wedding shoot in Mahabaleshwar at Arthur Seat, Wilson Point, Venna Lake and Mapro Garden. Packages from Rs 14,999. Book: +91 83903 67637. (141) |
| `/pre-wedding-shoot-lonavala/` | Pre-wedding shoot in Lonavala at Bhushi Dam, Tiger Point, Rajmachi and more. Best during monsoon. Packages from Rs 14,999. Book: +91 83903 67637. | Pre wedding shoot in Lonavala at Bhushi Dam, Tiger Point, Lion's Point and Rajmachi. Best in monsoon. Packages from Rs 14,999. Book: +91 83903 67637. (149) |
| `/mumbai/` | The Bridal Photography covers all of Mumbai — wedding, pre-wedding, engagement & maternity. Marine Drive, Bandra, Film City. +91 83903 67637. | Photographers in Mumbai for weddings, pre wedding, engagement and maternity shoots at Marine Drive, Bandra and Film City. Call +91 83903 67637. (143) |
| `/mahabaleshwar/` | Photoshoot in Mahabaleshwar by The Bridal Photography. Arthur's Seat, Wilson Point, Venna Lake & more. Pre-wedding, wedding & engagement. Book: +91 83903 67637. | Photographers in Mahabaleshwar for weddings, pre wedding and engagement shoots at Arthur Seat, Wilson Point and Venna Lake. Call +91 83903 67637. (145) |
| `/lonavala/` | Photoshoot in Lonavala by The Bridal Photography. Tiger Point, Lion Point, Pawna Lake, Bhushi Dam & more. Pre-wedding, wedding & engagement. Book: +91 83903 67637. | Photographers in Lonavala for weddings, pre wedding and engagement shoots at Tiger Point, Pawna Lake and Bhushi Dam. Call +91 83903 67637. (138) |
| `/nashik/` | Photoshoot in Nashik by The Bridal Photography. Sula Vineyards, Anjneri Hill, Panchavati, Gangapur Dam & more. Pre-wedding, wedding & engagement. Book: +91 83903 67637. | Photographers in Nashik for weddings, pre wedding and engagement shoots at Sula Vineyards, Anjneri Hill and Gangapur Dam. Call +91 83903 67637. (143) |
| `/chhatrapati-sambhajinagar/` | Photographers in Chhatrapati Sambhajinagar. Wedding, pre-wedding, engagement & corporate photography. Heritage, candid & cinematic. Book: +91 83903 67637. | Photographers in Chhatrapati Sambhajinagar for weddings, pre wedding, engagement and corporate shoots. Heritage and candid. Call +91 83903 67637. (145) |
| `/ahilyanagar/` | Best photographers in Ahilyanagar for wedding, pre-wedding, engagement, maternity & baby shoots. 4.9★. Book: +91 83903 67637. | Photographers in Ahilyanagar for wedding, pre wedding, engagement, maternity and baby shoots. 4.9 stars. Call +91 83903 67637. (126) |
| `/nashik/pre-wedding-shoot/` | Pre-wedding shoot in Nashik. Sula Vineyards, Pandavleni Caves, Gangapur Dam & more. Cinematic storytelling. Book: +91 83903 67637. | Pre wedding shoot in Nashik at Sula Vineyards, Pandavleni Caves, Gangapur Dam and more. Cinematic couple shoots. Book: +91 83903 67637. (135) |
| `/chhatrapati-sambhajinagar/pre-wedding-shoot/` | Pre-wedding shoot in Chhatrapati Sambhajinagar. Heritage, garden & urban locations. Cinematic storytelling. Book: +91 83903 67637. | Pre wedding shoot in Chhatrapati Sambhajinagar at heritage, garden and city locations. Cinematic couple shoots. Book: +91 83903 67637. (134) |
| `/ahilyanagar/pre-wedding-shoot/` | Professional pre-wedding photography in Ahilyanagar. Ahmednagar Fort, Bhandardara Lake & more. From ₹14,999. | Pre wedding shoot in Ahilyanagar at Ahmednagar Fort, Bhandardara Lake and more. Packages from Rs 14,999. Book: +91 83903 67637. (127) |

Notes on the table:
- **Satara (Action 3):** the title now has "Satara", "pre wedding shoot locations", the number 7 and 2026. The description names 4 spots and the price. The body got a 3-question FAQ with the price in it (done, see below). The quick-facts bar already showed the price.
- **Under 10000:** the title no longer starts with "Pre Wedding Shoot in Pune". It leads with "under 10000" and "budget/cheap", so it stops competing with the owner page.
- **Goa:** the "strong winner" page. I only shortened the title (removed the brand, 81 to 52 characters) and removed the em dash from the description. The H1 stays.
- **City hubs** move from "Photoshoot in [city]" to "Photographers in [city]". **City pre-wedding pages** use "Pre Wedding Shoot in [city]". **Guides** use "... Locations in [city]".
- **Merged Lonavala and Mahabaleshwar pages** serve both "pre wedding shoot in [city]" and "locations", because they are now the only pre-wedding page for that city.
- **Homepage H1** changes from "Pune's Premier Photography Studio" to "Wedding Photographers in Pune". This is visible hero text, so please check it on the page.
- First paragraphs: no change proposed except where the H1 changes on the packages page. There, the hero line under the H1 would say "Pre wedding shoot in Pune from Rs 14,999 ...". I'll show you before applying.

### Already done in Step 5 (no approval needed, body only)
- **Satara:** added a short FAQ block (price, distance from Pune, best time per spot) using the same `faq-item` block as the other location pages. Facts are taken from the page's own quick-facts bar and location text.
- **Maternity (Action 4):** `/maternity-photographer-pune/` still has Gold/Platinum/Diamond packages (Rs 6,000 / 9,000 / 18,000), a "Maternity Shoot Poses" section, and FAQs. `/maternity-photoshoot-locations-pune/` has 8 locations. The old WordPress pages are not in this project, so I cannot compare word by word. See manual checks.
  - **Found:** the maternity page says "cost ranges from Rs 10,000 - Rs 25,000" twice, but the packages are Rs 6,000 to 18,000. See D8.

---

## Step 6. Internal links (Section 10 step 4, Action 5)

| Item | Status |
|---|---|
| 6.1 "pre wedding shoot in Pune" link from homepage and Pune pages to the owner page | **Waits on D1.** Planned spots (existing text only): homepage hero sentence, where "pre-wedding photography" now links to the locations guide; the anchor in the under-10000 page ("Pre-wedding photoshoot in Pune" now goes to the guide); the locations guide intro; the blog links from Step 3.4 |
| 6.2 City hub to its locations guide with "pre wedding shoot locations in [city]" | **Done** for Mumbai, Lonavala and Mahabaleshwar (text of the existing "Related Pages" link changed; the link already pointed to the right page). Nashik, Chhatrapati Sambhajinagar and Ahilyanagar have no separate locations guide, only `/[city]/pre-wedding-shoot/`, so no change |
| 6.3 Money-keyword anchors pointing to the wrong page | Found 6, all tied to a decision: "Pre wedding shoot in Pune" (blog: pre-wedding-shoot-ideas) goes to the locations guide; "Pre-wedding photoshoot in Pune" (under-10000 page) goes to the locations guide; "Pre wedding shoot Pune" (2 blog posts) goes to old URLs; "The Best Pre-wedding Shoot In Mumbai" (/mumbai/) goes to the locations guide (D6); "wedding photographers in Pune" (blog) goes to the old `/wedding-photographer-pune/` (D2) |
| 6.4 Homepage/Pune pages link to Lonavala, Nashik, Sambhajinagar, Mahabaleshwar hubs | Already linked on every page, homepage included, from the header menu (Locations). No change |

Files changed: `city/mumbai.php`, `city/lonavala/index.php`, `city/mahabaleshwar/index.php` (link text only).

---

## Step 7. Homepage technical fixes (Section 11, Action 10)

| Item | Result |
|---|---|
| 7.1 Instagram "No feed with the ID 1" | **Nothing to fix.** There is no Instagram widget in the current code, and the error is not in the local or live HTML. It came from the old WordPress site. Google will drop it on its next crawl |
| 7.2 "1+" counters | **Nothing to fix.** The raw HTML already has the real numbers: "1,179+ Happy Couples", "10+ Years Experience", "1251+ Happy Client". There is no count-up script. Note: 1,179 and 1251 are two different "happy clients" numbers on the same page. Which is right? (D9) |
| 7.3 WhatsApp `{SITE}` text | **Nothing to fix.** The link is built in PHP (`layouts/main.php`) with the real site name, page name and URL. No placeholder text exists anywhere |
| 7.4 "Crafting Timeless Memorie" | **Fixed** to "Memories" (`pages/home.php`) |
| 7.4 Line repeated 3 times | On the current page, the only line repeated 3 times was the video label: "Wedding film" x3 and "Testimonial" x3 (alt text and aria-label on the video thumbnails). Removing videos would change the design, so each one got its real title from YouTube instead: "Samiksha and Prakash pre wedding teaser in Pune", "Samiksha and Prakash wedding film in Pune", "Vijay and Shradda helicopter pre wedding proposal shoot", "Client testimonial video 1/2/3" |

### 7.5 Homepage text block (APPLIED as D12, with "1,000+" instead of "1,179")
About 165 words. It would go as a short paragraph in the existing intro strip, or wherever you prefer.

> The Bridal Photography is a wedding photographer in Pune. Since 2014 we have covered weddings, pre wedding shoots, engagements, maternity and baby shoots for more than 1,179 happy couples and families, with a 4.9 star Google rating.
>
> Our work starts in Pune and goes across Maharashtra and beyond. We shoot in Mumbai, Goa, Lonavala, Mahabaleshwar, Satara, Nashik, Ahilyanagar and Chhatrapati Sambhajinagar. For a pre wedding shoot in Pune, we help you pick the right spot, from hill forts and lakes to film sets, and plan the best time of day for light.
>
> Our prices are simple. A pre wedding shoot starts from Rs 14,999. Wedding photography packages start from Rs 35,000 per day and include a videographer. Engagement and Roka shoots start from Rs 7,000. Maternity, baby shower and baby shoots start from Rs 6,000.
>
> You pay 20% to book your date, with a full refund if you cancel 8 or more days before. Call or WhatsApp us on +91 83903 67637 to check your date.

Planned links inside it: "pre wedding shoot in Pune" to the D1 owner page, city names to their hubs, and "Wedding photography packages" to `/wedding-photography-packages/`. "wedding photographer in Pune" gets no link, because it is the homepage.

---

## Step 8. Image SEO (Section 6, Action 9)

**8.1 Alt text.** I checked 719 images on the 59 live pages (maternity and engagement first).
- Missing alt: **0**. Empty alt: **0**.
- Generic or duplicate alt: **50 found, 40 fixed**.

| Page | Fix |
|---|---|
| `/maternity-photoshoot-locations-pune/` | 24 images all said "Maternity Photoshoot Pune". Each now names its location, for example "Maternity photoshoot at Osho Garden, Pune" or "Couple maternity photoshoot at University of Pune campus". I looked at the photos to check. Two Osho Garden files are reused under Empress Garden, so they got a neutral "in a Pune garden" alt |
| `/maternity-photographer-pune/` | 8 gallery images, for example "Picnic theme maternity photoshoot in Pune" or "Family maternity photoshoot in Pune" (based on the file names) |
| `/engagement-photography-packages/` | 4 file-name alts fixed ("wedding-engagement", "engagement-home-shoot", "prajwal-and-chanchal-for-wedding-story", "engagement shoot") |
| Shared pre-wedding gallery (`partials/gallery-prewedding.php`, shown on Lonavala, Mahabaleshwar, Nashik and Sambhajinagar pages) | 9 x "Pre-Wedding Photography" changed to descriptive alts |
| `/pre-wedding-shoot-mahabaleshwar/` | "blog image-2mahabaleshwar", "wedding shoot" x3 fixed |

**Still generic (10), not changed because I have not checked the photos:** homepage `home-about-1/2/3`, `home-whychoose-1/2`, `home-offer-wedding` ("Wedding shoot/photoshoot"); `/services/` `svc-gallery-3`; `/wedding-photography-packages/` `wedding-shoot.webp`; hero on `/nashik/pre-wedding-shoot/` and `/chhatrapati-sambhajinagar/pre-wedding-shoot/` ("Pre-Wedding Photography", and the file is `mumbai-prewedding-01.webp`).

**Badly named image files (not renamed, for you to plan):** numbered files with no subject or place in the name. By family:
`ahily-pw-1..19`, `ahily-wed-1..14`, `roka-1..14`, `mumbai-wp-1..13`, `svc-gallery-1..12`, `pw-gal-1..12`, `matloc-uni-1..10`, `bshower-gal-1..10`, `mum-engage-1..9`, `lavasa-couple-1..8`, `ahily-mat-1..7`, `ahily-baby-1..7`, `pw-collage-1..6`, `osho-1..6`, `engage-gallery-1..6`, `ahily-eng-1..6`, `ahily-corp-1..5`, `matloc-empress-1..4`, `home-about-1..3`, `home-whychoose-1..2`, `engage-time`, `mahab-weather`, `about-gallery-1`.
**Wrong photo for the place:** `/pre-wedding-shoot-lonavala/` hero uses `prewedding-satara.webp` (alt says Bhushi Dam). The Nashik, Sambhajinagar and Lonavala hubs preload `mumbai-prewedding-01.webp`.

**8.2 Old WordPress URLs.** `/wp-content/uploads/...`, `/tag/...`, `/category/...`, `/author/...`, `/feed/`, `/wp-admin/` and `.../attachment/...` all return **404** (local and live). None are in the sitemap. None are linked from views or blog posts; only old backup files like `google-reviews.php14-5-26` mention wp-content. `/?attachment_id=123` shows the homepage with canonical `/`, which is harmless. No redirects added.

**8.3 Image sitemap.** The sitemap was a static file, so I did not build a system. `tools/build_sitemap.php` (a small script you run on localhost) rewrites the same static `sitemap.xml` with `<image:image>` entries: **515 image entries**, max 20 per page, on location and service pages. All 360 unique image URLs return 200.

---

## Step 9. Sitemap and robots (Actions 11 and 14)

**9.1 New `sitemap.xml`.** Built by `tools/build_sitemap.php` (run: `D:\xampp\php\php.exe tools/build_sitemap.php`).
- 59 URLs. Each one was fetched and checked: 200 status, https, trailing slash, and the canonical equals the URL itself.
- **Removed:** `/blog/when-should-i-take-my-pre-wedding-shoot/`, `/lonavala/pre-wedding-shoot/`, `/mahabaleshwar/pre-wedding-shoot/` (all now 301).
- **Added:** `/housewarming-photography-pune/` (live page that was missing).
- **Left out on purpose:** `/blog/odio-non-quo-rerum-a/` (lorem ipsum test post, D7).
- **lastmod** = date the page's view file last changed. For blog posts it is `updated_at` from the database. Before, every URL had the same 2026-06-29. Note: all 6 blog posts have `updated_at` = 29 Sept 2026 in the local database, so they show today's date.
- Removed the xml-sitemaps.com stylesheet line. It pointed to a third-party site.
- The old file is kept only in my scratch folder. The backups zip also has it.
- **Run the script again after Step 5 is applied**, so lastmod picks up the changed views.

**9.2 robots.txt.** OK as it is: `User-agent: *`, `Disallow: /demo/`, `Sitemap: https://thebridal.photography/sitemap.xml`. No change.

**9.3 Where location guides live (for your one-rule decision, Action 11):**

| In the root | In /blog/ | In a city folder |
|---|---|---|
| `/pre-wedding-shoot-locations-in-pune/` | `/blog/pre-wedding-shoot-in-pba-film-city-pune/` | `/ahilyanagar/pre-wedding-shoot/` |
| `/pre-wedding-shoot-locations-mumbai/` | `/blog/prewedding-shoot-at-snap-city-pune/` | `/nashik/pre-wedding-shoot/` |
| `/pre-wedding-shoot-locations-in-goa/` | `/blog/the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography/` (wedding backdrops) | `/chhatrapati-sambhajinagar/pre-wedding-shoot/` |
| `/pre-wedding-shoot-satara/` | | |
| `/pre-wedding-shoot-mahabaleshwar/` | | |
| `/pre-wedding-shoot-lonavala/` | | |
| `/pre-wedding-shoot-mulshi/` | | |
| `/pre-wedding-shoot-lavasa/` | | |
| `/pre-wedding-shoot-lakshadweep/` | | |
| `/maternity-photoshoot-locations-pune/` | | |
| `/best-destination-wedding-venues-pune/` | | |

Most guides are in the root. Only 2 Pune film-set guides (Snap City, PBA) are in /blog/, and those are the two that lost the most (Snap City -88%). The doc says not to move pages again, so nothing was moved.

---

## DECISIONS (answered 29 Sept 2026)

| # | Decision | Status |
|---|---|---|
| D1 | `/pre-wedding-photography-packages/` owns "pre wedding shoot in pune" | **Done.** `/pre-wedding-shoot/` 301s there. Step 6 links and blog links point there |
| D2 | `/wedding-photographer-pune/` 301s to the homepage | **Done.** The blog link to it now goes straight to `/` |
| D3 | `/packages/` stays on `/wedding-photography-packages/` | No change |
| D4 | `/goa/engagement-photographers-in-goa/` 301s to `/pre-wedding-shoot-locations-in-goa/` | **Done** |
| D5 | `/wedding-photography-mahabaleshwar/` 301s to `/mahabaleshwar/wedding-photographers/` | **Done** |
| D6 | `/mumbai/pre-wedding-shoot/` stays a redirect | No change |
| D7 | Lorem ipsum post set to draft | **Done** (local DB + SQL file) |
| D8 | Maternity price range text | **Open.** You will confirm. See manual checks |
| D9 | "1,179+" vs "1251+" happy clients | **Open.** You will confirm. The new homepage text uses "1,000+" until then |
| D10 | `/event-decorators-in-pune/` and `/political-events-photoshoot/` 301 to `/services/`. `/bridal-photography-pune/` stays on `/` | **Done** |
| D11 | Step 5 table applied to all 21 pages | **Done** (21/21 checked against the table on the rendered pages) |
| D12 | Homepage text block in the intro strip, with "1,000+" | **Done** |
| D13 | Location guides live in the root. Snap City and PBA stay in /blog/ | Rule noted. Nothing moved |

---

## Round 2: changes made after the decisions

### Redirects (`app/Config/Routes.php`)
| Old URL | Before | Now |
|---|---|---|
| `/pre-wedding-shoot/` | `/pre-wedding-shoot-locations-in-pune/` | **`/pre-wedding-photography-packages/`** (D1) |
| `/wedding-photographer-pune/` | `/wedding-photography-packages/` | **`/`** (D2) |
| `/goa/engagement-photographers-in-goa/` | `/engagement-photography-packages/` | **`/pre-wedding-shoot-locations-in-goa/`** (D4) |
| `/wedding-photography-mahabaleshwar/` | `/mahabaleshwar/` | **`/mahabaleshwar/wedding-photographers/`** (D5) |
| `/event-decorators-in-pune/` | `/` | **`/services/`** (D10) |
| `/political-events-photoshoot/` | `/` | **`/services/`** (D10) |

### Titles, descriptions, H1s (D11)
- **Controllers:** `Home.php`, `Pages.php`, `CityHub.php`. 21 titles and 21 descriptions from the Step 5 table. `/pre-wedding-photography-packages/` got a meta description for the first time.
- **Views (H1 only):** 17 H1s changed. The 4 marked "(keep)" were left alone: maternity photographer, Goa, Lonavala, Nashik pre-wedding. Each new H1 keeps the page's existing `line<br><em>accent</em>` style, so the look is the same.
- **Not changed:** the first paragraph of the packages page. I had said I would show it before applying, and it was not part of the approved table. Suggested wording if you want it: *"Pre wedding shoot in Pune from Rs 14,999. Pick from Silver, Gold and Diamond packages with 50 to 300 edited photos at the best Pune locations."*

**Homepage hero H1 diff (`app/Views/pages/home.php`)**
```diff
       <h1>
-        Pune's Premier<br>
-        <em>Photography Studio</em>
+        Wedding Photographers<br>
+        <em>in Pune</em>
       </h1>
```

### Internal links (Step 6.1, D1, D2)
| Page | Change |
|---|---|
| Homepage | New intro text (D12) links "pre wedding shoot in Pune" to `/pre-wedding-photography-packages/` |
| `/pre-wedding-shoot-locations-in-pune/` | Existing closing phrase "pre wedding photoshoot in pune" is now a link to the owner page |
| `/pre-wedding-shoot-pune-under-10000/` | Existing anchor "Pre-wedding photoshoot in Pune" now points to the owner page (was the locations guide) |
| `/when-to-take-pre-wedding-shoot/`, `/pre-wedding-shoot-mulshi/`, `/pre-wedding-shoot-lavasa/` | Existing Related Pages link to the packages page: text changed from "Packages" / "Pre-Wedding Packages" to "Pre wedding shoot in Pune" (same href) |
| Blog: PBA Film City, Snap City, Mahabaleshwar charm | 3 old Pune links now go to `/pre-wedding-photography-packages/` |
| Blog: pre-wedding-shoot-ideas | Anchor "Pre wedding shoot in Pune" now goes to the owner page (was the locations guide) |
| Blog: Mahabaleshwar charm | "wedding photographers in Pune" now goes to `/` (was the old URL) |

### Homepage text block (D12)
Added inside the existing intro strip, in the same column and with the same text style as the paragraph above it. No new section and no layout change. It uses "1,000+" and links to the city hubs, the pre-wedding owner page and the wedding packages page.

### Alt text: the last 10 (I viewed every photo first)
| Image | Page | New alt |
|---|---|---|
| `home-about-1.webp` | / | Couple in a silver gown and black tuxedo at a wedding reception |
| `home-about-2.webp` | / | Bride and groom entry with cold fireworks at a wedding reception |
| `home-about-3.webp` | / | Couple portrait under hanging lanterns at a wedding reception |
| `home-whychoose-1.webp` | / | Bride in red lehenga and groom in pink pheta at a wedding ceremony |
| `home-whychoose-2.webp` | / | Couple dancing under flower petals at a haldi ceremony |
| `home-offer-wedding.webp` | / | Maharashtrian bride in pink Paithani saree and groom in pheta, wedding photography in Pune |
| `svc-gallery-3.webp` | /services/ | Maharashtrian bride in pink Paithani saree and groom in pheta |
| `wedding-shoot.webp` | /wedding-photography-packages/ | Bride and groom close together during wedding rituals in Pune |
| `mumbai-prewedding-01.webp` | /nashik/pre-wedding-shoot/, /chhatrapati-sambhajinagar/pre-wedding-shoot/ | Couple pre wedding shoot in a library setting (the photo does not show which city, so no city is named) |

For the homepage "What we offer" cards, the loop now takes an optional 4th value for the alt. Only the Wedding card uses it. The other 11 cards keep their title as the alt, as before.

**Please check:** `home-about-1.webp` and `home-about-3.webp` have a **"Khushi Film Art"** watermark on the photo. That looks like another studio's work on your homepage. Please confirm you have the rights, or swap these images.

### Lonavala hero image
There is **no Lonavala photo** in `assets/images`: no file name mentions Lonavala, Bhushi, Tiger Point, Rajmachi, Karla or Pawna, and the Lonavala pages only use Mumbai/generic images. Left as it is. The hero on `/pre-wedding-shoot-lonavala/` still uses `prewedding-satara.webp`, and its alt text says "Bhushi Dam", which does not match the photo. Once you have a real Lonavala photo, swap the file and the alt together.

### Database (local, and added to `tools/seo_fix_db_updates.sql` for live)
- D7: `odio-non-quo-rerum-a` set to draft.
- D1: 3 old Pune links in blog posts go to `/pre-wedding-photography-packages/`. The "Pre wedding shoot in Pune" anchor in pre-wedding-shoot-ideas also goes there.
- D2: blog link to `/wedding-photographer-pune/` goes to `/`.

### Sitemap
Rebuilt with `tools/build_sitemap.php`: **59 URLs, 515 image entries**, and lastmod is fresh for every changed view. Valid XML. Every URL returns 200 with a self canonical.

### Check script
`tools/check_redirects.sh` now has an `ALLOW_HOME` list for the 2 approved homepage redirects (`/wedding-photographer-pune/`, `/bridal-photography-pune/`). Any other redirect that ends on `/` is still flagged. 5 more URLs were added to `tools/check_redirects_extra.txt`.

---

## Step 10. Final check (re-run after the decisions)

### 10.1 Redirect check
`bash tools/check_redirects.sh`: **51 URLs, 0 problems.** Every one is a single 301 to a 200 page:
```
OLD URL                                                                        FIRST HOPS FINAL FINAL URL
/blog/pre-wedding-shoot-locations-in-mumbai/                                   301   1    200   /pre-wedding-shoot-locations-mumbai/ 
/blog/top-7-pre-wedding-shoot-location-in-satara/                              301   1    200   /pre-wedding-shoot-satara/ 
/pre-wedding-shoot-location-satara/                                            301   1    200   /pre-wedding-shoot-satara/ 
/blog/5-destinations-for-a-pre-wedding-shoot-in-goa/                           301   1    200   /pre-wedding-shoot-locations-in-goa/ 
/5-destination-for-a-pre-wedding-shoot-in-goa/                                 301   1    200   /pre-wedding-shoot-locations-in-goa/ 
/goa/pre-wedding-shoot-in-goa/                                                 301   1    200   /pre-wedding-shoot-locations-in-goa/ 
/pre-wedding-shoot/                                                            301   1    200   /pre-wedding-photography-packages/ 
/wedding-photographer-pune/                                                    301   1    200   / 
/packages/                                                                     301   1    200   /wedding-photography-packages/ 
/mumbai/wedding-photographers/                                                 301   1    200   /mumbai/ 
/maternity-photography-packages/                                               301   1    200   /maternity-photographer-pune/ 
/goa/engagement-photographers-in-goa/                                          301   1    200   /pre-wedding-shoot-locations-in-goa/ 
/private-jet-shoot/                                                            301   1    200   /services/ 
/wedding-photography-mahabaleshwar/                                            301   1    200   /mahabaleshwar/wedding-photographers/ 
/goa/wedding-photoraphers-in-goa/                                              301   1    200   /pre-wedding-shoot-locations-in-goa/ 
/ahilyanagar/wedding-photoraphers-in-ahilyanagar-thebridal-photoraphy/         301   1    200   /ahilyanagar/wedding-photographers/ 
/best-locations-for-a-maternity-photoshoot-in-pune/                            301   1    200   /maternity-photoshoot-locations-pune/ 
/pre-wedding-photoshoots-in-lakshadweep-island-india/                          301   1    200   /pre-wedding-shoot-lakshadweep/ 
/mumbai/engagement-photo-shoot/                                                301   1    200   /mumbai/engagement-photography-packages/ 
/lavasa-city-a-prewedding-paradise-for-couples/                                301   1    200   /pre-wedding-shoot-lavasa/ 
/pre-wedding-shoot-at-snap-city-pune/                                          301   1    200   /blog/prewedding-shoot-at-snap-city-pune/ 
/pre-wedding-destinations-in-mahabaleshwar/                                    301   1    200   /pre-wedding-shoot-mahabaleshwar/ 
/housewarming-ceremony-photography-services/                                   301   1    200   /housewarming-photography-pune/ 
/baby-shower-shoot/                                                            301   1    200   /baby-shower-photography-packages/ 
/engagement-photo-shoot/                                                       301   1    200   /engagement-photography-packages/ 
/pre-wedding-shoot-pba-film-city/                                              301   1    200   /blog/pre-wedding-shoot-in-pba-film-city-pune/ 
/roka-ceremony-shoot-ring-ceremony-shoot-in-pune/                              301   1    200   /roka-ring-ceremony-photography-pune/ 
/when-should-i-take-my-pre-wedding-shoot-2024/                                 301   1    200   /when-to-take-pre-wedding-shoot/ 
/birthday-photography-services/                                                301   1    200   /birthday-photography-pune/ 
/capturing-love-in-the-serenity-of-mulshi/                                     301   1    200   /pre-wedding-shoot-mulshi/ 
/capturing-love-in-the-lap-of-luxury-in-lonavala/                              301   1    200   /pre-wedding-shoot-lonavala/ 
/capturing-love-in-the-lap-of-luxury-trending-pre-wedding-destinations-in-lonavala/ 301   1    200   /pre-wedding-shoot-lonavala/ 
/newborn-photography-services/                                                 301   1    200   /newborn-photography-pune/ 
/blog/when-should-i-take-my-pre-wedding-shoot/                                 301   1    200   /when-to-take-pre-wedding-shoot/ 
/candid-birthday-photography-tips/                                             301   1    200   /blog/candid-birthday-photography-tips/ 
/pre-wedding-shoot-locations-in-pune                                           301   1    200   /pre-wedding-shoot-locations-in-pune/ 
/maternity-photographer-pune                                                   301   1    200   /maternity-photographer-pune/ 
/pre-wedding-shoot-locations-mumbai                                            301   1    200   /pre-wedding-shoot-locations-mumbai/ 
/pre-wedding-shoot-locations-in-mumbai                                         301   1    200   /pre-wedding-shoot-locations-mumbai/ 
/when-to-take-pre-wedding-shoot                                                301   1    200   /when-to-take-pre-wedding-shoot/ 
/pre-wedding-shoot-mumbai-locations/                                           301   1    200   /pre-wedding-shoot-locations-mumbai/ 
/pre-wedding-shoot-locations-in-mumbai/                                        301   1    200   /pre-wedding-shoot-locations-mumbai/ 
/lonavala/pre-wedding-shoot/                                                   301   1    200   /pre-wedding-shoot-lonavala/ 
/mahabaleshwar/pre-wedding-shoot/                                              301   1    200   /pre-wedding-shoot-mahabaleshwar/ 
/pre-wedding-destination-mahabaleshwar/                                        301   1    200   /pre-wedding-shoot-mahabaleshwar/ 
/the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography/           301   1    200   /pre-wedding-shoot-mahabaleshwar/ 
/event-decorators-in-pune/                                                     301   1    200   /services/ 
/political-events-photoshoot/                                                  301   1    200   /services/ 
/bridal-photography-pune/                                                      301   1    200   / 
/pre-wedding-shoot-locations-pune/                                             301   1    200   /pre-wedding-shoot-locations-in-pune/ 
/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/                   301   1    200   /pre-wedding-shoot-locations-in-pune/ 

URLs checked: 51   Problems: 0
```

**Routes.php sweep:** all **73** redirect routes: **0 problems.** Each is one hop to a 200 page, with no chains and no loops. Only the 2 approved routes end on the homepage.
*(Correction: my first report said 72. The sweep list had no trailing newline, so the last route, `/bridal-photography-pune/`, was silently skipped. That is fixed, and all 73 are checked now.)*

### 10.2 Pages
- All 59 sitemap pages return 200. Each has exactly one H1, a title, a meta description and a self canonical (https, trailing slash).
- The 21 Step 5 pages were checked on the rendered HTML: **21/21 match the approved titles and descriptions.** Every title is at most 60 characters and every description at most 155.
- HEAD `/` returns 200.

### 10.3 Internal links
All 59 pages crawled. 60 unique internal link targets. **0 go through a redirect, 0 are non-200.** The contact form POST is excluded.

---

## .htaccess: live vs `htaccess-server`

> **UPDATE (29 Sept 2026, later): this section is replaced by the one below.** You put the real live `.htaccess` into `htaccess-server` (7,186 bytes, CRLF line endings). It matches the zip copy except for one line: the slash rule already used `RewriteRule ^ %{REQUEST_URI}/`. I rebuilt `htaccess-server` from that real file. All existing rules are kept, and everything after the rewrite block is byte-identical. Only 4 changes:
>
> | # | Change | Why |
> |---|---|---|
> | 1 | **Added** the one-hop canonical host block (http or www to `https://thebridal.photography`, adding the slash in the same hop) | Live today does not force https, and www + no slash takes 2 hops |
> | 2 | **Commented out** the old www to non-www rule (kept in the file, with a note) | The new block does the same job in one hop. Left active, it could never fire anyway |
> | 3 | **Kept all 7 `Redirect 301` lines. Fixed the target of 2:** `-2024` "when" URL now goes to `/when-to-take-pre-wedding-shoot/` (was the /blog/ post, which now 301s itself, so that would be a chain). `/wedding-photography-mahabaleshwar/` now goes to `/mahabaleshwar/wedding-photographers/` (D5; was a blog post) | These run before Routes.php, so they must agree with it. The other 3 already match Routes.php |
> | 4 | **Added** the one-hop rule for `/pre-wedding-shoot-locations-in-mumbai`. **Changed** the slash rule to skip any file extension and `/admin` (the old list missed `.xml`, `.txt`, `.php`, `.json`; the old line is kept as a comment) | Section 8.6 |
>
> Tested on localhost (swapped in, then restored): 51/51 redirect checks OK; `/`, files, sitemap, robots and admin all 200; http and www each one hop to https + non-www + slash.
> Earlier text below said the `Redirect 301` lines were removed. That is no longer true: they are kept, with 2 targets corrected.

**Which file is "live":** I cannot read the live server's `.htaccess` (HTTP gives 403, which is correct). I compared against the `.htaccess` inside **`thebridal290926.zip`** (7,081 bytes, dated 15 May 2026). It sits next to dated server backups (`.htaccess13-5-26`, `.htaccess14-5-26`...), so it looks like a copy of the live file.
**One doubt:** that file has `Redirect 301` lines (for example `/candid-birthday-photography-tips/` to the blog), but live returns 404 for those URLs. So either LiteSpeed ignores those lines, or the real live file is different. **Please download the live `.htaccess` from the host and compare it before replacing it.**

Everything outside the rewrite block (security headers, file blocking, compression, caching) is **identical** in both files. Only these lines differ:

| # | Line in live file (removed) | Line in `htaccess-server` (added) | What it does |
|---|---|---|---|
| 1 | `# Redirect www to non-www (301 permanent)` | | Comment for the old www rule |
| 2 | `RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]` | | Old: matched any www host |
| 3 | `RewriteRule ^ https://%1%{REQUEST_URI} [R=301,L]` | | Old: www to non-www, but without adding the slash (so a second hop followed) |
| 4 | `# Force HTTPS (uncomment on live server only)` + 2 commented rules | | Old HTTPS rule that was never switched on, so http:// was not redirected |
| 5 | `# Redirect old blog URLs...` + 7 `Redirect 301` lines (2 commented) | | Old-URL redirects. Moved to Routes.php; 2 pointed to the wrong page |
| 6 | | `RewriteCond %{HTTP_HOST} ^(www\.)?thebridal\.photography$ [NC]` | Only acts on your domain (localhost and other hosts are not touched) |
| 7 | | `RewriteCond %{HTTPS} !=on` | ...and the request is not https |
| 8 | | `RewriteCond %{HTTP:X-Forwarded-Proto} !=https` | ...and no proxy says it is already https (prevents a loop behind a proxy/CDN) |
| 9 | | `RewriteRule ^ - [E=TB_CANON:1]` | Marks the request as "needs the canonical host" (no redirect yet) |
| 10 | | `RewriteCond %{HTTP_HOST} ^www\.thebridal\.photography$ [NC]` | A www request... |
| 11 | | `RewriteRule ^ - [E=TB_CANON:1]` | ...is also marked, even on https |
| 12 | | `RewriteCond %{ENV:TB_CANON} =1` | Marked requests only |
| 13 | (same line kept) | `RewriteCond %{REQUEST_FILENAME} !-f` / `!-d` | ...that are not a real file or folder |
| 14 | (same line kept) | `RewriteCond %{REQUEST_URI} !/$` | ...and have no trailing slash |
| 15 | `RewriteCond %{REQUEST_URI} !\.(css\|js\|png\|...\|pdf)$` | `RewriteCond %{REQUEST_URI} !\.[A-Za-z0-9]{2,5}$` | Skip anything with a file extension. The old list missed `.xml`, `.txt`, `.php`, `.json` |
| 16 | | `RewriteCond %{REQUEST_URI} !/admin(/\|$) [NC]` | Never touch the admin area |
| 17 | | `RewriteRule ^ https://thebridal.photography%{REQUEST_URI}/ [R=301,L]` | One hop: https + non-www + trailing slash together |
| 18 | | `RewriteCond %{ENV:TB_CANON} =1` + `RewriteRule ^ https://thebridal.photography%{REQUEST_URI} [R=301,L]` | Marked requests that already have a slash (or are files): one hop to https + non-www |
| 19 | | 4 comment lines | Says old-URL redirects now live only in Routes.php |
| 20 | | `RewriteCond %{REQUEST_URI} ^(.*)/pre-wedding-shoot-locations-in-mumbai$ [NC]` + `RewriteRule ^ %1/pre-wedding-shoot-locations-mumbai/ [R=301,L]` | The one old no-slash URL seen in GSC goes to its final page in one hop |
| 21 | `# ADD trailing slash...` (comment) | 3 new comment lines | Comments only |
| 22 | (kept, see 13–14) | `RewriteCond %{REQUEST_FILENAME} !-f` / `!-d` / `!/$` | Same as before: real files, folders and slash URLs are left alone |
| 23 | `RewriteCond ... !\.(css\|js\|...)$` | `RewriteCond %{REQUEST_URI} !\.[A-Za-z0-9]{2,5}$` | Same as 15, for the normal slash rule |
| 24 | | `RewriteCond %{REQUEST_URI} !/admin(/\|$) [NC]` | Same as 16, for the normal slash rule |
| 25 | `RewriteRule ^(.*)$ /$1/ [R=301,L]` | `RewriteRule ^ %{REQUEST_URI}/ [R=301,L]` | Adds the trailing slash. Same result on live. The new form also works in a subfolder (localhost) |

**Raw unified diff:**
```diff
--- live .htaccess (copy in thebridal290926.zip)
+++ htaccess-server (new)
@@ -11,29 +11,49 @@
 
     # RewriteBase /
 
-    # Redirect www to non-www (301 permanent)
-    RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
-    RewriteRule ^ https://%1%{REQUEST_URI} [R=301,L]
-
-    # Force HTTPS (uncomment on live server only)
-    # RewriteCond %{HTTPS} off
-    # RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
-
-    # Redirect old blog URLs to new ones (301 permanent)
-    Redirect 301 /candid-birthday-photography-tips/ https://thebridal.photography/blog/candid-birthday-photography-tips/
-    Redirect 301 /when-should-i-take-my-pre-wedding-shoot-2024/ https://thebridal.photography/blog/when-should-i-take-my-pre-wedding-shoot/
-    Redirect 301 /wedding-photography-mahabaleshwar/ https://thebridal.photography/blog/the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography/
-    # Redirect 301 /pre-wedding-shoot-location-satara/ https://thebridal.photography/blog/top-7-pre-wedding-shoot-location-in-satara/
-    Redirect 301 /pre-wedding-shoot-pba-film-city/ https://thebridal.photography/blog/pre-wedding-shoot-in-pba-film-city-pune/
-    Redirect 301 /pre-wedding-shoot-at-snap-city-pune/ https://thebridal.photography/blog/prewedding-shoot-at-snap-city-pune/
-    # Redirect 301 /5-destination-for-a-pre-wedding-shoot-in-goa/ https://thebridal.photography/blog/5-destinations-for-a-pre-wedding-shoot-in-goa/
+    # ── Canonical host: https://thebridal.photography (no www) ──────────
+    # http:// or www. -> https://thebridal.photography in ONE hop, adding the
+    # trailing slash in the same hop when the URL needs it.
+    # (Replaces the old separate www and HTTPS rules, which took 2 hops.)
+    RewriteCond %{HTTP_HOST} ^(www\.)?thebridal\.photography$ [NC]
+    RewriteCond %{HTTPS} !=on
+    RewriteCond %{HTTP:X-Forwarded-Proto} !=https
+    RewriteRule ^ - [E=TB_CANON:1]
+    RewriteCond %{HTTP_HOST} ^www\.thebridal\.photography$ [NC]
+    RewriteRule ^ - [E=TB_CANON:1]
 
-    # ADD trailing slash to non-file, non-directory paths (SEO requirement)
+    RewriteCond %{ENV:TB_CANON} =1
     RewriteCond %{REQUEST_FILENAME} !-f
     RewriteCond %{REQUEST_FILENAME} !-d
     RewriteCond %{REQUEST_URI} !/$
-    RewriteCond %{REQUEST_URI} !\.(css|js|png|jpg|jpeg|gif|webp|svg|ico|woff|woff2|ttf|eot|map|pdf)$
-    RewriteRule ^(.*)$ /$1/ [R=301,L]
+    RewriteCond %{REQUEST_URI} !\.[A-Za-z0-9]{2,5}$
+    RewriteCond %{REQUEST_URI} !/admin(/|$) [NC]
+    RewriteRule ^ https://thebridal.photography%{REQUEST_URI}/ [R=301,L]
+
+    RewriteCond %{ENV:TB_CANON} =1
+    RewriteRule ^ https://thebridal.photography%{REQUEST_URI} [R=301,L]
+
+    # Old-URL 301 redirects live in app/Config/Routes.php (one place only).
+    # The "Redirect 301" lines that were here moved there in Sept 2026. Two of
+    # them pointed to the wrong page (the -2024 "when" URL and the Mahabaleshwar
+    # wedding URL), and "Redirect" runs before the router, so it overrode Routes.php.
+
+    # ── Old no-slash URL seen in GSC (Section 8.6): send straight to the
+    # final page in one hop, before the slash rule below adds a second hop.
+    # (All other old-URL redirects are in app/Config/Routes.php.)
+    RewriteCond %{REQUEST_URI} ^(.*)/pre-wedding-shoot-locations-in-mumbai$ [NC]
+    RewriteRule ^ %1/pre-wedding-shoot-locations-mumbai/ [R=301,L]
+
+    # ── ADD trailing slash to non-file, non-directory paths (SEO requirement)
+    # Skips real files, anything with a file extension (.css .js .xml .txt .php
+    # images, fonts…) and the admin area.
+    RewriteCond %{REQUEST_FILENAME} !-f
+    RewriteCond %{REQUEST_FILENAME} !-d
+    RewriteCond %{REQUEST_URI} !/$
+    RewriteCond %{REQUEST_URI} !\.[A-Za-z0-9]{2,5}$
+    RewriteCond %{REQUEST_URI} !/admin(/|$) [NC]
+    # %{REQUEST_URI} keeps any subfolder (e.g. /thebridal/ on XAMPP) — same result on live root
+    RewriteRule ^ %{REQUEST_URI}/ [R=301,L]
 
     # Route all requests through CI4 front controller (index.php)
     RewriteCond %{REQUEST_FILENAME} !-f
```

**Tested on localhost** (htaccess-server swapped in, then the local file restored): `/` 200, `/maternity-photographer-pune` 301 to slash, `/pre-wedding-shoot-locations-in-mumbai` one 301 to the final page, `/sitemap.xml` and `.css` 200 with no slash added, Host `www.thebridal.photography` gives one 301 to `https://thebridal.photography/.../`, and Host `thebridal.photography` over http gives one 301 to https.

---

## FINAL REPORT

### Changed files (both rounds)
| File | What changed |
|---|---|
| `index.php` | HEAD requests answered like GET |
| `.htaccess` (local only, do not upload) | One-hop https/non-www rule (live domain only), better slash rule, Mumbai no-slash rule |
| `htaccess-server` (upload as `.htaccess`) | See the table above |
| `app/Config/Routes.php` | 15 redirect routes added or changed over both rounds (including the 2 merged duplicate pages) |
| `app/Controllers/Home.php`, `Pages.php`, `CityHub.php` | 21 titles and 21 meta descriptions (D11) |
| `app/Views/layouts/main.php` | Canonical fallback to the page's own URL |
| `app/Views/pages/home.php` | H1, intro text block (D12), "Memories", 6 video labels, 6 alt texts, alt override for the offer card |
| `app/Views/pages/pre-wedding-packages.php`, `pre-wedding-locations-pune.php`, `pre-wedding-budget.php`, `wedding-packages.php`, `maternity-locations.php`, `pre-wedding-satara.php`, `pre-wedding-mumbai.php`, `pre-wedding-mahabaleshwar.php` | H1s. Plus: Satara FAQ; Mahabaleshwar merge (locations, FAQ, gallery, alts); locations guide link; budget link; wedding-packages alt; 24 maternity-locations alts |
| `app/Views/pages/pre-wedding-lonavala.php` | Lonavala merge (FAQ, gallery) |
| `app/Views/pages/maternity-photographer.php`, `engagement-packages.php`, `services.php` | Alt texts |
| `app/Views/pages/when-pre-wedding.php`, `pre-wedding-mulshi.php`, `pre-wedding-lavasa.php` | Related Pages link text to "Pre wedding shoot in Pune" |
| `app/Views/pages/city/mumbai.php`, `city/lonavala/index.php`, `city/mahabaleshwar/index.php`, `city/nashik/index.php`, `city/sambhajinagar/index.php`, `city/ahilyanagar.php` | Hub H1s, and "locations" link text (Mumbai, Lonavala, Mahabaleshwar) |
| `app/Views/pages/city/lonavala/{wedding,engagement}.php`, `city/mahabaleshwar/{wedding,engagement}.php` | hrefs to the kept pages |
| `app/Views/pages/city/nashik/prewedding.php`, `city/sambhajinagar/prewedding.php`, `city/ahilyanagar-prewedding.php` | H1s (Sambhajinagar, Ahilyanagar), hero alt (Nashik, Sambhajinagar) |
| `app/Views/partials/gallery-prewedding.php` | 9 alt texts |
| `sitemap.xml` | Rebuilt: 59 URLs, 515 images |
| New: `SEO_FIX_NOTES.md`, `tools/check_redirects.sh`, `tools/check_redirects_extra.txt`, `tools/build_sitemap.php`, `tools/seo_fix_db_updates.sql` | Notes and tools. **Do not upload** `tools/` or `SEO_FIX_NOTES.md`: the project root is the web root, so they would be publicly downloadable (the .htaccess only blocks .env, composer files, spark and .git). Run the SQL through phpMyAdmin instead |

Not touched: `.env`, composer files, `vendor/`, `writable/`, database structure, CSS, JS, image files, the backup zips.

### Redirects added or fixed (both rounds)
| Old URL | Final target |
|---|---|
| `/pre-wedding-shoot/` | `/pre-wedding-photography-packages/` |
| `/wedding-photographer-pune/` | `/` |
| `/goa/engagement-photographers-in-goa/` | `/pre-wedding-shoot-locations-in-goa/` |
| `/wedding-photography-mahabaleshwar/` | `/mahabaleshwar/wedding-photographers/` |
| `/event-decorators-in-pune/`, `/political-events-photoshoot/` | `/services/` |
| `/private-jet-shoot/` | `/services/` |
| `/pre-wedding-shoot-at-snap-city-pune/` | `/blog/prewedding-shoot-at-snap-city-pune/` |
| `/pre-wedding-shoot-pba-film-city/` | `/blog/pre-wedding-shoot-in-pba-film-city-pune/` |
| `/candid-birthday-photography-tips/` | `/blog/candid-birthday-photography-tips/` |
| `/pre-wedding-shoot-locations-in-mumbai/` (+ no-slash), `/pre-wedding-shoot-mumbai-locations/` | `/pre-wedding-shoot-locations-mumbai/` |
| `/blog/when-should-i-take-my-pre-wedding-shoot/` | `/when-to-take-pre-wedding-shoot/` |
| `/lonavala/pre-wedding-shoot/` | `/pre-wedding-shoot-lonavala/` |
| `/mahabaleshwar/pre-wedding-shoot/` | `/pre-wedding-shoot-mahabaleshwar/` |
| `http://` and `www.` (any page) | one hop to `https://thebridal.photography/.../` (after `htaccess-server` is deployed) |
| HEAD requests | real status instead of 404 |

### Titles and metas changed
All 21 pages in the Step 5 table (applied, 21/21 verified).

### Content merged
Lonavala folder page into `/pre-wedding-shoot-lonavala/`. Mahabaleshwar folder page into `/pre-wedding-shoot-mahabaleshwar/`. The blog duplicate "when" article was archived (nothing to merge). Satara FAQ added. Homepage services/cities/prices text added (D12).

### Items still open
- **D8** maternity price range. **D9** happy-clients number (then change "1,000+" in `home.php` to the real number).
- **Khushi Film Art watermark** on 2 homepage images.
- **Lonavala hero photo** (needs a real Lonavala photo).
- **Packages page first paragraph** (optional wording above).

### Deploy checklist (not done by me)
1. **Back up the live site and database first** (files + `tb_blogs` export).
2. **Download the live `.htaccess`** and compare it with `htaccess-server`. Expect only the rewrite-block differences in the table above. If anything else differs, stop and check.
3. Upload the changed files listed above. Do **not** upload the local `.htaccess`, `.env` or `writable/`.
4. Upload `htaccess-server` to the live root **as `.htaccess`**.
5. Run `tools/seo_fix_db_updates.sql` on the live database (phpMyAdmin > SQL). Every statement is safe to run twice.
6. Upload the new `sitemap.xml`.
7. Test the host rules: `curl -I http://thebridal.photography/`, `curl -I http://www.thebridal.photography/maternity-photographer-pune`, `curl -I https://www.thebridal.photography/`. Each must be **one** 301 to `https://thebridal.photography/.../`, with no loop. If you see a loop, restore the old `.htaccess` right away and tell me (the host may use a proxy for HTTPS).
8. Run `bash tools/check_redirects.sh https://thebridal.photography`. Expect **51 URLs, 0 problems**.
9. Spot-check in a browser: the homepage (new H1 and intro text), `/pre-wedding-photography-packages/`, `/pre-wedding-shoot-lonavala/`, `/pre-wedding-shoot-mahabaleshwar/`, `/pre-wedding-shoot-satara/` (FAQ opens and closes), on mobile and desktop.
10. In GSC: resubmit `sitemap.xml`, and request indexing for the homepage, `/pre-wedding-photography-packages/` and `/pre-wedding-shoot-satara/`.

### Manual checks you must do yourself
- **D8: maternity price range.** `/maternity-photographer-pune/` says "cost ranges from Rs 10,000 - Rs 25,000" (twice: in the packages intro and in the FAQ), but the packages are Rs 6,000 / 9,000 / 18,000. Confirm the right range and I will update the text.
- **D9: happy clients number.** 1,179 (homepage hero stats and badge, about page) vs 1251 (homepage "Happy Client" counter). After you confirm, update the counter and the "1,000+" in the new homepage text.
- **Khushi Film Art watermark** on `home-about-1.webp` and `home-about-3.webp`.
- **GSC keyword to page:** for "pre wedding shoot in pune", "pre wedding photoshoot in pune", "wedding photographer pune", "pre wedding shoot in mumbai", "lonavala pre wedding shoot", "mahabaleshwar pre wedding shoot" and "maternity photographer pune": Performance > filter query > Pages tab. Check weekly for 8 weeks that the right page ranks (the page that owns the keyword in Step 5).
- **Screaming Frog crawl of the old sitemap:** List mode with the old sitemap (from the backup zip) and all old URLs from the 3 GSC exports. Every one must be one 301 to a 200, with no 404s. Only `/wedding-photographer-pune/` and `/bridal-photography-pune/` may end on the homepage.
- **Google Business Profile:** check the name, verification, and that the website link is `https://thebridal.photography/`.
- **GA4 lead check:** form fills and WhatsApp clicks, last 3 months vs the 3 months before, then weekly after deploy.
- **GSC Dates export:** 16 months of monthly data, to measure the seasonal share of the drop.
- **Old maternity content (Action 4):** check the Wayback Machine for `/maternity-photography-packages/` and `/best-locations-for-a-maternity-photoshoot-in-pune/` for poses, packages or FAQs the current pages lack.
- **Satara CTR (Action 3):** search "satara pre wedding location" on a phone and note what shows above the site. Check CTR in GSC after 4 weeks.
- **Lonavala hero photo:** add a real Lonavala photo when you have one.

---

## Round 3 (29 Sept 2026): homepage fixes after review

- **Hero H1 stays "Wedding Photographers / in Pune"** (D11). The buttons were hidden under the stats bar, which is fixed now: the hero text column in `home.php` is 900px wide (was 680px), so the H1 stays on 2 lines on desktop. `.hero-content` gets more bottom padding (end of `assets/css/main.css`) so the stats bar never covers the buttons. CSS version bumped to `?v=290926.0` in `layouts/main.php`. Checked at 10 screen sizes from 1920 wide down to 360 wide. **Deploy: upload `home.php`, `main.css`, `layouts/main.php`.**
- **Candid Birthday blog image:** `assets/images/blog/candid-birthday-hero.webp` was missing locally **and on live (404)**. Restored from `thebridal-bk290926.zip`. **Deploy: upload this file.**
- `home.php` blog cards now build the image URL with `base_url()`, the same way `blog/index.php` and `blog/detail.php` already do.

---

## Round 3: client answers (30 Sept 2026)

**Backup first:** `D:\xampp\thebridal-backups\2026-09-30_client-fixes\app\Views\pages\` holds `home.php` and `maternity-photographer.php` exactly as they were (checksums verified). The folder is outside htdocs, so it cannot be downloaded from the website.

| # | Client answer | Change |
|---|---|---|
| 1 | Maternity prices are Rs 6,000 / 9,000 / 18,000 | `app/Views/pages/maternity-photographer.php`: "ranges from Rs 10,000 - Rs 25,000" changed to "ranges from Rs 6,000 - Rs 18,000" (2 places: packages intro line 148, FAQ answer line 371). Nothing else changed |
| 2 | Same happy-clients number everywhere, any number | Used **1,179+**, the number already on most of the site. `app/Views/pages/home.php`: "1251+" counter (line 128) changed to "1,179+", and the intro text "1,000+" (line 78) changed to "1,179+". All happy-client counts on the homepage now show 1,179: hero stat, "Happy Client" counter, intro text, "Trusted by 1,179+ couples", and "1,179 Reviews" |
| 3 | Homepage photos: client will send later | **Pending.** No change. `home-about-1.webp` and `home-about-3.webp` still carry the Khushi Film Art watermark |
| 4 | Lonavala banner: keep the Satara photo | No change. `/pre-wedding-shoot-lonavala/` keeps `prewedding-satara.webp`. Its alt text still says "Bhushi Dam"; left as is |

**Verified on localhost:** `/`, `/maternity-photographer-pune/` and `/pre-wedding-shoot-lonavala/` return 200. No "1251", "1,000+" or "25,000" left in the rendered HTML. The maternity packages still show Rs 6,000 / 9,000 / 18,000.

**To deploy (2 files, both replace existing):**
- `D:\xampp\htdocs\thebridal\app\Views\pages\home.php` to `<web root>/app/Views/pages/home.php`
- `D:\xampp\htdocs\thebridal\app\Views\pages\maternity-photographer.php` to `<web root>/app/Views/pages/maternity-photographer.php`

**Still open:** replacement homepage photos (client to send).

---

## Round 4 (22 Oct 2026): Developer Points PDF (D-01 to D-16)

Source: `TheBridalPhotography_Developer_Points.pdf` (Movinnza SEO team, live data 21 Oct 2026).
**Backup first:** the scratchpad backup of `app/`, `main.css`, `sitemap.xml` and `tb_blogs` was taken before any change.

| # | Status | What was done |
|---|---|---|
| D-01 | Done | Old LocalBusiness block (short address, logo image, "₹₹", aggregateRating 4.9/1179) removed from `layouts/main.php`. New `app/Libraries/PageSchema.php` prints Organization + WebSite on every page (Appendix A1). Full Pune LocalBusiness (`#business`) only on `/`, all 4 offices on `/contact/`, Mumbai office on `/mumbai/`. No aggregateRating anywhere. |
| D-02 | Done | BreadcrumbList is built from the same `$breadcrumb` array that `partials/breadcrumb.php` prints, so JSON and visible trail always match. Last crumb has no `item`. 58 pages. |
| D-03 | Done | Service (name, serviceType, areaServed city, provider `#business`, no prices) on 36 service, package and city pages. Baby and newborn pages keep their own Service + FAQPage blocks. |
| D-04 | Done | Article on 12 guides, BlogPosting on the 5 posts (`datePublished` = published_at, `dateModified` = updated_at when later), CollectionPage on `/blog/`. All image URLs absolute. |
| D-05 | Done | No old URL is hard-coded in the views. The redirecting links are in the database: run **`tools/dev_points_oct2026_db_updates.sql`** (archives the duplicate "when should I take" post, fixes the PBA, Snap City and Mahabaleshwar links, Mahabaleshwar post now links Mahabaleshwar pages only). Works on the live DB whether or not the older SQL files were run. Safe to run twice. |
| D-06 | Done | Header "Baby Shoot" menu is now "Services" (Baby, Newborn, Birthday, Housewarming, Fashion & Product, All Services), desktop and mobile. `/services/` has a link in every section plus a new card grid for all 13 service pages. Lakshadweep linked from Pune locations + pre-wedding packages; Mulshi from packages + ideas post (SQL); Mahabaleshwar post from `/mahabaleshwar/`, `/pre-wedding-shoot-mahabaleshwar/`, `/mahabaleshwar/wedding-photographers/`; Ahilyanagar corporate from `/services/` + Ahilyanagar wedding; Ahilyanagar baby and maternity from the hub, each other and the engagement page; candid birthday post from `/birthday-photography-pune/`; birthday page from the post (SQL). Homepage "Fashion & Retail" card now goes to `/fashion-and-product-photography/`. |
| D-07 | Done (1 question open) | `/ahilyanagar/` baby shower card (went to a Pune page) removed; a "Baby Photoshoot in Ahilyanagar" card already existed, and the baby page was added to Related Pages. Logo alt is "The Bridal Photography" on both header logos. **Open:** step 3, may the global menu and footer (Pune links) stay on city pages? |
| D-08 | **Partly done, rest waiting on client** | Correction 22 Oct: the shared galleries (`partials/gallery-engagement.php`, `gallery-wedding.php`, `gallery-prewedding.php`) still load `mum-engage-*`, `mumbai-wp-*` and `mumbai-prewedding-*` files on all non-Mumbai city pages, Mahabaleshwar included; the engagement gallery alts are now distinct and true. | Mahabaleshwar: Mumbai files replaced with photos already in the project (engagement hero `mahab-venna.webp`, wedding hero `mahab-weather.webp`, hub cards `mahab-shoot-1.webp` (square crop) and `mahab-venna.webp`); schema images updated. Lonavala, Nashik and Sambhajinagar still need real photos (SEO doc S-10). Note: `mahab-venna`/`mahab-weather` are scenery, and the hub hero `prewedding-mahabaleshwar.webp` is a blog graphic with text, not a photo; replace with the client's own Mahabaleshwar shoots when available. Nothing renamed: renaming Mumbai photos would only hide that they are Mumbai shoots. When photos arrive, swap the `src` and update the image name in `PageSchema::PAGES` for that page. |
| D-09 | Done | og:image = page hero/primary image, absolute https URL, with real `og:image:width/height` read from the file, plus `twitter:image`. Blog posts use the featured image made absolute. `/faq/` (no photo) uses the homepage hero, never the logo. |
| D-10 | Done | width/height added to 463 images in 43 views (real pixel size of each file) + the homepage offer loop (read at runtime). Global CSS `img` rule now has `height:auto`. fetchpriority="high" on the `/about-us/`, `/pre-wedding-shoot-lonavala/` and `/blog/` heroes. No hero is lazy. |
| D-11 | Done | All 74 route redirects and all `.htaccess` rules are 301. Live checked 22 Oct: 8 sample rows are one 301 each. `/blog/odio-non-quo-rerum-a/` now returns **410 Gone** (`Routes.php`). |
| D-12 | Done | 540 headings re-levelled with a script: section titles are H2, then no level is skipped (H4 under H2 became H3 and so on), no H5/H6 left. Contact subtitle H6 is now a `<p>`. Budget page feature lines are H3 under "Package Highlights". First H2 that repeated the H1 reworded on baby shower ("Capturing Your Baby Shower"), venues ("Planning a Destination Wedding Near Pune"), housewarming ("Capturing Your New Beginning"), wedding films ("Our Latest Films"). Look unchanged: a renamed tag gets class `lvl-hN` and zero-specificity CSS restores the old size and margins (checked with before/after screenshots). |
| D-13 | Done | `tools/build_sitemap.php` no longer uses file dates (an upload resets them). It hashes the visible text inside `<main>` and keeps the old lastmod unless that text changed (`tools/sitemap_content_hashes.json`, created on the first run). `sitemap.xml`: lastmod 2026-10-22 only for the 6 pages whose text changed today (services, ahilyanagar, baby shower, venues, housewarming, wedding films). The other dates were left as they were. |
| D-14 | Done | Blog cards on `/blog/`, the homepage and "Related Articles" are `<article>`: category in its own `<span>`, a space, then `<h3><a>title</a></h3>`. The whole card stays clickable (CSS stretched link). |
| D-15 | Done | The 8 iframes on `/wedding-films/` now use the same click-to-load facade the homepage already had (`.yt-facade` + `main.js`), so no extra library. The homepage already loaded videos on click. |
| D-16 | **Waiting on SEO sign-off** | The SEO document (titles, metas, H1s, text edits) was not part of this PDF. Apply after sign-off. |

**Checked on a local copy (59 sitemap URLs):** all 200, JSON-LD valid, 0 aggregateRating, Organization + WebSite on all, LocalBusiness only on `/` (1), `/contact/` (4), `/mumbai/` (1), 58 BreadcrumbLists equal to the visible trail, 36 Service, 12 Article, 5 BlogPosting, og:image a photo with size on every page, 0 images without width/height, 1 H1 and no skipped levels on every template, no internal link to a 3xx/4xx URL, every sitemap URL has 3+ inlinks, city hub body links stay in their city.

**Confirm with the client before go-live:** opening hours (not added), priceRange "₹6,000 to ₹75,000", Mumbai office area (contact page says "Khar, Andheri West"; schema uses Andheri West as in Appendix A).

**Not changed, noted:** on the homepage the video play icon shape takes the default link colour (blue); fixed on `/wedding-films/` only. Unused views (`pre-wedding-locations-in-pune.php`, `city/mumbai-prewedding.php`, `city/mumbai-wedding.php`, `city/lonavala/prewedding.php`, `city/mahabaleshwar/prewedding.php`) were not re-levelled.

### To deploy
1. Back up the live site and `tb_blogs`.
2. Upload: `app/Libraries/PageSchema.php` (new), `app/Config/Routes.php`, `app/Views/` (layouts, partials, pages, blog: changed files listed by the diff), `assets/css/main.css` (cache-buster `?v=221026.1`), `tools/build_sitemap.php`, `sitemap.xml`.
3. Run `tools/dev_points_oct2026_db_updates.sql` on the live DB. The last SELECT must return 0 rows.
4. Rich Results Test on `/`, `/contact/`, `/mumbai/`, 5 inner pages and 1 blog post. Facebook Sharing Debugger on 2 pages. Resubmit the sitemap in GSC.

---

## Round 5 (22 Oct 2026): SEO Points PDF (S-01 to S-13)

Source: `TheBridalPhotography_SEO_Points.pdf`. The page cards were not ticked "Approved" in the PDF; applied on request.

**Done**
- **S-01/S-02/S-03:** all 59 titles, metas and H1s from Section 2 (controllers for 54 pages, `tools/seo_points_oct2026_db_updates.sql` for the 5 blog posts). Checked on a local copy: every page matches, all titles 60 chars or less, metas 120 to 155, no em dash, no "4.9"/"Silver" in metas.
  - Changed from the PDF on purpose (numbers and prices must be true on the page):
    - Venues page: "8 Best" changed to "17 Best". The page lists 17.
    - Pune locations: "20 Best" changed to "18 Best". The page covers 18 named spots.
    - Roka: "From ₹10,000" removed. On the page Rs 10,000 is an average market range, not our price.
    - Housewarming: "₹7,000" removed. It is not shown anywhere on the site.
    - Mahabaleshwar blog meta: Venna Lake and Arthur's Seat replaced with Wilson Point and Lingmala Falls. The post does not cover the first two.
- **S-04:** price conflicts fixed:
  - baby shower FAQ (from Rs 6,000)
  - Mumbai engagement FAQ (Rs 7,000)
  - wedding album (Rs 12,000)
  - FAQ page pre wedding tiers now match the packages page
  - "Starting from" line in the hero of every page that has a price in its title
- **S-05:** every Section 3 phrase removed (checked on the rendered pages), plus the per-page "Fix on page" items.
- **S-07:** maternity duplicates removed, one timing range (28 to 32 weeks), typo fixed, price table moved near the top.
- **S-10:** contact, fashion/product, wedding films, timing guide and Lakshadweep each now have 500+ words of main text.
- **S-11:** "Award-winning" removed (footer, homepage, blog sidebar, default meta). About page says 10+ years only.
- Roka: new "What Happens at a Roka Ceremony?" section, a FAQ, and 16 distinct image alts.
- Sitemap: lastmod 2026-10-22 for the 53 pages whose visible text changed.

**SEO team tasks (not code):** S-06 batches and GSC indexing requests, S-08 Rich Results/GSC checks, S-12 originality check of the Mahabaleshwar copy (no paragraphs shared with the Lonavala pages were found), S-13 checklist after deploy.

**Needs client**
- **Photos (S-09):**
  - Lonavala, Nashik and Sambhajinagar still use Mumbai files.
  - Ahilyanagar hub uses Pune files.
  - Lakshadweep "laksha-goa-1..4" and the banner look like Goa.
  - Lonavala pre wedding hero is a Satara text graphic.
  - saras-baug.webp has stock watermarks.
- **Prices:**
  - Roka starting price.
  - Housewarming price.
  - Snap City blog prices, timings and phone number.
  - Mumbai engagement tier prices.
- **Delivery times:**
  - Wedding videos 25 days vs 15 to 45 days.
  - Engagement photos 1 week vs 15 days.
  - Corporate photos 24 hours vs a couple of days.
  - Contact reply: about page says 2 hours, contact page says 24 hours.
- **Photo counts:**
  - Baby shower: 45 vs 250.
  - Engagement: 45 vs 250.
  - Pre wedding: "250 Images" changed to 60 to 70 to match the cards; please confirm.
- **Real reviews and names:**
  - Rani & Sumedh testimonial removed (it had placeholder text).
  - "Happy Parents" / "Maternity Client" labels need real names.
  - Names for homepage testimonial videos 1 to 3.
- **Other:**
  - Office opening hours.
  - Newborn: home shoots or studio only?
  - Homepage celebrity client list needs proof.
  - Wedding films "₹35,000/Day": that is the traditional video package; cinematic films are in the ₹75,000 package.

**Deploy:** upload changed `app/` files, `assets/css/main.css`, `sitemap.xml`. On the live DB, run `tools/dev_points_oct2026_db_updates.sql` first, then `tools/seo_points_oct2026_db_updates.sql` (it also edits `tb_blog_ctas`; back up both tables first).
