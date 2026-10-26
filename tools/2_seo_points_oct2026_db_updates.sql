-- SEO Points, Oct 2026 (S-01, S-02, S-03, S-05): blog post changes that live in the database.
-- Run AFTER tools/dev_points_oct2026_db_updates.sql. Content only, no table structure changes.
-- Take a backup of tb_blogs first (phpMyAdmin > tb_blogs > Export). Each statement is safe to run twice.
SET NAMES utf8mb4;

-- ── S-01 / S-02: new title tag and meta description (Section 2)
UPDATE tb_blogs SET meta_title = 'Candid Birthday Photography: 10 Tips for Natural Photos',
       meta_description = '10 easy tips for candid birthday photos: natural light, burst mode and the right moments to capture real smiles. From The Bridal Photography, Pune.'
 WHERE slug = 'candid-birthday-photography-tips';
UPDATE tb_blogs SET meta_title = 'Pre Wedding Shoot Ideas (2026): Themes, Poses & Locations',
       meta_description = 'Fresh pre wedding shoot ideas for 2026: themes, poses, outfits and locations near Pune, Mumbai and Goa. Save these ideas for your shoot.'
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET meta_title = 'PBA Film City Pune Pre Wedding Shoot: Sets, Booking, Tips',
       meta_description = 'Planning a pre wedding shoot at PBA Film City, Pune? See the sets, how to book, the best time to go and simple shoot tips before you visit.'
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';
UPDATE tb_blogs SET meta_title = 'Snap City Pune Pre Wedding Shoot: Sets, Price & Tips',
       meta_description = 'Snap City Pune pre wedding shoot guide: sets, package prices, timings and tips for the best photos. Read this before you book your slot.'
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs SET meta_title = 'Best Wedding Photo Spots in Mahabaleshwar (Guide)',
       meta_description = 'Best wedding photo spots in Mahabaleshwar: Wilson Point, Lingmala Falls, Mapro Garden, colonial bungalows and more, with tips on light and season.'
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';

-- ── S-03: new H1 (the post title is the H1)
UPDATE tb_blogs SET title = 'Pre Wedding Shoot at Snap City Pune'
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';

-- ── S-05: blog text fixes
-- Every statement below is idempotent: REPLACE only matches the old text, and the two
-- "add a paragraph" updates are guarded with NOT LIKE so a second run changes nothing.

-- candid-birthday-photography-tips: unclear sentence
UPDATE tb_blogs SET content = REPLACE(content,
  'But whenever speeches are given, they are introduced with the warning to keep an eye out, because these are when the emotions are high and the prices emotions cost are on display.',
  'Keep an eye on the speeches too, because this is when emotions run high and you can catch real smiles, laughter and happy tears.')
 WHERE slug = 'candid-birthday-photography-tips';

-- candid-birthday-photography-tips: the CTA "Brief go through about our pricing plans" appears twice (tb_blog_ctas).
-- Turn the first one into a birthday photography CTA, then remove the remaining copy.
UPDATE tb_blog_ctas c JOIN tb_blogs b ON b.id = c.blog_id
   SET c.heading = 'Want a photographer for your birthday party?',
       c.button_label = 'See Birthday Photography',
       c.button_url = '/birthday-photography-pune/',
       c.updated_at = NOW()
 WHERE b.slug = 'candid-birthday-photography-tips'
   AND c.heading = 'Brief go through about our pricing plans'
   AND c.anchor_heading = 'Shoot in Burst Mode';
DELETE c FROM tb_blog_ctas c JOIN tb_blogs b ON b.id = c.blog_id
 WHERE b.slug = 'candid-birthday-photography-tips'
   AND c.heading = 'Brief go through about our pricing plans';
-- Any CTA on this post that still points to pre wedding pricing goes to the birthday page instead.
UPDATE tb_blog_ctas c JOIN tb_blogs b ON b.id = c.blog_id
   SET c.button_url = '/birthday-photography-pune/', c.updated_at = NOW()
 WHERE b.slug = 'candid-birthday-photography-tips'
   AND c.button_url LIKE '%pre-wedding%';

-- pre-wedding-shoot-ideas: typos and leftover lines
UPDATE tb_blogs SET content = REPLACE(content, 'compressive piece of content', 'comprehensive piece of content')
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET content = REPLACE(content, 'Why pre pre-wedding shoots becoming popular?', 'Why are pre wedding shoots becoming popular?')
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET content = REPLACE(content,
  'It is less about heavy-extrelling and more of how natural tends to be when walking together for many candid moments, smiles shared.',
  'It is less about heavy embroidered outfits and more about how natural you look walking together, with plenty of candid moments and shared smiles.')
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET content = REPLACE(content, 'lonavala, mahabaleshwer, ', 'lonavala, Mahabaleshwar, ')
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET content = REPLACE(content, '</a>, taminighat, pawana dam', '</a>, Tamhini Ghat, pawana dam')
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET content = REPLACE(content, 'Dense forests, feckless trails,', 'Dense forests, quiet trails,')
 WHERE slug = 'pre-wedding-shoot-ideas';
