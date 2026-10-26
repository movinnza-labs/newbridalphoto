-- Developer Points, Oct 2026 (D-05, D-06): blog post links that live in the database.
-- Content only, no table structure changes. Each statement is safe to run twice, and
-- works whether or not tools/seo_fix_db_updates.sql was run before (it handles both the
-- old live links and the links that file sets).
-- Take a backup of tb_blogs first (phpMyAdmin > tb_blogs > Export).
-- updated_at is not touched: these are link fixes, not content changes (dateModified stays honest).

-- ── D-05: duplicate article. Its URL already 301s to /when-to-take-pre-wedding-shoot/.
-- Archiving it removes the redirecting card from the homepage, /blog/ and "related articles"
-- on /blog/candid-birthday-photography-tips/.
UPDATE tb_blogs SET status = 'archived'
 WHERE slug = 'when-should-i-take-my-pre-wedding-shoot';

-- Lorem ipsum test post: keep it unpublished (the route now answers 410 Gone).
UPDATE tb_blogs SET status = 'draft'
 WHERE slug = 'odio-non-quo-rerum-a';

-- ── D-05: PBA Film City post
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/pre-wedding-shoot/"',
       'https://thebridal.photography/pre-wedding-photography-packages/"')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/5-destination-for-a-pre-wedding-shoot-in-goa/',
       'https://thebridal.photography/pre-wedding-shoot-locations-in-goa/')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';

-- ── D-05: Snap City post, anchor "pre wedding shoot Pune" -> Pune locations guide
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/',
       'https://thebridal.photography/pre-wedding-shoot-locations-in-pune/')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/pre-wedding-photography-packages/"><strong>pre wedding shoot Pune',
       'https://thebridal.photography/pre-wedding-shoot-locations-in-pune/"><strong>pre wedding shoot Pune')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';

-- ── D-05: Mahabaleshwar post, same-city targets
-- Anchor "pre-wedding photography" -> /pre-wedding-shoot-mahabaleshwar/ (anchor text unchanged)
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/pre-wedding-shoot/"',
       'https://thebridal.photography/pre-wedding-shoot-mahabaleshwar/"')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/pre-wedding-photography-packages/"><span style="text-decoration: underline;"><strong>pre-wedding photography',
       'https://thebridal.photography/pre-wedding-shoot-mahabaleshwar/"><span style="text-decoration: underline;"><strong>pre-wedding photography')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
-- Anchor "wedding photographers in Pune" -> "wedding photographers in Mahabaleshwar"
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<a href="https://thebridal.photography/wedding-photographer-pune/"><span style="text-decoration: underline;"><strong>wedding photographers in Pune</strong>',
       '<a href="https://thebridal.photography/mahabaleshwar/wedding-photographers/"><span style="text-decoration: underline;"><strong>wedding photographers in Mahabaleshwar</strong>')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<a href="https://thebridal.photography/"><span style="text-decoration: underline;"><strong>wedding photographers in Pune</strong>',
       '<a href="https://thebridal.photography/mahabaleshwar/wedding-photographers/"><span style="text-decoration: underline;"><strong>wedding photographers in Mahabaleshwar</strong>')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
-- "Also read" line pointed to a Pune budget page: drop it (Mahabaleshwar pages only)
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<p><strong>Also read</strong> :<a href="https://thebridal.photography/pre-wedding-shoot-pune-under-10000/"><span style="text-decoration: underline;"><strong>Pre wedding shoot under Rs.10000/- in Pune</strong></span></a></p>',
       '')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
-- Any other leftover link to the old URL in this post goes to the Mahabaleshwar page too
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/wedding-photographer-pune/',
       'https://thebridal.photography/mahabaleshwar/wedding-photographers/')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';

-- ── D-06: Candid Birthday post -> /birthday-photography-pune/ (guarded so it is added once)
UPDATE tb_blogs
   SET content = REPLACE(content,
       'unposed moments.</p>',
       'unposed moments. If you would rather enjoy the party, our <a href="https://thebridal.photography/birthday-photography-pune/">birthday photography in Pune</a> team can cover it for you.</p>')
 WHERE slug = 'candid-birthday-photography-tips'
   AND content NOT LIKE '%/birthday-photography-pune/%';

-- ── D-06: Pre Wedding Shoot Ideas post -> /pre-wedding-shoot-mulshi/ (guarded)
UPDATE tb_blogs
   SET content = REPLACE(content,
       'mahabaleshwer, Mulshi, taminighat',
       'mahabaleshwer, <a href="https://thebridal.photography/pre-wedding-shoot-mulshi/">Mulshi</a>, taminighat')
 WHERE slug = 'pre-wedding-shoot-ideas'
   AND content NOT LIKE '%/pre-wedding-shoot-mulshi/%';

-- ── D-10: Pre Wedding Shoot Ideas post: add real width/height to the 16 body images (guarded)
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-spiritual-temple.webp"', 'src="assets/images/blog/prewedding-spiritual-temple.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-spiritual-temple.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-traditional-wear.webp"', 'src="assets/images/blog/prewedding-traditional-wear.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-traditional-wear.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-riverside-boating.webp"', 'src="assets/images/blog/prewedding-riverside-boating.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-riverside-boating.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-bike-ride.webp"', 'src="assets/images/blog/prewedding-bike-ride.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-bike-ride.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-hobbies-passion.webp"', 'src="assets/images/blog/prewedding-hobbies-passion.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-hobbies-passion.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-walking-garden.webp"', 'src="assets/images/blog/prewedding-walking-garden.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-walking-garden.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-fun-playful.webp"', 'src="assets/images/blog/prewedding-fun-playful.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-fun-playful.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-love-for-vacation.webp"', 'src="assets/images/blog/prewedding-love-for-vacation.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-love-for-vacation.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-surprise-moments.webp"', 'src="assets/images/blog/prewedding-surprise-moments.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-surprise-moments.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-with-horse.webp"', 'src="assets/images/blog/prewedding-with-horse.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-with-horse.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-royal-palace.webp"', 'src="assets/images/blog/prewedding-royal-palace.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-royal-palace.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-beachside-romance.webp"', 'src="assets/images/blog/prewedding-beachside-romance.webp" width="1200" height="800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-beachside-romance.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-forest-adventure.webp"', 'src="assets/images/blog/prewedding-forest-adventure.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-forest-adventure.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-boat-ride-lake.webp"', 'src="assets/images/blog/prewedding-boat-ride-lake.webp" width="1200" height="823"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-boat-ride-lake.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-graffiti-street-art.webp"', 'src="assets/images/blog/prewedding-graffiti-street-art.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-graffiti-street-art.webp" width=%';
UPDATE tb_blogs SET content = REPLACE(content, 'src="assets/images/blog/prewedding-waterfall.webp"', 'src="assets/images/blog/prewedding-waterfall.webp" width="1200" height="1800"') WHERE slug = 'pre-wedding-shoot-ideas' AND content NOT LIKE '%prewedding-waterfall.webp" width=%';

-- ── Check (should return 0 rows): published posts that still link to a redirecting URL
SELECT slug FROM tb_blogs
 WHERE status = 'published'
   AND (content LIKE '%/blog/when-should-i-take-my-pre-wedding-shoot/%'
     OR content LIKE '%thebridal.photography/pre-wedding-shoot/"%'
     OR content LIKE '%/5-destination-for-a-pre-wedding-shoot-in-goa/%'
     OR content LIKE '%/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/%'
     OR content LIKE '%/wedding-photographer-pune/%');
