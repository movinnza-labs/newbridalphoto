-- SEO fix, Sept 2026: data changes made on localhost that must also be run on
-- the live database. Content only, no table structure changes.
-- Take a backup of tb_blogs first (phpMyAdmin > tb_blogs > Export).
-- Table prefix is tb_ (see .env). Each statement is safe to run twice.

-- Step 3.4: blog post 4 (PBA Film City) linked to an old Goa URL. Point it to the final page.
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/5-destination-for-a-pre-wedding-shoot-in-goa/',
       'https://thebridal.photography/pre-wedding-shoot-locations-in-goa/')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';

-- Step 4: duplicate article. /blog/when-should-i-take-my-pre-wedding-shoot/ now
-- 301s to /when-to-take-pre-wedding-shoot/ (Routes.php). Archive the post so the
-- blog list, homepage "recent blogs" and "related articles" stop linking to it.
UPDATE tb_blogs SET status = 'archived'
 WHERE slug = 'when-should-i-take-my-pre-wedding-shoot';

-- D7: lorem ipsum test post was live. Set to draft (it is also left out of the sitemap).
UPDATE tb_blogs SET status = 'draft'
 WHERE slug = 'odio-non-quo-rerum-a';

-- D1 / Step 6: /pre-wedding-photography-packages/ owns "pre wedding shoot in pune".
-- Old links inside blog posts go straight to it (no redirect hop).
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/pre-wedding-shoot/"',
       'https://thebridal.photography/pre-wedding-photography-packages/"')
 WHERE slug IN ('pre-wedding-shoot-in-pba-film-city-pune',
                'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography');
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/10-beautiful-pre-wedding-photoshoot-locations-in-pune-2024/',
       'https://thebridal.photography/pre-wedding-photography-packages/')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
-- Step 6.3: anchor "Pre wedding shoot in Pune" pointed to the locations guide.
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/pre-wedding-shoot-locations-in-pune/"><span style="text-decoration: underline;"><strong>Pre wedding shoot in Pune',
       'https://thebridal.photography/pre-wedding-photography-packages/"><span style="text-decoration: underline;"><strong>Pre wedding shoot in Pune')
 WHERE slug = 'pre-wedding-shoot-ideas';

-- D2: the homepage owns "wedding photographer in pune".
UPDATE tb_blogs
   SET content = REPLACE(content,
       'https://thebridal.photography/wedding-photographer-pune/',
       'https://thebridal.photography/')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
