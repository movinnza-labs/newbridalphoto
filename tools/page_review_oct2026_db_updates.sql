-- Page review, Oct 2026: blog post fixes that must also be run on the live database.
-- Content only, no table structure changes. Run tools/seo_fix_db_updates.sql first
-- (these REPLACEs expect the links that file sets).
-- Take a backup of tb_blogs first (phpMyAdmin > tb_blogs > Export).
-- Table prefix is tb_ (see .env). Each statement is safe to run twice.

-- Mahabaleshwar post: same-city links instead of Pune links.
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<a href="https://thebridal.photography/pre-wedding-photography-packages/"><span style="text-decoration: underline;"><strong>pre-wedding photography</strong></span></a>',
       '<a href="https://thebridal.photography/pre-wedding-shoot-mahabaleshwar/"><span style="text-decoration: underline;"><strong>pre-wedding shoot in Mahabaleshwar</strong></span></a>')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<p><strong>Also read</strong> :<a href="https://thebridal.photography/pre-wedding-shoot-pune-under-10000/"><span style="text-decoration: underline;"><strong>Pre wedding shoot under Rs.10000/- in Pune</strong></span></a></p>',
       '')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<a href="https://thebridal.photography/"><span style="text-decoration: underline;"><strong>wedding photographers in Pune</strong></span></a> offer it all',
       '<a href="https://thebridal.photography/mahabaleshwar/wedding-photographers/"><span style="text-decoration: underline;"><strong>wedding photographers in Mahabaleshwar</strong></span></a> offer it all')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';

-- Snap City post: wrong phone number, and a heading that was cut off.
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<a href="tel:%20+919130901234"><strong>+91 9130901234 </strong></a>',
       '<a href="tel:+918390367637"><strong>+91 83903 67637</strong></a> ')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs
   SET content = REPLACE(content,
       '<h3>Posing Tips for a Stunning</h3>',
       '<h3>Posing Tips for a Stunning Shoot</h3>')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