UPDATE tb_blogs SET content = REPLACE(content,
  '<p>Alright, here is the last set of some innovative couples choice for Pre wedding photoshoot. Most look towards memorable and sentimental shots with creative ideas that work extraordinarily in making a surprise before their special day commences.</p>',
  '')
 WHERE slug = 'pre-wedding-shoot-ideas';

-- pre-wedding-shoot-in-pba-film-city-pune: the opening "Right at this time..." is already shown as the excerpt
-- in the page hero, so remove the second copy from the body.
UPDATE tb_blogs SET content = REPLACE(content,
  '<p>Right at this time when many would-be couples, or people with a wedding soon to take place in their families, are looking for the best locations for a pre-wedding photo shoot, many have already decided that <strong>Pre-wedding shoot PBA City Pune</strong> is the best place for this purpose.</p>',
  '')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';
UPDATE tb_blogs SET content = REPLACE(content,
  'There is no end to themes when going for a pre-wedding shoot at the best destination of India – the PBA Film City.',
  'There are plenty of theme options for a pre-wedding shoot at PBA Film City.')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';
UPDATE tb_blogs SET content = REPLACE(content,
  'You already know it by now that PBA Film City is the first choice of professional photographers and it is particularly so for a pre-wedding photo shoot.',
  'PBA Film City is a popular choice with photographers, especially for pre-wedding shoots.')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune';
UPDATE tb_blogs SET content = REPLACE(content,
  '<p>At PBA Film City, wardrobes matching almost all types of themes can be found and you may look the best suitable for yourself.</p>',
  '<p>At PBA Film City, wardrobes matching almost all types of themes can be found and you may look the best suitable for yourself.</p><p>Plan two or three outfit changes so your album has variety, for example one traditional outfit, one western or casual look and one that matches your main theme. Choose colours that stand out against the sets you plan to use, and avoid very small, busy prints that can look distracting on camera. Carry comfortable footwear for walking between sets and a small kit with safety pins, a comb and touch-up make-up.</p>')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune'
   AND content NOT LIKE '%Plan two or three outfit changes so your album has variety%';
UPDATE tb_blogs SET content = REPLACE(content,
  'you may have plethora of prospects to incorporate and display local culture into your photo shoot.</p>',
  'you may have plethora of prospects to incorporate and display local culture into your photo shoot.</p><p>For a Maharashtrian touch, the bride can wear a Paithani or Nauvari saree with traditional jewellery such as a nath, and the groom can add a pheta. Small props like a mogra gajra or brass diyas can also bring a cultural feel to your frames. Share these ideas with your photographer before the shoot so the poses and props suit the sets you choose.</p>')
 WHERE slug = 'pre-wedding-shoot-in-pba-film-city-pune'
   AND content NOT LIKE '%For a Maharashtrian touch, the bride can wear%';

-- prewedding-shoot-at-snap-city-pune: spelling, grammar and cut-off H3s (prices left as they are: NEEDS CLIENT)
UPDATE tb_blogs SET content = REPLACE(content, 'Are there sets of props to suite my theme', 'Are there sets of props to suit my theme')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs SET content = REPLACE(content, 'you photographs are going to picturesque', 'your photographs are going to be picturesque')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs SET content = REPLACE(content, '<h3>Posing Tips for a Stunning</h3>', '<h3>Posing Tips for a Stunning Snap City Shoot</h3>')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs SET content = REPLACE(content, '<h3>Creative Themes for Your Snap City</h3>', '<h3>Creative Themes for Your Snap City Shoot</h3>')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs SET content = REPLACE(content, '<h3>Incorporating Local Culture into Your Snap City</h3>', '<h3>Incorporating Local Culture into Your Snap City Shoot</h3>')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';
UPDATE tb_blogs SET content = REPLACE(content, '<h3>How to Choose the Right Photographer for Your Snap City</h3>', '<h3>How to Choose the Right Photographer for Your Snap City Shoot</h3>')
 WHERE slug = 'prewedding-shoot-at-snap-city-pune';

-- the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography: machine-like lines
-- (this post has no prices, so there is no price format to unify)
UPDATE tb_blogs SET content = REPLACE(content,
  'rustic charm, beaded in ivy cover, is that setting where the timelessness of marriage photography can be found.',
  'rustic charm and ivy-covered walls give wedding photos a timeless feel.')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
UPDATE tb_blogs SET content = REPLACE(content,
  'The waterfall at Lingmala gladdens down in the middle of the forest and adds to the fairytale-like feel.',
  'Lingmala Falls drops through the middle of the forest and adds a fairytale feel to your photos.')
 WHERE slug = 'the-charm-of-mahabaleshwar-ideal-backdrops-for-wedding-photography';
