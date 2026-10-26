# The Bridal Photography: full website check (23 Oct 2026)

Checked: all 54 live pages in this upload folder (controllers, page views, header, footer, layout, schema, routes, sitemap, robots, llms.txt).
Method: automated checks on every page (titles, meta, H1, headings, alt text, links, schema, prices, forms) plus a page-by-page read of every page.
Not checkable from the code: real image files (not in the bundle), blog post text (in the database), live server cache.

## What is already fine
- Every page has one H1, a self canonical, a title of 43–59 characters and a description of 130–157 characters. No duplicate titles.
- All PHP files pass a syntax check. No broken characters (₹ is intact).
- Sitemap lists every live page; no redirected or missing URLs in it. robots.txt and llms.txt are fine.
- Internal links: no link points to a redirect, a 404, or a URL without a trailing slash. No orphan pages.
- Every form has CSRF protection. Phone and WhatsApp numbers are correct everywhere.
- Hero images load eagerly with width/height; nearly all other images have width/height.
- Schema: Organization, WebSite, BreadcrumbList on every page; Service / Article per page type; FAQPage on 17 pages; Offers on 5 package pages; VideoObject on Wedding Films.

## 1. Must fix first (wrong information or broken)
| Page | Problem | Fix |
|---|---|---|
| /mumbai/ | FAQ says "₹50,000 to ₹5,00,000 per day"; packages section has no prices | "From ₹35,000 per day" (₹35,000 / ₹55,000 / ₹75,000) |
| /mumbai/ and /mumbai/engagement-photography-packages/ | All call/WhatsApp buttons use the Pune number; Mumbai number (+91 88062 25566) only in small text | Show the Mumbai number in the hero and contact card |
| /mumbai/engagement-photography-packages/ | 4 packages with no prices (Basic/Standard/Premium/Luxury); text says "pre-wedding" and "wedding" on an engagement page; "Rs 7,000" in FAQ | 3 tiers ₹7,000 / ₹22,000 / ₹35,000; fix wording |
| /mahabaleshwar/engagement-photographers/ | Testimonial says "engagement photographers in **Ahilyanagar**" (copied) | Replace with a real Mahabaleshwar review |
| /nashik/wedding-photographers/ | Placeholder text "begins at **base price**" | "From ₹35,000 per day" |
| /mahabaleshwar/wedding-photographers/ | "Hunnas Falls" (not in Mahabaleshwar) | Lingmala Falls |
| /lonavala/ | "Professional photographers **based in Lonavala**" (false); "Bhushi Dam near Lohagad fort" (wrong) | "Pune studio, 1–2 hrs from Lonavala"; fix the dam location |
| /sambhajinagar/wedding-photographers/ | Sentence says the opposite: "not too intrusive, which makes couples feel staged" | "…so couples never feel staged" |
| /wedding-photography-packages/ | Meta says "album" included (it is a ₹400/page add-on); "no extra fees" vs travel/home-entry/NDA charges; "pendrive of all images" vs "raw data ₹6,500" vs "we don't provide raw"; delivery 15 days vs 15–45 days; "proposal valid for 30 days" | Remove "album" from meta; make one consistent set of terms |
| /birthday-photography-pune/ | Packages are copied from newborn (₹6,000/8,000/18,000, "3 themed setups") but page sells party coverage; a 600-word "baby / newborn" block competes with the baby and newborn pages; uses the newborn hero image | Real party packages; remove the baby block; own hero |
| /housewarming-photography-pune/ | Offers "live streaming" in the standard package; meta targets "Griha Pravesh" but the page never says it; no price; images are a pool/hill view | Correct the offer; add Griha Pravesh/Vastu Shanti text, price and real puja photos |
| /baby-photoshoot-pune/ | Title/meta "From ₹6,000" but body says milestone/cake smash are "contact for quote" (₹6,000 is the newborn price) | Publish a real starting price or remove it from the title |
| /newborn-photography-pune/ | Tip says "wake up your baby 1–2 hours before the shoot so that he/she may sleep" (meaning reversed); pricing text mentions albums/prints no package has; "View Packages" goes to the baby page | Fix the tip; rewrite pricing text; link to #packages |
| /maternity-photoshoot-locations-pune/ | Aga Khan Palace "Mughal reign" (built 1892); "University of Pune" (now SPPU); "unlimited supply of oxygen", "academic vibes may transfer to the baby"; "It's a Boy" board image (sex determination is illegal under the PCPNDT Act) | Correct facts; remove the health-claim lines; replace the image |
| /pre-wedding-shoot-mahabaleshwar/ and /pre-wedding-shoot-lavasa/ | "Pleasant climate throughout the year" (heavy monsoon; contradicts the page's own best season) | Match the stated best season |
| /pre-wedding-shoot-lonavala/ | Hero image is the Satara collage; "Delivery: 50 to 300 photos"; "Rs 14,999" | Lonavala hero; correct photo count; ₹ |
| /pre-wedding-shoot-lakshadweep/ | Photos are files named laksha-goa-1…4 (Goa shoots) shown as Agatti/Bangaram; claims underwater shoots | Use real Lakshadweep photos or label honestly; remove the underwater claim |
| /services/ | Pre-wedding section shows a baby with a teddy; baby section shows a bride and groom | Swap the two images |
| /fashion-and-product-photography/ | No product images (hero is "performers in bunny masks at a party"); meta says "Amazon" but the page never does | Real product/lookbook photos; add marketplace section or remove "Amazon" |
| /pre-wedding-shoot-satara/ (earlier list) | Vajrai height "145 m" (usually ~560 m) | Verify |

## 2. Development (code) issues
| Where | Problem | Fix |
|---|---|---|
| Blog controller | `?page=0` or negative gives a negative SQL offset (possible error page) | `$page = max(1, (int) $page)`; 404 if beyond last page |
| Blog controller | Category filter counts only the first 9 posts; only 9 posts per category reachable | Count and paginate categories properly |
| Blog listing | Pages 2+ and `?cat=` all canonical to /blog/ and all "index, follow" | Self canonical per page, or noindex for `?cat=` |
| Blog listing | Category tabs only hide cards with JavaScript on the current page; pagination drops the category | Make tabs real links; keep `cat` in pagination |
| Blog listing/detail | Empty alt when the DB alt is an empty string (fallback only for null); `substr` can break ₹/Marathi text | `?:` fallback; `mb_substr` |
| Blog detail | Two-column grid is an inline style, so it doesn't stack on mobile | Move to a CSS class with a breakpoint |
| Blog detail | View counter writes to the DB on every request (bots included) | Skip bots / count once per session |
| /faq/ and /about-us/ | Inline two-column grids override the mobile CSS, so the text stays squeezed on phones | Use the existing grid classes |
| All enquiry forms (about 40 pages) | Labels not linked to inputs (no for/id); only phone is required while the server needs name + email; asks for "Address" instead of event date/details | Add for/id, `required` on name/email, replace Address with event date + message |
| FAQ accordions (all pages) | Buttons have no `type="button"` / `aria-expanded` | Add them (check main.js toggles aria-expanded) |
| Header | Wedding menu also highlights on pre-wedding pages | `&& ! str_contains($currentUrl, 'pre-wedding')` |
| Inline styles | font-family inline on 10 views; many inline layout styles on Mumbai, Lonavala, Goa pages | Move to CSS |
| Several images | Same file used twice with different declared sizes (Mumbai, Ahilyanagar maternity, newborn, Mahabaleshwar hero) → layout shift / stretching | One size per file; real dimensions |
| /pre-wedding-shoot-mahabaleshwar/ | Six images are 259–299 px thumbnails stretched full width (blurry, possibly copied) | Own photos ≥1000 px |
| CityHub controller | Unused methods for the 4 redirected URLs | Delete (cleanup) |
| Not in this upload | `partials/breadcrumb`, `partials/form-flash`, `assets/js/main.js`, `responsive_img()` helper | Already on the server (pages work live) – do not delete them |
| Live server | Old cached homepage/maternity page; old URLs not redirecting | See HOSTINGER_STEPS.txt step 5 |

## 3. SEO
| Area | Problem | Fix |
|---|---|---|
| FAQ schema | 28 pages have an FAQ but no FAQPage schema: wedding packages, FAQ page, contact, birthday, housewarming, Lavasa, Lonavala, Mahabaleshwar, Mumbai locations, all 14 Lonavala/Mahabaleshwar/Nashik/Sambhajinagar pages, Ahilyanagar hub/corporate/maternity, Mumbai hub/engagement | Add `PageSchema::faqScript($faqs)` (strip the HTML in the Nashik FAQ answers first) |
| "Rs" prices | baby, newborn, birthday, services, wedding packages, Lakshadweep, Mahabaleshwar, Lonavala, Mulshi, 4 city pages, Mumbai engagement | Use "₹" |
| Cannibalisation | /lonavala/ and /mahabaleshwar/ hubs: titles fixed, but H1, H2s, cards and FAQ still target "photoshoot / pre wedding"; Nashik hub has full pre-wedding/wedding/engagement sections; birthday page targets baby/newborn | Hub = weddings & engagements, short teaser + one link to the pre-wedding page |
| City pages (14) | Same Mumbai/Lavasa photos and alts in every city; spun, broken English; almost no prices; generic or copied testimonials; Sambhajinagar pages name no real places | Local photos, real places, ₹ prices, plain English rewrite |
| Thin pages | Mulshi, Lonavala pre-wedding, Sambhajinagar pre-wedding, product, housewarming, maternity locations (title promises timings/tips that aren't there) | Add named spots, timings, tips, FAQ |
| Titles vs H1 | Generic H1s: "About Us", "Frequently Asked Questions", "Photographers in Lonavala/Nashik/Sambhajinagar", blog "Guides, Stories and Inspiration" | Add the keyword and location |
| Headings ending ":" | baby (12), Nashik hub (5), Sambhajinagar hub/engagement/pre-wedding (13), Lakshadweep (4), Mahabaleshwar (2), newborn (2), Lonavala hub (1) | Remove colons; list labels should not be headings |
| Generic closing H2 | "Need a Photographer? Someone With Experience…" still on about 7 other pages | Page-specific CTA with price + call button |
| E-E-A-T | No named founder/photographers anywhere; About page has no team names | Add names, roles, short bios |
| Claims | "Hundreds of weddings", "appeared in leading magazines", "5-star rating", "10 years" (studio since 2014) | Use real numbers / "since 2014" |

## 4. Image alt text
- All images have alt text; no file-name style alts, no old years. Script check passed.
- Problem is accuracy: many alts honestly describe photos that sit in the wrong section or city (see section 1 and the city-page row).
- Same alt on several pages: "Engaged couple showing their rings in front of a floral backdrop" (6 pages), "Bride in a red embroidered lehenga lifting her sheer red veil" (4), "Couple seen from behind raising wine glasses at a lakeside picnic" (4), and 4 more on 3 pages each. Make these unique per page or name the place.
- Hero alts on Lakshadweep, Lavasa, Mulshi, Mahabaleshwar describe the words printed on the banner image, not the photo.

## 5. CTA
- Every page has a call / WhatsApp / contact CTA, top and bottom.
- Improve: WhatsApp "Choose Plan" / "Book Now" links open a blank chat; pre-fill the package name (`?text=`).
- Contact page has no buttons above the fold (only H1 + tagline).
- Reply time contradicts itself: "within 2 hours" (about, FAQ) vs "within 24 hours" (contact, form message).
- Several H2s are CTA sentences with no button under them (newborn, birthday, housewarming).

## 6. Internal linking
| Check | Result |
|---|---|
| Links to redirects / 404 / missing slash | None |
| Orphan pages | None |
| Weak inbound (0–1 links from other page bodies) | /about-us/ (0), /best-destination-wedding-venues-pune/ (1), /housewarming-photography-pune/ (1) – add body links from home, wedding packages, services |
| Bare "pre wedding shoot in Pune" anchor | Lavasa and Mulshi related links → change to "pre wedding shoot packages in Pune" |
| Off-rule anchors to packages page | "pre-wedding packages" (7x), "pre wedding packages" (3x), "packages & pricing" – change to "pre wedding shoot packages in Pune" / "all pre-wedding packages" |
| Off-rule anchors to Pune locations page | "all pune locations" (3x), "pre-wedding locations" – change to "pre wedding shoot locations in Pune" |
| Homepage | Main keyword "wedding photographer in Pune" is never used as an anchor to the homepage; 9 links to it are the bare URL in the contact card (target=_blank, pointless) – remove those and add a few "wedding photographer in Pune" anchors from guide pages |
| Wedding packages | 11 of 19 anchors are just "wedding packages" – vary with "wedding photography packages in Pune" |
| "baby photoshoot" anchor | Points to both the Pune and the Ahilyanagar page – use "baby photoshoot in Ahilyanagar" for the city page |
| Related pages off-topic | Product page links Wedding Packages/FAQ; Lakshadweep, maternity locations link Pune pre-wedding locations; Goa links wedding packages – link related services instead |
| Self link | /blog/ "View All Articles" links to itself |
