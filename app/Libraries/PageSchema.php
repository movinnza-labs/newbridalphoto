<?php

namespace App\Libraries;

/**
 * JSON-LD and social image data for every public page.
 *
 * Developer Points, Oct 2026:
 *  D-01  Organization + WebSite on every page; LocalBusiness only on /, /contact/ and /mumbai/
 *        (no aggregateRating: Google ignores self-serving review stars).
 *  D-02  BreadcrumbList built from the same $breadcrumb array the visible trail uses.
 *  D-03  Service on service, package and city pages (no prices).
 *  D-04  Article on guides, BlogPosting on blog posts, CollectionPage on /blog/.
 *  D-09  og:image = the page's primary image, absolute URL with real size.
 *
 * Page names and images follow Appendix B of the Developer Points PDF.
 */
class PageSchema
{
    public const SITE = 'https://thebridal.photography';

    private const ORG      = self::SITE . '/#organization';
    private const WEBSITE  = self::SITE . '/#website';
    private const BUSINESS = self::SITE . '/#business';

    private const SAME_AS = [
        'https://www.instagram.com/thebridal.photography/',
        'https://www.facebook.com/thebridalphotography',
        'https://www.youtube.com/channel/UCIR4wPINJDXZNhskW12faMA',
    ];

    private const CITY_SERVICES  = 'Wedding, pre wedding and engagement photography';

