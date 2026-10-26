<?php

namespace App\Controllers;

class Pages extends BaseController
{
    // ── Helper ─────────────────────────────────────────────────────────
    private function render(string $view, array $data = []): string
    {
        return view('layouts/main', $data + ['view' => $view]);
    }

    // ── JSON-LD helpers (FAQ schema is built from the same array the view renders) ──
    private function jsonLd(array $data): string
    {
        return '<script type="application/ld+json">' . "\n"
            . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT)
            . "\n</script>\n";
    }

    private function faqSchema(array $faqs): array
    {
        $plain = static fn (string $s): string => html_entity_decode(strip_tags($s), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(static fn (array $f): array => [
                '@type'          => 'Question',
                'name'           => $plain($f[0]),
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $plain($f[1])],
            ], $faqs),
        ];
    }

    // ── Services / General ─────────────────────────────────────────────
    public function services(): string
    {
        return $this->render('pages/services', [
            'title'        => 'Photography Services in Pune & Mumbai | From ₹6,000',
            'description'  => 'Wedding, pre wedding, engagement, maternity, baby and event photography in Pune and Mumbai. Packages from ₹6,000. Compare services and book today.',
            'canonical'    => '/services/',
            'breadcrumb'   => [['Home', '/'], ['Services', '/services/']],
            'preloadImage' => 'assets/images/svc-wedding.webp',
        ]);
    }

    public function weddingFilms(): string
    {
        return $this->render('pages/wedding-films', [
            'title'       => 'Cinematic Wedding Films in Pune & Mumbai | From ₹35,000',
            'description' => 'Cinematic wedding films in Pune and Mumbai: 3 to 4 minute film plus 1 minute teaser, shot on Sony A7S3. From ₹35,000 per day. Watch our films.',
            'canonical'   => '/wedding-films/',
            'breadcrumb'  => [['Home', '/'], ['Wedding Films', '/wedding-films/']],
        ]);
    }

    public function faq(): string
    {
        return $this->render('pages/faq', [
            'title'       => 'Wedding Photography FAQ: Prices, Booking, Delivery',
            'description' => 'Quick answers on package prices, booking, delivery time and cancellation for wedding, pre wedding and maternity shoots in Pune. Read before you book.',
            'canonical'   => '/faq/',
            'breadcrumb'  => [['Home', '/'], ['FAQ', '/faq/']],
        ]);
    }

    // ── Pre-Wedding ────────────────────────────────────────────────────
    public function preWeddingLocations(): string
    {
        return $this->render('pages/pre-wedding-locations-pune', [
            'title'        => '18 Best Pre Wedding Shoot Locations in Pune (2026) + Cost',
            'description'  => '18 best pre wedding shoot spots in Pune with cost, timings and tips: forts, gardens, lakes and film sets like Snap City and PBA. Plan your shoot now.',
            'canonical'    => '/pre-wedding-shoot-locations-in-pune/',
            'breadcrumb'   => [['Home', '/'], ['Pre-Wedding Shoot', '/pre-wedding-shoot-locations-in-pune/']],
            'preloadImage' => 'assets/images/prewedding-locations-pune-2.webp',
        ]);
    }

    public function preWeddingPackages(): string
    {
        return $this->render('pages/pre-wedding-packages', [
            'title'       => 'Pre Wedding Shoot Packages in Pune | From ₹14,999 (2026)',
            'description' => 'Pre wedding shoot packages in Pune from ₹14,999. Compare Gold, Platinum and Diamond: photos, locations and add-ons. Budget plan at ₹9,999.',
            'canonical'   => '/pre-wedding-photography-packages/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding Packages', '/pre-wedding-photography-packages/']],
        ]);
    }

    public function preWeddingBudget(): string
    {
        return $this->render('pages/pre-wedding-budget', [
            'title'       => 'Pre Wedding Shoot in Pune Under ₹10,000 | ₹9,999 Package',
            'description' => 'Budget pre wedding shoot in Pune for ₹9,999: 35 edited photos, all raw photos the next day and 1 candid photographer. Book your date today.',
            'canonical'   => '/pre-wedding-shoot-pune-under-10000/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding Packages', '/pre-wedding-photography-packages/'], ['Budget Under ₹10K', '/pre-wedding-shoot-pune-under-10000/']],
        ]);
    }

    public function preWeddingSatara(): string
    {
        return $this->render('pages/pre-wedding-satara', [
            'title'       => '7 Best Pre Wedding Shoot Locations in Satara (2026)',
            'description' => 'Kaas Plateau, Thoseghar, Vajrai Waterfall, Ajinkyatara Fort and 3 more pre wedding shoot spots in Satara. Best season and prices from ₹14,999.',
            'canonical'   => '/pre-wedding-shoot-satara/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding', '/pre-wedding-shoot-locations-in-pune/'], ['Satara', '/pre-wedding-shoot-satara/']],
        ]);
    }

    public function whenPreWedding(): string
    {
        return $this->render('pages/when-pre-wedding', [
            'title'       => 'Best Time for Pre-Wedding Shoot in Pune: Months & Timing',
            'description' => 'Best time for a pre-wedding shoot in Pune: 3 to 6 months before the wedding, October to February or monsoon July to September, at golden hour.',
            'canonical'   => '/when-to-take-pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['When to Shoot', '/when-to-take-pre-wedding-shoot/']],
        ]);
    }

    public function preWeddingGoa(): string
    {
        return $this->render('pages/pre-wedding-goa', [
            'title'       => 'Pre Wedding Shoot in Goa (2026) | Best Locations & Price',
            'description' => 'Pre wedding shoot locations in Goa: Calangute Beach, Chorla Ghats, Panjim, Bat Island and Mandovi River. Best months November to February. Get a Goa quote.',
            'canonical'   => '/pre-wedding-shoot-locations-in-goa/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding Shoot in Goa', '/pre-wedding-shoot-locations-in-goa/']],
        ]);
    }

    public function preWeddingMumbai(): string
    {
        return $this->render('pages/pre-wedding-mumbai', [
            'title'       => 'Best Pre Wedding Shoot Locations in Mumbai (2026)',
            'description' => 'Best pre wedding shoot locations in Mumbai: Marine Drive, Bandra, Cine City and more, with best timings and tips. Packages from ₹14,999. Plan now.',
           'canonical'  => '/pre-wedding-shoot-locations-mumbai/',
           'breadcrumb' => [['Home', '/'], ['Mumbai', '/mumbai/'], ['Pre-Wedding Mumbai', '/pre-wedding-shoot-locations-mumbai/']],
        ]);
    }

    // ── Wedding ────────────────────────────────────────────────────────
    public function weddingPackages(): string
    {
        return $this->render('pages/wedding-packages', [
            'title'        => 'Wedding Photography Packages in Pune | Price List 2026',
            'description'  => 'Wedding photography packages in Pune from ₹35,000 per day. Compare Gold, Platinum and Diamond: 250 photos, videographer and album. See prices.',
            'canonical'    => '/wedding-photography-packages/',
            'breadcrumb'   => [['Home', '/'], ['Wedding Packages', '/wedding-photography-packages/']],
            'preloadImage' => 'assets/images/wedding-photography-pune.webp',
        ]);
    }

    public function destinationWeddingVenues(): string
    {
        return $this->render('pages/destination-wedding-venues', [
            'title'        => '17 Best Destination Wedding Venues In and Near Pune (2026)',
            'description'  => '17 best destination wedding venues in and near Pune: lawns, resorts, forts and heritage wadas, with photo tips for each. Plan your venue today.',
            'canonical'    => '/best-destination-wedding-venues-pune/',
            'breadcrumb'   => [['Home', '/'], ['Wedding Packages', '/wedding-photography-packages/'], ['Wedding Venue in Pune', '/best-destination-wedding-venues-pune/']],
            'preloadImage' => 'assets/images/dwv-hero.webp',
        ]);
    }

    // ── Engagement & Roka ─────────────────────────────────────────────
    public function engagementPackages(): string
    {
        return $this->render('pages/engagement-packages', [
            'title'       => 'Engagement Photography Packages in Pune | From ₹7,000',
            'description' => 'Engagement, Roka and ring ceremony photography in Pune from ₹7,000. Candid and traditional coverage. Compare packages and book your date.',
            'canonical'   => '/engagement-photography-packages/',
            'breadcrumb'  => [['Home', '/'], ['Engagement', '/engagement-photography-packages/']],
        ]);
    }

    public function rokaPackages(): string
    {
        return $this->render('pages/roka-packages', [
            'title'       => 'Roka & Ring Ceremony Photography in Pune | From ₹7,000',
            'description' => 'Roka, Sakharpuda and ring ceremony photography in Pune from ₹7,000. Candid and traditional coverage, edited photos and video. Call +91 83903 67637.',
            'canonical'   => '/roka-ring-ceremony-photography-pune/',
            'breadcrumb'  => [['Home', '/'], ['Engagement', '/engagement-photography-packages/'], ['Roka Ceremony', '/roka-ring-ceremony-photography-pune/']],
        ]);
    }

    // ── Maternity & Baby ──────────────────────────────────────────────
    public function maternityPhotographer(): string
    {
        return $this->render('pages/maternity-photographer', [
            'title'       => 'Maternity Photoshoot in Pune | Free Gowns, From ₹6,000',
            'description' => 'Maternity photoshoot in Pune with free designer gowns, studio and outdoor options and easy posing help. Packages from ₹6,000. Book your slot today.',
            'canonical'   => '/maternity-photographer-pune/',
            'breadcrumb'  => [['Home', '/'], ['Maternity Photographer Pune', '/maternity-photographer-pune/']],
        ]);
    }

   public function maternityLocations(): string
    {
        return $this->render('pages/maternity-locations', [
            'title'       => 'Best Maternity Shoot Locations in Pune (2026) + Tips',
            'description' => 'Osho Garden, Empress Garden, Pashan Lake, Vetal Tekdi and more: the best maternity shoot spots in Pune with best timings and photo tips.',
            'canonical'   => '/maternity-photoshoot-locations-pune/',
            'breadcrumb'  => [['Home', '/'], ['Maternity', '/maternity-photographer-pune/'], ['Locations', '/maternity-photoshoot-locations-pune/']],
        ]);
    }
    public function babyShowerPackages(): string
    {
        return $this->render('pages/baby-shower', [
            'title'       => 'Baby Shower Photography in Pune | From ₹6,000',
            'description' => 'Baby shower and godh bharai photography in Pune. Candid full event coverage and family portraits. Packages from ₹6,000. Book your date today.',
            'canonical'   => '/baby-shower-photography-packages/',
            'breadcrumb'  => [['Home', '/'], ['Baby Shower Photography', '/baby-shower-photography-packages/']],
        ]);
    }

    public function babyPhotoshoot(): string
    {
        $faqs = [
            ['What is the best age for a baby photoshoot?',
             'The best age for a baby or milestone photoshoot is 6 to 12 months, as babies can sit, smile and play with props naturally. For pre-birthday and cake smash shoots, 11 months is the ideal time.'],
            ['How much does a baby photoshoot cost in Pune?',
             'Newborn photoshoot packages start from Rs 6,000. For baby milestone, cake smash and birthday shoots, contact us for a quote at +91 83903 67637. Prices are the same across Pune &amp; PCMC with no travel charges.'],
            ['Where is your baby photoshoot studio?',
             'Our indoor baby photoshoot studio is in Katraj: Sai Temple, Sacchaimata, Sr.No.40/1B, Near Prathmesh Heights, Narhe Ambegaon Rd, KH, Katraj, Pune, Maharashtra 411046.'],
            ['Do you shoot in the studio or at outdoor locations?',
             'Both. Indoor shoots are done in our theme-based Katraj studio. Outdoor shoots are done at locations across Pune &amp; PCMC, and we carry props and setups with no travel charges.'],
            ['How many photos will we get?',
             'The number of edited photos depends on the package. Our newborn packages include 45 (Gold), 60 (Platinum) or 100+ (Diamond) edited photos.'],
            ['How long does it take to get the photos?',
             'Photos are delivered in 7 to 15 days depending on the package.'],
            ['Do you provide props and dresses?',
             'We provide props only. We don\'t have dresses because of hygiene issues. Parents are asked to bring along baby clothes for the photoshoot'],
            ['How long does a baby photoshoot session take?',
             'A baby photoshoot is performed generally within 3hours depending upon the comfort level, feeding breaks &amp; mood of the baby.'],
            ['Will you create a cake smash setup?',
             'We set up for a cake smash. If parents want us to arrange the cake, they need to either carry it or pay extra for others carrying it.'],
        ];

        $service = [
            '@context'        => 'https://schema.org',
            '@type'           => 'Service',
            'name'            => 'Baby Photoshoot in Pune',
            'serviceType'     => 'Baby Photography',
            'url'             => 'https://thebridal.photography/baby-photoshoot-pune/',
            'provider'        => ['@id' => 'https://thebridal.photography/#business'],
            'areaServed'      => [['@type' => 'City', 'name' => 'Pune'], ['@type' => 'City', 'name' => 'Pimpri-Chinchwad']],
            'hasOfferCatalog' => [
                '@type'           => 'OfferCatalog',
                'name'            => 'Baby Photoshoot Services',
                'itemListElement' => [
                    ['@type' => 'Offer', 'price' => '6000', 'priceCurrency' => 'INR', 'url' => 'https://thebridal.photography/newborn-photography-pune/',
                     'itemOffered' => ['@type' => 'Service', 'name' => 'Newborn Photoshoot']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Baby Milestone Photoshoot']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Cake Smash Photoshoot']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Birthday and Pre-Birthday Photoshoot']],
                ],
            ],
        ];

        return $this->render('pages/baby-photoshoot', [
            'title'       => 'Baby Photoshoot in Pune | From ₹6,000, Studio & Outdoor',
            'description' => 'Milestone, cake smash and birthday baby shoots in Pune. Katraj studio or outdoor, same price across Pune and PCMC. From ₹6,000. Book a slot today.',
            'canonical'   => '/baby-photoshoot-pune/',
            'breadcrumb'  => [['Home', '/'], ['Baby Photoshoot Pune', '/baby-photoshoot-pune/']],
            'faqs'        => $faqs,
            'schemaExtra' => $this->jsonLd($this->faqSchema($faqs)) . $this->jsonLd($service),
        ]);
    }

    // ── Other ──────────────────────────────────────────────────────────
    public function productPhotography(): string
    {
        return $this->render('pages/product-photography', [
            'title'       => 'Product & Fashion Photography in Pune | E-commerce Shoots',
            'description' => 'Amazon, e-commerce, catalogue and fashion lookbook photography in Pune. Clean, sales-ready product photos. Get a free quote: +91 83903 67637.',
            'canonical'   => '/fashion-and-product-photography/',
            'breadcrumb'  => [['Home', '/'], ['Product Photography', '/fashion-and-product-photography/']],
        ]);
    }

    // ── New Destination Pages (Audit Phase 2 URL Renames) ─────────────────

    public function preWeddingMahabaleshwar(): string
    {
        return $this->render('pages/pre-wedding-mahabaleshwar', [
            'title'       => 'Pre Wedding Shoot in Mahabaleshwar | Best Spots & Price',
            'description' => 'Pre wedding shoot in Mahabaleshwar at Arthur\'s Seat, Wilson Point, Venna Lake and Mapro Garden. Best season and tips. From ₹14,999. Book now.',
            'canonical'   => '/pre-wedding-shoot-mahabaleshwar/',
            'breadcrumb'  => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/'], ['Pre-Wedding', '/pre-wedding-shoot-mahabaleshwar/']],
        ]);
    }

    public function preWeddingLonavala(): string
    {
        return $this->render('pages/pre-wedding-lonavala', [
            'title'       => 'Pre Wedding Shoot in Lonavala | Best Spots & Monsoon Tips',
            'description' => 'Pre wedding shoot in Lonavala at Bhushi Dam, Tiger Point and Rajmachi. Best in monsoon, with timings and outfit tips. From ₹14,999. Book today.',
            'canonical'   => '/pre-wedding-shoot-lonavala/',
            'breadcrumb'  => [['Home', '/'], ['Lonavala', '/lonavala/'], ['Pre-Wedding', '/pre-wedding-shoot-lonavala/']],
        ]);
    }

    public function preWeddingMulshi(): string
    {
        return $this->render('pages/pre-wedding-mulshi', [
            'title'       => 'Pre Wedding Shoot at Mulshi Lake | Sunrise Shoots, ₹14,999',
            'description' => 'Pre wedding shoot at Mulshi Lake near Pune: misty sunrise reflections, green hills and quiet roads. Best time and tips. From ₹14,999. Book now.',
            'canonical'   => '/pre-wedding-shoot-mulshi/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding Locations', '/pre-wedding-shoot-locations-in-pune/'], ['Mulshi Lake', '/pre-wedding-shoot-mulshi/']],
        ]);
    }

    public function preWeddingLavasa(): string
    {
        return $this->render('pages/pre-wedding-lavasa', [
            'title'       => 'Pre Wedding Shoot in Lavasa | Best Spots, From ₹14,999',
            'description' => 'Pre wedding shoot in Lavasa, Pune: Italian style lakeside streets, cobbled paths and calm lake views. Best time and spots. From ₹14,999. Book now.',
            'canonical'   => '/pre-wedding-shoot-lavasa/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding Locations', '/pre-wedding-shoot-locations-in-pune/'], ['Lavasa', '/pre-wedding-shoot-lavasa/']],
        ]);
    }

    public function preWeddingLakshadweep(): string
    {
        return $this->render('pages/pre-wedding-lakshadweep', [
            'title'       => 'Pre Wedding Shoot in Lakshadweep | Beach & Lagoon Photos',
            'description' => 'Destination pre wedding shoot in Lakshadweep: clear lagoons, white sand and coral reefs. Best season, travel tips and our Diamond package. Book now.',
            'canonical'   => '/pre-wedding-shoot-lakshadweep/',
            'breadcrumb'  => [['Home', '/'], ['Pre-Wedding Packages', '/pre-wedding-photography-packages/'], ['Lakshadweep', '/pre-wedding-shoot-lakshadweep/']],
        ]);
    }

    public function birthdayPhotography(): string
    {
        return $this->render('pages/birthday-photography', [
            'title'       => 'Birthday Photographer in Pune | From ₹6,000',
            'description' => 'Candid birthday photography in Pune for 1st birthdays, cake smash and surprise parties. Fun, natural photos from ₹6,000. Book your party date now.',
            'canonical'   => '/birthday-photography-pune/',
            'breadcrumb'  => [['Home', '/'], ['Services', '/services/'], ['Birthday Photography', '/birthday-photography-pune/']],
        ]);
    }

    public function newbornPhotography(): string
    {
        $faqs = [
            ['What is the best age for a newborn photoshoot?',
             'The best age for a newborn photoshoot is 5 to 14 days old. At this age babies sleep deeply and curl up naturally, so they can be gently posed in wrapped poses.'],
            ['Is newborn photography safe for my baby?',
             'Yes. Safety always comes first. We use hygienic props and setups, baby-safe posing techniques, a comfortable room temperature, soft fabrics and wraps, and a calm shooting environment.'],
            ['Is the newborn shoot done at home or in the studio?',
             'Newborn sessions are done in our Katraj studio, which is air-conditioned, hygienic and professionally lit. Home newborn shoots are also available across Pune &amp; PCMC.'],
            ['How long does a newborn photoshoot take?',
             'Gold and Platinum newborn sessions take 2 to 3 hours, including feeding and settling breaks. The Diamond package is a full-day session with a cinematic baby film.'],
            ['How much does newborn photography cost in Pune?',
             'Newborn photoshoot packages start from Rs 6,000 (Gold), with Platinum at Rs 8,000 and Diamond at Rs 18,000. A 20% booking amount is paid in advance and the balance 80% on or before the shoot.'],
            ['What should we bring to the newborn shoot?',
             'Please bring feeding supplies, spare diapers and wipes, a warm blanket, a pacifier if the baby uses one, the baby clothes or outfits you want in the photos, and any family keepsakes. Props and wraps are provided by the studio.'],
            ['Can parents join the newborn photoshoot?',
             'Yes, parents can join the newborn session. The Diamond package includes photos with parents &amp; siblings.'],
        ];

        $offer = static fn (string $name, string $price, string $desc): array => [
            '@type' => 'Offer', 'name' => $name, 'price' => $price, 'priceCurrency' => 'INR', 'description' => $desc,
            'url'   => 'https://thebridal.photography/newborn-photography-pune/',
        ];
        $service = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => 'Newborn Photography in Pune',
            'serviceType' => 'Newborn Photography',
            'url'         => 'https://thebridal.photography/newborn-photography-pune/',
            'provider'    => ['@id' => 'https://thebridal.photography/#business'],
            'areaServed'  => [['@type' => 'City', 'name' => 'Pune'], ['@type' => 'City', 'name' => 'Pimpri-Chinchwad']],
            'offers'      => [
                $offer('Gold Newborn Package', '6000', '45 edited photos, 3 themed setups, all props provided, 7-day delivery'),
                $offer('Platinum Newborn Package', '8000', '60 edited photos, specialised props, 5+ themed setups, 10-day delivery'),
                $offer('Diamond Newborn Package', '18000', '100+ edited photos, cinematic baby film, parents & siblings included, 15-day delivery'),
            ],
        ];

        return $this->render('pages/newborn-photography', [
            'title'       => 'Newborn Photography in Pune | Safe Posing, From ₹6,000',
            'description' => 'Newborn photoshoot in Pune, best in the first 14 days. Trained, safe newborn posing at our Katraj studio. From ₹6,000. Book: +91 83903 67637.',
            'canonical'   => '/newborn-photography-pune/',
            'breadcrumb'  => [['Home', '/'], ['Services', '/services/'], ['Newborn Photography', '/newborn-photography-pune/']],
            'faqs'        => $faqs,
            'schemaExtra' => $this->jsonLd($this->faqSchema($faqs)) . $this->jsonLd($service),
        ]);
    }

    public function housewarmingPhotography(): string
    {
        return $this->render('pages/housewarming-photography', [
            'title'       => 'Housewarming Photography in Pune | Griha Pravesh Shoots',
            'description' => 'Griha Pravesh and housewarming photography in Pune. Candid coverage of puja, guests and family portraits. Get a quote: +91 83903 67637.',
            'canonical'   => '/housewarming-photography-pune/',
            'breadcrumb'  => [['Home', '/'], ['Services', '/services/'], ['Housewarming Photography', '/housewarming-photography-pune/']],
        ]);
    }

    // ── Contact ────────────────────────────────────────────────────────
    public function contact(): string
    {
        return $this->render('pages/contact', [
            'title'        => 'Contact The Bridal Photography | Pune, Mumbai, Goa Offices',
            'description'  => 'Call or WhatsApp +91 83903 67637 to book your shoot. Offices in Pune, Mumbai and Goa. Free appointment, quick reply and a clear quote.',
            'canonical'    => '/contact/',
            'breadcrumb'   => [['Home', '/'], ['Contact', '/contact/']],
        ]);
    }

     public function contactSend()
    {
        $rules = [
            'name' => [
                'label'  => 'Full Name',
                'rules'  => 'required|min_length[2]|max_length[255]|regex_match[/^[\p{L}\p{M}\s.\'-]+$/u]',
                'errors' => ['regex_match' => 'The {field} may only contain letters, spaces, dots, apostrophes and hyphens.'],
            ],
            'phone' => [
                'label'  => 'Contact Number',
                'rules'  => 'required|min_length[10]|max_length[15]|regex_match[/^[\d\s\+\-]+$/]',
                'errors' => ['regex_match' => 'Please enter a valid {field}.'],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[255]',
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'permit_empty|max_length[2000]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Derive service/source — use the hidden field if present, else fall back to referer path
        $service = trim((string) $this->request->getPost('service'));
        if ($service === '') {
            $referer = (string) $this->request->getServer('HTTP_REFERER');
            if ($referer !== '') {
                $path = parse_url($referer, PHP_URL_PATH) ?: '/';
                $service = 'Website · ' . $path;
            } else {
                $service = 'Website';
            }
        }

        $data = [
            'name'       => $this->request->getPost('name'),
            'phone'      => $this->request->getPost('phone'),
            'email'      => $this->request->getPost('email'),
            'address'    => $this->request->getPost('address') ?: '',
            'service'    => $service,
            'source'     => 'website',
            'status'     => 'new',
            'ip_address' => $this->request->getIPAddress(),
        ];

        try {
            model('ContactSubmission')->insert($data);
        } catch (\Exception $e) {
            log_message('error', 'Contact submission insert failed: ' . $e->getMessage());
        }

        $sent = $this->sendContactEmail($data);

        // Redirect back to the originating page if possible, otherwise /contact/
        $returnTo = (string) $this->request->getServer('HTTP_REFERER');
        if ($returnTo === '' || strpos($returnTo, base_url()) !== 0) {
            $returnTo = base_url('contact/');
        }

        if ($sent) {
            return redirect()->to($returnTo)
                ->with('success', 'Thank you ' . esc($data['name']) . '! Your enquiry has been received. Our team will contact you within 24 hours.');
        }

        return redirect()->to($returnTo)
            ->with('warning', 'Your enquiry was saved but the confirmation email could not be sent. Our team will still contact you shortly.');
    }

    private function sendContactEmail(array $data): bool
    {
        try {
            $adminEmail = 'thebridal11@gmail.com';
            //  $adminEmail = 'swarupa.kadav@movinnza.in';
            $email = \Config\Services::email();
            $email->setFrom('thebridal11@gmail.com', 'New Enquiry');
            $email->setTo($adminEmail);
            if (! empty($data['email'])) {
                $email->setReplyTo($data['email'], $data['name']);
            }
            $serviceLabel = $data['service'] ?? 'Website';
            $email->setSubject('New Enquiry [' . $serviceLabel . '] from ' . $data['name'] . ' - ' . $data['phone']);

            $labels = [
                'service' => 'Submitted From',
                'name'    => 'Full Name',
                'phone'   => 'Contact Number',
                'email'   => 'Email',
                'address' => 'Address',
            ];

            $body  = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden">';
            $body .= '<div style="background:#1b1b1b;color:#d4a95a;padding:22px"><h2 style="margin:0;font-family:Georgia,serif">New Contact Enquiry</h2><p style="margin:6px 0 0;opacity:.85;color:#fff;font-size:.9rem">Received via The Bridal Photography contact form</p></div>';
            $body .= '<table style="width:100%;border-collapse:collapse">';
            foreach ($labels as $k => $label) {
                $v = $data[$k] ?? '';
                if ($v !== '' && $v !== null) {
                    $body .= '<tr><td style="padding:12px 20px;border-bottom:1px solid #f1f5f9;font-weight:600;width:160px;color:#475569">' . $label . '</td>';
                    $body .= '<td style="padding:12px 20px;border-bottom:1px solid #f1f5f9;color:#0f172a">' . nl2br((string) esc($v)) . '</td></tr>';
                }
            }
            $body .= '</table>';
            $body .= '<div style="background:#f8fafc;padding:14px 28px;font-size:.78rem;color:#94a3b8">Sent from thebridal.photography contact form.</div>';
            $body .= '</div>';

            $email->setMessage($body);
            $email->setMailType('html');

            $result = $email->send(false);
            if (! $result) {
                log_message('error', 'Contact email SMTP error: ' . $email->printDebugger(['headers', 'subject']));
            }
            return (bool) $result;
        } catch (\Exception $e) {
            log_message('error', 'Contact email exception: ' . $e->getMessage());
            return false;
        }
    }

    // ── About Us ───────────────────────────────────────────────────────
    public function aboutUs(): string
    {
        return $this->render('pages/about-us', [
            'title'        => 'About The Bridal Photography | Pune Studio Since 2014',
            'description'  => 'Meet the photographers behind The Bridal Photography. Weddings, pre weddings and maternity shoots in Pune, Mumbai and Goa since 2014. See our story.',
            'canonical'    => '/about-us/',
            'breadcrumb'   => [['Home', '/'], ['About Us', '/about-us/']],
            'preloadImage' => 'assets/images/prewedding-couple-outdoor-pune.webp',
        ]);
    }
}
