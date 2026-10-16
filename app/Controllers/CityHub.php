<?php

namespace App\Controllers;

class CityHub extends BaseController
{
    private function render(string $view, array $data): string
    {
        return view('layouts/main', $data + ['view' => $view]);
    }

    // ── Mumbai ────────────────────────────────────────────────────────
    public function mumbai(): string
    {
        return $this->render('pages/city/mumbai', [
            'title'        => 'Wedding Photographers in Mumbai | The Bridal Photography',
            'description'  => 'Wedding photographers in Mumbai for candid, traditional and cinematic weddings, plus engagement and pre wedding shoots. Call +91 83903 67637.',
            'canonical'    => '/mumbai/',
            'breadcrumb'   => [['Home', '/'], ['Mumbai', '/mumbai/']],
            'preloadImage' => 'assets/images/mumbai-wedding-card.webp',
        ]);
    }

    public function mumbaiEngagement(): string
    {
        return $this->render('pages/city/mumbai-engagement', [
            'title'       => 'Engagement Photographers Mumbai | The Bridal Photography',
            'description' => 'Professional engagement photography in Mumbai from ₹7,000. All venues & neighbourhoods. Book: +91 83903 67637.',
            'canonical'   => '/mumbai/engagement-photography-packages/',
            'breadcrumb'  => [['Home', '/'], ['Mumbai', '/mumbai/'], ['Engagement Mumbai', '/mumbai/engagement-photography-packages/']],
        ]);
    }