    /**
     * path => [page type, page name, primary image, extra]
     * extra: ['service' => [serviceType, city]] | ['article' => true] | ['offices' => [...]]
     */
    private const PAGES = [
        '/'                 => ['WebPage', 'Wedding Photographer in Pune', 'hero-prewedding-couple-1.webp', ['offices' => ['pune']]],
        '/about-us/'        => ['AboutPage', 'About Us', 'prewedding-couple-outdoor-pune.webp', []],
        '/services/'        => ['CollectionPage', 'Photography Services', 'svc-wedding.webp', []],
        '/contact/'         => ['ContactPage', 'Contact', 'contact-ornament.webp', ['offices' => ['pune', 'guruwar', 'mumbai', 'goa']]],
        '/faq/'             => ['WebPage', 'Frequently Asked Questions', null, []],
        '/blog/'            => ['CollectionPage', 'Photography Blog', 'assets/images/blog/candid-birthday-hero.webp', []],

        // City hubs
        '/ahilyanagar/'               => ['WebPage', 'Photographers in Ahilyanagar', 'prewedding-couple-outdoor-pune.webp', ['service' => ['Wedding, pre wedding, engagement, maternity and baby photography', 'Ahilyanagar']]],
        '/chhatrapati-sambhajinagar/' => ['WebPage', 'Photographers in Chhatrapati Sambhajinagar', 'mumbai-prewedding-01.webp', ['service' => [self::CITY_SERVICES, 'Chhatrapati Sambhajinagar']]],
        '/lonavala/'                  => ['WebPage', 'Photographers in Lonavala', 'mumbai-prewedding-01.webp', ['service' => [self::CITY_SERVICES, 'Lonavala']]],
        '/mahabaleshwar/'             => ['WebPage', 'Photographers in Mahabaleshwar', 'prewedding-mahabaleshwar.webp', ['service' => [self::CITY_SERVICES, 'Mahabaleshwar']]],
        '/mumbai/'                    => ['WebPage', 'Wedding Photographers in Mumbai', 'mumbai-wedding-card.webp', ['service' => ['Wedding photography', 'Mumbai'], 'offices' => ['mumbai']]],
        '/nashik/'                    => ['WebPage', 'Photographers in Nashik', 'mumbai-prewedding-01.webp', ['service' => [self::CITY_SERVICES, 'Nashik']]],

        // Service and package pages (baby and newborn keep their own Service + FAQPage blocks)
        '/baby-photoshoot-pune/'                => ['WebPage', 'Baby Photoshoot in Pune', 'baby-photoshoot-in-pune.webp', []],
        '/newborn-photography-pune/'            => ['WebPage', 'Newborn Photography in Pune', 'baby-hero.webp', []],
        '/baby-shower-photography-packages/'    => ['WebPage', 'Baby Shower Photography in Pune', 'baby-shower-birthday-photography.webp', ['service' => ['Baby shower photography', 'Pune'], 'offers' => [['Gold Baby Shower Package', '6000'], ['Platinum Baby Shower Package', '18000'], ['Diamond Baby Shower Package', '28000']]]],
        '/birthday-photography-pune/'           => ['WebPage', 'Birthday Photography in Pune', 'baby-hero.webp', ['service' => ['Birthday photography', 'Pune']]],
        '/engagement-photography-packages/'     => ['WebPage', 'Engagement Photography in Pune', 'engagement-photography-pune.webp', ['service' => ['Engagement photography', 'Pune']]],
        '/fashion-and-product-photography/'     => ['WebPage', 'Fashion and Product Photography in Pune', 'fashion-hero-1.webp', ['service' => ['Product photography', 'Pune']]],
        '/housewarming-photography-pune/'       => ['WebPage', 'Housewarming Photography in Pune', 'housewarming-hero.webp', ['service' => ['Event photography', 'Pune']]],
        '/maternity-photographer-pune/'         => ['WebPage', 'Maternity Photography in Pune', 'maternity-photoshoot-pune-banner.webp', ['service' => ['Maternity photography', 'Pune'], 'offers' => [['Gold Maternity Package', '6000'], ['Platinum Maternity Package', '9000'], ['Diamond Maternity Package', '18000']]]],
        '/pre-wedding-photography-packages/'    => ['WebPage', 'Pre Wedding Shoot Packages in Pune', 'prewedding-couple-outdoor-pune.webp', ['service' => ['Pre wedding photography', 'Pune'], 'offers' => [['Gold Pre Wedding Package', '14999'], ['Platinum Pre Wedding Package', '29999'], ['Diamond Pre Wedding Package', '55555']]]],
        '/pre-wedding-shoot-pune-under-10000/'  => ['WebPage', 'Budget Pre Wedding Shoot in Pune', 'prewedding-couple-outdoor-pune.webp', ['service' => ['Pre wedding photography', 'Pune'], 'offers' => [['Budget Pre Wedding Package', '9999']]]],
        '/roka-ring-ceremony-photography-pune/' => ['WebPage', 'Roka and Ring Ceremony Photography in Pune', 'roka-001.webp', ['service' => ['Engagement photography', 'Pune'], 'offers' => [['Gold Roka Package', '7000'], ['Platinum Roka Package', '22000'], ['Diamond Roka Package', '35000']]]],
        '/wedding-films/'                       => ['WebPage', 'Wedding Films in Pune', 'wedding-photography-pune.webp', ['service' => ['Wedding videography', 'Pune']]],
        '/wedding-photography-packages/'        => ['WebPage', 'Wedding Photography in Pune', 'wedding-photography-pune.webp', ['service' => ['Wedding photography', 'Pune']]],

        // City sub pages
        '/ahilyanagar/baby-photoshoot/'               => ['WebPage', 'Baby Photoshoot in Ahilyanagar', 'ahily-baby-1.webp', ['service' => ['Baby photography', 'Ahilyanagar']]],
        '/ahilyanagar/corporate-event-meeting-shoot/' => ['WebPage', 'Corporate Event Photography in Ahilyanagar', 'ahily-corp-hero.webp', ['service' => ['Corporate event photography', 'Ahilyanagar']]],
        '/ahilyanagar/engagement-photographers/'      => ['WebPage', 'Engagement Photographers in Ahilyanagar', 'ahily-eng-1.webp', ['service' => ['Engagement photography', 'Ahilyanagar']]],
        '/ahilyanagar/maternity-photographer/'        => ['WebPage', 'Maternity Photographer in Ahilyanagar', 'ahily-mat-1.webp', ['service' => ['Maternity photography', 'Ahilyanagar']]],
        '/ahilyanagar/pre-wedding-shoot/'             => ['WebPage', 'Pre Wedding Shoot in Ahilyanagar', 'ahily-pw-1.webp', ['service' => ['Pre wedding photography', 'Ahilyanagar']]],
        '/ahilyanagar/wedding-photographers/'         => ['WebPage', 'Wedding Photographers in Ahilyanagar', 'ahily-wed-1.webp', ['service' => ['Wedding photography', 'Ahilyanagar']]],
        '/chhatrapati-sambhajinagar/engagement-photographers/' => ['WebPage', 'Engagement Photographers in Chhatrapati Sambhajinagar', 'mum-engage-1.webp', ['service' => ['Engagement photography', 'Chhatrapati Sambhajinagar']]],
        '/chhatrapati-sambhajinagar/pre-wedding-shoot/'        => ['WebPage', 'Pre Wedding Shoot in Chhatrapati Sambhajinagar', 'mumbai-prewedding-01.webp', ['service' => ['Pre wedding photography', 'Chhatrapati Sambhajinagar']]],
        '/chhatrapati-sambhajinagar/wedding-photographers/'    => ['WebPage', 'Wedding Photographers in Chhatrapati Sambhajinagar', 'mumbai-wp-1.webp', ['service' => ['Wedding photography', 'Chhatrapati Sambhajinagar']]],
        '/lonavala/engagement-photographers/'         => ['WebPage', 'Engagement Photoshoot in Lonavala', 'mum-engage-1.webp', ['service' => ['Engagement photography', 'Lonavala']]],
        '/lonavala/wedding-photographers/'            => ['WebPage', 'Wedding Photographers in Lonavala', 'mumbai-wp-1.webp', ['service' => ['Wedding photography', 'Lonavala']]],
        '/mahabaleshwar/engagement-photographers/'    => ['WebPage', 'Engagement Photographers in Mahabaleshwar', 'mahab-venna.webp', ['service' => ['Engagement photography', 'Mahabaleshwar']]],
        '/mahabaleshwar/wedding-photographers/'       => ['WebPage', 'Wedding Photographers in Mahabaleshwar', 'mahab-weather.webp', ['service' => ['Wedding photography', 'Mahabaleshwar']]],
        '/mumbai/engagement-photography-packages/'    => ['WebPage', 'Engagement Photographers in Mumbai', 'mum-engage-1.webp', ['service' => ['Engagement photography', 'Mumbai']]],
        '/nashik/engagement-photographers/'           => ['WebPage', 'Engagement Photographers in Nashik', 'mum-engage-1.webp', ['service' => ['Engagement photography', 'Nashik']]],
        '/nashik/pre-wedding-shoot/'                  => ['WebPage', 'Pre Wedding Shoot in Nashik', 'mumbai-prewedding-01.webp', ['service' => ['Pre wedding photography', 'Nashik']]],
        '/nashik/wedding-photographers/'              => ['WebPage', 'Wedding Photographers in Nashik', 'mumbai-wp-1.webp', ['service' => ['Wedding photography', 'Nashik']]],

        // Guides (Article)
        '/best-destination-wedding-venues-pune/' => ['WebPage', 'Best Destination Wedding Venues in Pune', 'dwv-hero.webp', ['article' => true]],
        '/maternity-photoshoot-locations-pune/'  => ['WebPage', 'Best Maternity Photoshoot Locations in Pune', 'matloc-banner.webp', ['article' => true]],
        '/pre-wedding-shoot-lakshadweep/'        => ['WebPage', 'Pre Wedding Shoot in Lakshadweep', 'laksha-banner.webp', ['article' => true]],
        '/pre-wedding-shoot-lavasa/'             => ['WebPage', 'Pre Wedding Shoot in Lavasa', 'lavasa-hero.webp', ['article' => true]],
        '/pre-wedding-shoot-locations-in-goa/'   => ['WebPage', 'Pre Wedding Shoot Locations in Goa', 'goa-intro.webp', ['article' => true]],
        '/pre-wedding-shoot-locations-in-pune/'  => ['WebPage', '18 Best Pre Wedding Shoot Locations in Pune', 'pw-hero-shoot.webp', ['article' => true]],
        '/pre-wedding-shoot-locations-mumbai/'   => ['WebPage', 'Best Pre Wedding Shoot Locations in Mumbai', 'prewedding-mumbai-locations.webp', ['article' => true]],
        '/pre-wedding-shoot-lonavala/'           => ['WebPage', 'Pre Wedding Shoot in Lonavala', 'prewedding-satara.webp', ['article' => true]],
        '/pre-wedding-shoot-mahabaleshwar/'      => ['WebPage', 'Pre Wedding Shoot in Mahabaleshwar', 'mahab-weather.webp', ['article' => true]],
        '/pre-wedding-shoot-mulshi/'             => ['WebPage', 'Pre Wedding Shoot at Mulshi Lake', 'mulshi-hero.webp', ['article' => true]],
        '/pre-wedding-shoot-satara/'             => ['WebPage', '7 Best Pre Wedding Shoot Locations in Satara', 'satara-hero.webp', ['article' => true]],
        '/when-to-take-pre-wedding-shoot/'       => ['WebPage', 'When Should You Do Your Pre-Wedding Shoot?', 'when-lavasa.webp', ['article' => true]],
    ];

    /** Offices (Appendix A2). Hours left out until the client confirms them. */
    private const OFFICES = [
        'pune' => [
            '@id' => self::BUSINESS, 'name' => 'The Bridal Photography', 'url' => self::SITE . '/',
            'image' => 'hero-prewedding-couple-1.webp', 'logo' => true,
            'telephone' => '+91-8390367637', 'email' => 'thebridal11@gmail.com',
            'priceRange' => '₹6,000 to ₹75,000',
            'address' => ['Sai Temple, Sacchaimata, Sr.No.40/1B, Near Prathmesh Heights, Narhe Ambegaon Rd, Katraj', 'Pune', 'Maharashtra', '411046'],
            'areaServed' => ['Pune', 'Pimpri-Chinchwad'], 'sameAs' => true,
        ],
        'guruwar' => [
            '@id' => self::SITE . '/#pune-guruwar-peth', 'name' => 'The Bridal Photography, Guruwar Peth', 'url' => self::SITE . '/contact/',
            'image' => 'hero-prewedding-couple-1.webp', 'telephone' => '+91-8390367637',
            'address' => ['Shriram Soc, 858/61, Guruwar Peth', 'Pune', 'Maharashtra', '411042'],
        ],
        'mumbai' => [
            '@id' => self::SITE . '/#mumbai', 'name' => 'The Bridal Photography, Mumbai', 'url' => self::SITE . '/mumbai/',
            'image' => 'mumbai-wedding-card.webp', 'telephone' => '+91-8806225566',
            'address' => ['1st Floor, Modi House, Off Link Rd, near Fun Republic Road, Andheri West', 'Mumbai', 'Maharashtra', '400053'],
        ],
        'goa' => [
            '@id' => self::SITE . '/#goa', 'name' => 'The Bridal Photography, Goa', 'url' => self::SITE . '/pre-wedding-shoot-locations-in-goa/',
            'image' => 'goa-intro.webp', 'telephone' => '+91-7796225566',
            'address' => ['Second Floor, Prema Building, Fontainhas, Patto Colony', 'Panaji', 'Goa', '403001'],
        ],
    ];