    public function mumbaiPreWedding(): string
    {
        return $this->render('pages/city/mumbai-prewedding', [
            'title'       => 'Pre-Wedding Shoot in Mumbai | Locations & Packages | The Bridal Photography',
            'description' => 'Pre-wedding shoot in Mumbai — Marine Drive, Bandra, Film City. Packages from ₹14,999. Book: +91 83903 67637.',
            'canonical'   => '/mumbai/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Mumbai', '/mumbai/'], ['Pre-Wedding Mumbai', '/mumbai/pre-wedding-shoot/']],
        ]);
    }

    public function mumbaiWedding(): string
    {
        return $this->render('pages/city/mumbai-wedding', [
            'title'       => 'Wedding Photographers in Mumbai | The Bridal Photography',
            'description' => 'Best wedding photographers in Mumbai. Candid & traditional. 4.9★. From ₹35,000/day. Book: +91 83903 67637.',
            'canonical'   => '/mumbai/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Mumbai', '/mumbai/'], ['Wedding Mumbai', '/mumbai/wedding-photographers/']],
        ]);
    }

    // ── Ahilyanagar ───────────────────────────────────────────────────
    public function ahilyanagar(): string
    {
        return $this->render('pages/city/ahilyanagar', [
            'title'       => 'Photographers in Ahilyanagar | The Bridal Photography',
            'description' => 'Photographers in Ahilyanagar for wedding, pre wedding, engagement, maternity and baby shoots. 4.9 stars. Call +91 83903 67637.',
            'canonical'   => '/ahilyanagar/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/']],
        ]);
    }

    public function ahilyanagaPreWedding(): string
    {
        return $this->render('pages/city/ahilyanagar-prewedding', [
            'title'       => 'Pre Wedding Shoot in Ahilyanagar | The Bridal',
            'description' => 'Pre wedding shoot in Ahilyanagar at Ahmednagar Fort, Bhandardara Lake and more. Packages from Rs 14,999. Book: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Pre-Wedding', '/ahilyanagar/pre-wedding-shoot/']],
        ]);
    }

    public function ahilyanagaWedding(): string
    {
        return $this->render('pages/city/ahilyanagar-wedding', [
            'title'       => 'Wedding Photographers in Ahilyanagar | Candid & Traditional | The Bridal',
            'description' => 'Best wedding photographers in Ahilyanagar. 4.9★ rated. Packages from ₹35,000/day. Book: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Wedding', '/ahilyanagar/wedding-photographers/']],
        ]);
    }

    public function ahilyanagaEngagement(): string
    {
        return $this->render('pages/city/ahilyanagar-engagement', [
            'title'       => 'Engagement Photographers in Ahilyanagar | Roka & Ring Ceremony | The Bridal',
            'description' => 'Professional engagement & Roka photography in Ahilyanagar from ₹7,000. Book: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Engagement', '/ahilyanagar/engagement-photographers/']],
        ]);
    }

    public function ahilyanagaMaternity(): string
    {
        return $this->render('pages/city/ahilyanagar-maternity', [
            'title'       => 'Maternity Photographer in Ahilyanagar | The Bridal',
            'description' => 'Professional maternity photographer in Ahilyanagar. Designer gowns provided. From ₹6,000. Book: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/maternity-photographer/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Maternity', '/ahilyanagar/maternity-photographer/']],
        ]);
    }

    public function ahilyanagaBaby(): string
    {
        return $this->render('pages/city/ahilyanagar-baby', [
            'title'       => 'Baby Photoshoot in Ahilyanagar | Newborn & Baby Photography | The Bridal',
            'description' => 'Professional baby & newborn photography in Ahilyanagar. Safe, gentle, beautifully lit. From ₹6,000. Book: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/baby-photoshoot/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Baby Photoshoot', '/ahilyanagar/baby-photoshoot/']],
        ]);
    }

    public function ahilyanagaCorporate(): string
    {
        return $this->render('pages/city/ahilyanagar-corporate', [
            'title'       => 'Corporate Event Photography in Ahilyanagar | The Bridal Photography',
            'description' => 'Professional corporate event & meeting photography in Ahilyanagar. 24-hr delivery. Get a quote: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/corporate-event-meeting-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Corporate Events', '/ahilyanagar/corporate-event-meeting-shoot/']],
        ]);
    }

    // ── Mahabaleshwar ─────────────────────────────────────────────────
    public function mahabaleshwar(): string
    {
        return $this->render('pages/city/mahabaleshwar/index', [
            'title'        => 'Photographers in Mahabaleshwar | The Bridal Photography',
            'description'  => 'Photographers in Mahabaleshwar for weddings, pre wedding and engagement shoots at Arthur Seat, Wilson Point and Venna Lake. Call +91 83903 67637.',
            'canonical'    => '/mahabaleshwar/',
            'breadcrumb'   => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/']],
            'preloadImage' => 'assets/images/prewedding-mahabaleshwar.webp',
        ]);
    }

    public function mahabaleshwarWedding(): string
    {
        return $this->render('pages/city/mahabaleshwar/wedding', [
            'title'       => 'Wedding Photographer in Mahabaleshwar | The Bridal Photography',
            'description' => 'Best wedding photographers in Mahabaleshwar for hill-station & resort weddings. Candid, cinematic & traditional. Book: +91 83903 67637.',
            'canonical'   => '/mahabaleshwar/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/'], ['Wedding', '/mahabaleshwar/wedding-photographers/']],
        ]);
    }

    public function mahabaleshwarPreWedding(): string
    {
        return $this->render('pages/city/mahabaleshwar/prewedding', [
            'title'       => 'Pre Wedding Shoot Mahabaleshwar | Best Locations & Packages | The Bridal Photography',
            'description' => 'Pre wedding shoot in Mahabaleshwar. Arthur Seat, Wilson Point, Mapro Garden & more. Cinematic storytelling. Book: +91 83903 67637.',
            'canonical'   => '/mahabaleshwar/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/'], ['Pre-Wedding', '/mahabaleshwar/pre-wedding-shoot/']],
        ]);
    }

    public function mahabaleshwarEngagement(): string
    {
        return $this->render('pages/city/mahabaleshwar/engagement', [
            'title'       => 'Engagement Photographers in Mahabaleshwar | The Bridal Photography',
            'description' => 'Top engagement photographers in Mahabaleshwar. Arthur Seat, Wilson Point, Venna Lake & more. Book: +91 83903 67637.',
            'canonical'   => '/mahabaleshwar/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/'], ['Engagement', '/mahabaleshwar/engagement-photographers/']],
        ]);
    }

    // ── Lonavala ──────────────────────────────────────────────────────
    public function lonavala(): string
    {
        return $this->render('pages/city/lonavala/index', [
            'title'        => 'Photographers in Lonavala | The Bridal Photography',
            'description'  => 'Photographers in Lonavala for weddings, pre wedding and engagement shoots at Tiger Point, Pawna Lake and Bhushi Dam. Call +91 83903 67637.',
            'canonical'    => '/lonavala/',
            'breadcrumb'   => [['Home', '/'], ['Lonavala', '/lonavala/']],
            'preloadImage' => 'assets/images/mumbai-prewedding-01.webp',
        ]);
    }

    public function lonavalaWedding(): string
    {
        return $this->render('pages/city/lonavala/wedding', [
            'title'       => 'Wedding Photoshoot in Lonavala | The Bridal Photography',
            'description' => 'Best wedding photographers in Lonavala for destination & resort weddings. Candid, cinematic & traditional. Book: +91 83903 67637.',
            'canonical'   => '/lonavala/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Lonavala', '/lonavala/'], ['Wedding', '/lonavala/wedding-photographers/']],
        ]);
    }

    public function lonavalaPreWedding(): string
    {
        return $this->render('pages/city/lonavala/prewedding', [
            'title'       => 'Lonavala Pre-Wedding Shoot | Best Locations & Packages | The Bridal Photography',
            'description' => 'Pre-wedding shoot in Lonavala. Lion\'s Point, Rajmachi Point, Bhushi Dam & more. Cinematic storytelling. Book: +91 83903 67637.',
            'canonical'   => '/lonavala/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Lonavala', '/lonavala/'], ['Pre-Wedding', '/lonavala/pre-wedding-shoot/']],
        ]);
    }

    public function lonavalaEngagement(): string
    {
        return $this->render('pages/city/lonavala/engagement', [
            'title'       => 'Engagement Photoshoot in Lonavala | The Bridal Photography',
            'description' => 'Top engagement photographers in Lonavala. Scenic hill points, resorts, valley roads & heritage spots. Book: +91 83903 67637.',
            'canonical'   => '/lonavala/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Lonavala', '/lonavala/'], ['Engagement', '/lonavala/engagement-photographers/']],
        ]);
    }

    // ── Nashik ────────────────────────────────────────────────────────
    public function nashik(): string
    {
        return $this->render('pages/city/nashik/index', [
            'title'        => 'Photographers in Nashik | The Bridal Photography',
            'description'  => 'Photographers in Nashik for weddings, pre wedding and engagement shoots at Sula Vineyards, Anjneri Hill and Gangapur Dam. Call +91 83903 67637.',
            'canonical'    => '/nashik/',
            'breadcrumb'   => [['Home', '/'], ['Nashik', '/nashik/']],
            'preloadImage' => 'assets/images/mumbai-prewedding-01.webp',
        ]);
    }

    public function nashikWedding(): string
    {
        return $this->render('pages/city/nashik/wedding', [
            'title'       => 'Wedding Photographers in Nashik | The Bridal Photography',
            'description' => 'Best wedding photographers in Nashik for vineyard & resort weddings. Candid, cinematic & traditional. Book: +91 83903 67637.',
            'canonical'   => '/nashik/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Nashik', '/nashik/'], ['Wedding', '/nashik/wedding-photographers/']],
        ]);
    }

    public function nashikPreWedding(): string
    {
        return $this->render('pages/city/nashik/prewedding', [
            'title'       => 'Pre Wedding Shoot in Nashik | The Bridal Photography',
            'description' => 'Pre wedding shoot in Nashik at Sula Vineyards, Pandavleni Caves, Gangapur Dam and more. Cinematic couple shoots. Book: +91 83903 67637.',
            'canonical'   => '/nashik/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Nashik', '/nashik/'], ['Pre-Wedding', '/nashik/pre-wedding-shoot/']],
        ]);
    }

    public function nashikEngagement(): string
    {
        return $this->render('pages/city/nashik/engagement', [
            'title'       => 'Engagement Photographers in Nashik | The Bridal Photography',
            'description' => 'Top engagement photographers in Nashik. Sula Vineyards, Pandavleni Caves, Gangapur Dam & more. Book: +91 83903 67637.',
            'canonical'   => '/nashik/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Nashik', '/nashik/'], ['Engagement', '/nashik/engagement-photographers/']],
        ]);
    }

    // ── Chhatrapati Sambhajinagar ─────────────────────────────────────
    public function sambhajinagar(): string
    {
        return $this->render('pages/city/sambhajinagar/index', [
            'title'        => 'Photographers in Chhatrapati Sambhajinagar | The Bridal',
            'description'  => 'Photographers in Chhatrapati Sambhajinagar for weddings, pre wedding, engagement and corporate shoots. Heritage and candid. Call +91 83903 67637.',
            'canonical'    => '/chhatrapati-sambhajinagar/',
            'breadcrumb'   => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/']],
            'preloadImage' => 'assets/images/mumbai-prewedding-01.webp',
        ]);
    }

    public function sambhajinagarWedding(): string
    {
        return $this->render('pages/city/sambhajinagar/wedding', [
            'title'       => 'Wedding Photographer in Chhatrapati Sambhajinagar | The Bridal Photography',
            'description' => 'Best wedding photographers in Chhatrapati Sambhajinagar. Candid, cinematic & traditional. Bibi Ka Maqbara, Daulatabad Fort & more. Book: +91 83903 67637.',
            'canonical'   => '/chhatrapati-sambhajinagar/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/'], ['Wedding', '/chhatrapati-sambhajinagar/wedding-photographers/']],
        ]);
    }

    public function sambhajinagarPreWedding(): string
    {
        return $this->render('pages/city/sambhajinagar/prewedding', [
            'title'       => 'Pre Wedding Shoot in Chhatrapati Sambhajinagar',
            'description' => 'Pre wedding shoot in Chhatrapati Sambhajinagar at heritage, garden and city locations. Cinematic couple shoots. Book: +91 83903 67637.',
            'canonical'   => '/chhatrapati-sambhajinagar/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/'], ['Pre-Wedding', '/chhatrapati-sambhajinagar/pre-wedding-shoot/']],
        ]);
    }

    public function sambhajinagarEngagement(): string
    {
        return $this->render('pages/city/sambhajinagar/engagement', [
            'title'       => 'Engagement Photographers in Chhatrapati Sambhajinagar | The Bridal Photography',
            'description' => 'Top engagement photographers in Chhatrapati Sambhajinagar. Bibi Ka Maqbara, Daulatabad Fort, Ellora Caves & more. Book: +91 83903 67637.',
            'canonical'   => '/chhatrapati-sambhajinagar/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/'], ['Engagement', '/chhatrapati-sambhajinagar/engagement-photographers/']],
        ]);
    }
}