    /** Absolute URL of an image under assets/images/ (or a site-relative / absolute path). */
    public static function imageUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
        $path = ltrim($path, '/');
        if (! str_contains($path, '/')) {
            $path = 'assets/images/' . $path;
        }

        return self::SITE . '/' . $path;
    }

    /** Primary image of a page as an absolute URL (null if the page has none). */
    public static function primaryImage(string $canonical, ?array $post = null): ?string
    {
        if ($post !== null) {
            return self::imageUrl($post['og_image'] ?: ($post['featured_image'] ?? null));
        }

        return self::imageUrl(self::PAGES[$canonical][2] ?? null);
    }

    /** [width, height] of an image on this site, read from disk; null if unknown. */
    public static function imageSize(?string $url): ?array
    {
        if ($url === null || ! str_starts_with($url, self::SITE . '/')) {
            return null;
        }
        $file = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, substr($url, strlen(self::SITE) + 1));
        $size = is_file($file) ? @getimagesize($file) : false;

        return $size ? [$size[0], $size[1]] : null;
    }

    /**
     * Sitewide block (Appendix A1): Organization + WebSite.
     */
    public static function sitewide(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph'   => [
                [
                    '@type'     => 'Organization',
                    '@id'       => self::ORG,
                    'name'      => 'The Bridal Photography',
                    'url'       => self::SITE . '/',
                    'logo'      => ['@type' => 'ImageObject', 'url' => self::SITE . '/assets/images/logo.png'],
                    'email'     => 'thebridal11@gmail.com',
                    'telephone' => '+91-8390367637',
                    'sameAs'    => self::SAME_AS,
                ],
                [
                    '@type'      => 'WebSite',
                    '@id'        => self::WEBSITE,
                    'url'        => self::SITE . '/',
                    'name'       => 'The Bridal Photography',
                    'publisher'  => ['@id' => self::ORG],
                    'inLanguage' => 'en-IN',
                ],
            ],
        ];
    }

    /**
     * Page block (Appendix B). Returns null for pages not in the map.
     *
     * @param string     $canonical  site-relative path with trailing slash
     * @param array|null $breadcrumb [[label, url], ...] as passed to partials/breadcrumb
     * @param array|null $post       blog post row (blog detail pages)
     */
    public static function page(string $canonical, ?array $breadcrumb = null, ?array $post = null): ?array
    {
        $url = self::SITE . $canonical;

        if ($post !== null) {
            $name  = html_entity_decode((string) $post['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $page  = ['WebPage', $name, $post['featured_image'] ?? null, ['blogposting' => true]];
        } elseif (isset(self::PAGES[$canonical])) {
            $page = self::PAGES[$canonical];
        } else {
            return null;
        }

        [$type, $name, $image, $extra] = $page;
        $imageUrl = self::imageUrl($image);
        $graph    = [];

        $webPage = [
            '@type'    => $type,
            '@id'      => $url . '#webpage',
            'url'      => $url,
            'name'     => $name,
            'isPartOf' => ['@id' => self::WEBSITE],
        ];
        if ($imageUrl) {
            $webPage['primaryImageOfPage'] = ['@type' => 'ImageObject', 'url' => $imageUrl];
        }
        if ($canonical === '/') {
            $webPage['about'] = ['@id' => self::ORG];
        }

        $crumbs = self::breadcrumbList($url, $breadcrumb);
        if ($crumbs) {
            $webPage['breadcrumb'] = ['@id' => $crumbs['@id']];
        }
        $graph[] = $webPage;
        if ($crumbs) {
            $graph[] = $crumbs;
        }

        foreach ($extra['offices'] ?? [] as $office) {
            $graph[] = self::office($office);
        }

        if (isset($extra['service'])) {
            [$serviceType, $city] = $extra['service'];
            $service = [
                '@type'       => 'Service',
                '@id'         => $url . '#service',
                'name'        => $name,
                'serviceType' => $serviceType,
                'provider'    => ['@id' => self::BUSINESS],
                'areaServed'  => ['@type' => 'City', 'name' => $city],
                'url'         => $url,
            ];
            if ($imageUrl) {
                $service['image'] = $imageUrl;
            }
            // SEO audit 23 Oct 2026: package pages list their prices as Offers
            if (! empty($extra['offers'])) {
                $service['offers'] = array_map(static fn (array $o): array => [
                    '@type'         => 'Offer',
                    'name'          => $o[0],
                    'price'         => $o[1],
                    'priceCurrency' => 'INR',
                    'url'           => $url,
                ], $extra['offers']);
            }
            $graph[] = $service;
        }

        if (! empty($extra['article']) || ! empty($extra['blogposting'])) {
            $article = [
                '@type'    => empty($extra['blogposting']) ? 'Article' : 'BlogPosting',
                '@id'      => $url . '#article',
                'headline' => $name,
            ];
            if ($imageUrl) {
                $article['image'] = [$imageUrl];
            }
            if ($post !== null) {
                if (! empty($post['published_at'])) {
                    $article['datePublished'] = date('Y-m-d', strtotime($post['published_at']));
                }
                if (! empty($post['updated_at']) && strtotime($post['updated_at']) > strtotime($post['published_at'] ?? '1970-01-01')) {
                    $article['dateModified'] = date('Y-m-d', strtotime($post['updated_at']));
                }
            }
            $article['author']           = ['@id' => self::ORG];
            $article['publisher']        = ['@id' => self::ORG];
            $article['mainEntityOfPage'] = ['@id' => $url . '#webpage'];
            $graph[] = $article;
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    /** BreadcrumbList from the visible trail; the last crumb has no item URL. */
    private static function breadcrumbList(string $url, ?array $breadcrumb): ?array
    {
        if (empty($breadcrumb) || count($breadcrumb) < 2) {
            return null;
        }
        $items = [];
        $last  = count($breadcrumb) - 1;
        foreach (array_values($breadcrumb) as $i => [$label, $path]) {
            $item = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => html_entity_decode((string) $label, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            ];
            if ($i < $last) {
                $item['item'] = self::SITE . '/' . ltrim((string) $path, '/');
            }
            $items[] = $item;
        }

        return [
            '@type'           => 'BreadcrumbList',
            '@id'             => $url . '#breadcrumb',
            'itemListElement' => $items,
        ];
    }

    private static function office(string $key): array
    {
        $o = self::OFFICES[$key];
        [$street, $locality, $region, $postcode] = $o['address'];

        $block = [
            '@type'              => 'LocalBusiness',
            '@id'                => $o['@id'],
            'name'               => $o['name'],
            'parentOrganization' => ['@id' => self::ORG],
            'url'                => $o['url'],
            'image'              => self::imageUrl($o['image']),
        ];
        if (! empty($o['logo'])) {
            $block['logo'] = self::SITE . '/assets/images/logo.png';
        }
        $block['telephone'] = $o['telephone'];
        if (isset($o['email'])) {
            $block['email'] = $o['email'];
        }
        if (isset($o['priceRange'])) {
            $block['priceRange'] = $o['priceRange'];
        }
        $block['address'] = [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $street,
            'addressLocality' => $locality,
            'addressRegion'   => $region,
            'postalCode'      => $postcode,
            'addressCountry'  => 'IN',
        ];
        if (isset($o['areaServed'])) {
            $block['areaServed'] = $o['areaServed'];
        }
        if (! empty($o['sameAs'])) {
            $block['sameAs'] = self::SAME_AS;
        }

        return $block;
    }

    /** True for guide pages (Article) and blog posts, so og:type can be "article". */
    public static function isArticle(string $canonical, ?array $post = null): bool
    {
        return $post !== null || ! empty(self::PAGES[$canonical][3]['article']);
    }

    /**
     * FAQPage JSON-LD from the same [[question, answer], ...] array a view renders,
     * so the schema always matches the visible FAQ. Call it right after the FAQ loop.
     */
    public static function faqScript(array $faqs): string
    {
        $plain = static fn (string $s): string => trim(html_entity_decode(strip_tags($s), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        return self::script([
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(static fn (array $f): array => [
                '@type'          => 'Question',
                'name'           => $plain($f[0]),
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $plain($f[1])],
            ], array_values($faqs)),
        ]);
    }

    /** <script type="application/ld+json"> tag for a schema array. */
    public static function script(array $data): string
    {
        return '<script type="application/ld+json">' . "\n"
            . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT)
            . "\n</script>\n";
    }
}
