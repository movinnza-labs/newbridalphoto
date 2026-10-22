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
            'title'        => 'Wedding Photographers in Mumbai | Candid & Cinematic',
            'description'  => 'Candid, traditional and cinematic wedding photographers in Mumbai. Full day coverage, albums and wedding films. Check your date: +91 83903 67637.',
            'canonical'    => '/mumbai/',
            'breadcrumb'   => [['Home', '/'], ['Mumbai', '/mumbai/']],
            'preloadImage' => 'assets/images/mumbai-wedding-card.webp',
        ]);
    }

    public function mumbaiEngagement(): string
    {
        return $this->render('pages/city/mumbai-engagement', [
            'title'       => 'Engagement Photographers in Mumbai | From ₹7,000',
            'description' => 'Engagement photoshoot in Mumbai at Marine Drive, Juhu, Bandra and more. Candid, natural couple photos. Packages from ₹7,000. Book today.',
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
            'title'       => 'Photographers in Ahilyanagar | Wedding, Pre Wedding & More',
            'description' => 'Wedding, pre wedding, engagement, maternity and baby photographers in Ahilyanagar. Local shoot spots, candid style, clear packages. Call +91 83903 67637.',
            'canonical'   => '/ahilyanagar/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/']],
        ]);
    }

    public function ahilyanagaPreWedding(): string
    {
        return $this->render('pages/city/ahilyanagar-prewedding', [
            'title'       => 'Pre Wedding Shoot in Ahilyanagar | From ₹14,999',
            'description' => 'Pre wedding shoot in Ahilyanagar at Ahmednagar Fort, Bhandardara Lake and more. Candid, cinematic couple photos. Packages from ₹14,999. Book now.',
            'canonical'   => '/ahilyanagar/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Pre-Wedding', '/ahilyanagar/pre-wedding-shoot/']],
        ]);
    }

    public function ahilyanagaWedding(): string
    {
        return $this->render('pages/city/ahilyanagar-wedding', [
            'title'       => 'Wedding Photographers in Ahilyanagar | From ₹35,000/Day',
            'description' => 'Candid and traditional wedding photography in Ahilyanagar. Full day coverage, albums and films. Packages from ₹35,000 per day. Check your date now.',
            'canonical'   => '/ahilyanagar/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Wedding', '/ahilyanagar/wedding-photographers/']],
        ]);
    }

    public function ahilyanagaEngagement(): string
    {
        return $this->render('pages/city/ahilyanagar-engagement', [
            'title'       => 'Engagement Photographers in Ahilyanagar | From ₹7,000',
            'description' => 'Candid engagement, Roka and ring ceremony photography in Ahilyanagar. Natural moments and family portraits. Packages from ₹7,000. Book today.',
            'canonical'   => '/ahilyanagar/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Engagement', '/ahilyanagar/engagement-photographers/']],
        ]);
    }

    public function ahilyanagaMaternity(): string
    {
        return $this->render('pages/city/ahilyanagar-maternity', [
            'title'       => 'Maternity Photographer in Ahilyanagar | From ₹6,000',
            'description' => 'Maternity photoshoot in Ahilyanagar with studio and outdoor options and easy posing help. Packages from ₹6,000. Book: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/maternity-photographer/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Maternity', '/ahilyanagar/maternity-photographer/']],
        ]);
    }

    public function ahilyanagaBaby(): string
    {
        return $this->render('pages/city/ahilyanagar-baby', [
            'title'       => 'Baby Photoshoot in Ahilyanagar | From ₹6,000',
            'description' => 'Safe, gentle baby and newborn photoshoot in Ahilyanagar with props and soft light. Packages from ₹6,000. Book your slot: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/baby-photoshoot/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Baby Photoshoot', '/ahilyanagar/baby-photoshoot/']],
        ]);
    }

    public function ahilyanagaCorporate(): string
    {
        return $this->render('pages/city/ahilyanagar-corporate', [
            'title'       => 'Corporate Event Photographer in Ahilyanagar | Fast Delivery',
            'description' => 'Corporate event, meeting and industrial photography in Ahilyanagar. Pro team, sharp edits and fast delivery. Get a free quote: +91 83903 67637.',
            'canonical'   => '/ahilyanagar/corporate-event-meeting-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Ahilyanagar', '/ahilyanagar/'], ['Corporate Events', '/ahilyanagar/corporate-event-meeting-shoot/']],
        ]);
    }

    // ── Mahabaleshwar ─────────────────────────────────────────────────
    public function mahabaleshwar(): string
    {
        return $this->render('pages/city/mahabaleshwar/index', [
            'title'        => 'Photographers in Mahabaleshwar | Wedding & Pre Wedding',
            'description'  => 'Wedding, pre wedding and engagement photographers in Mahabaleshwar. Shoots at Arthur\'s Seat, Wilson Point and Venna Lake. Book: +91 83903 67637.',
            'canonical'    => '/mahabaleshwar/',
            'breadcrumb'   => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/']],
            'preloadImage' => 'assets/images/prewedding-mahabaleshwar.webp',
        ]);
    }

    public function mahabaleshwarWedding(): string
    {
        return $this->render('pages/city/mahabaleshwar/wedding', [
            'title'       => 'Wedding Photographers in Mahabaleshwar | Resort Weddings',
            'description' => 'Candid, cinematic and traditional photography for Mahabaleshwar hill station and resort weddings. Full day coverage. Check your date today.',
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
            'title'       => 'Engagement Photographers in Mahabaleshwar | Hill Shoots',
            'description' => 'Engagement photoshoot in Mahabaleshwar at Arthur\'s Seat, Wilson Point and Venna Lake. Candid, natural couple photos. Book: +91 83903 67637.',
            'canonical'   => '/mahabaleshwar/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Mahabaleshwar', '/mahabaleshwar/'], ['Engagement', '/mahabaleshwar/engagement-photographers/']],
        ]);
    }

    // ── Lonavala ──────────────────────────────────────────────────────
    public function lonavala(): string
    {
        return $this->render('pages/city/lonavala/index', [
            'title'        => 'Photographers in Lonavala | Wedding & Pre Wedding Shoots',
            'description'  => 'Wedding, pre wedding and engagement photographers in Lonavala. Shoots at Tiger Point, Pawna Lake and Bhushi Dam. Check dates: +91 83903 67637.',
            'canonical'    => '/lonavala/',
            'breadcrumb'   => [['Home', '/'], ['Lonavala', '/lonavala/']],
            'preloadImage' => 'assets/images/mumbai-prewedding-01.webp',
        ]);
    }

    public function lonavalaWedding(): string
    {
        return $this->render('pages/city/lonavala/wedding', [
            'title'       => 'Wedding Photographers in Lonavala | Resort Weddings',
            'description' => 'Candid, cinematic and traditional photography for Lonavala resort and destination weddings. Full day coverage, albums and films. Check your date today.',
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
            'title'       => 'Engagement Photographers in Lonavala | Hill & Resort Shoots',
            'description' => 'Engagement photoshoot in Lonavala at hill points, resorts and valley roads. Candid, natural couple photos. See packages and book: +91 83903 67637.',
            'canonical'   => '/lonavala/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Lonavala', '/lonavala/'], ['Engagement', '/lonavala/engagement-photographers/']],
        ]);
    }

    // ── Nashik ────────────────────────────────────────────────────────
    public function nashik(): string
    {
        return $this->render('pages/city/nashik/index', [
            'title'        => 'Photographers in Nashik | Vineyard Weddings & Pre Wedding',
            'description'  => 'Wedding, pre wedding and engagement photographers in Nashik. Shoots at Sula Vineyards, Anjaneri Hill and Gangapur Dam. Book: +91 83903 67637.',
            'canonical'    => '/nashik/',
            'breadcrumb'   => [['Home', '/'], ['Nashik', '/nashik/']],
            'preloadImage' => 'assets/images/mumbai-prewedding-01.webp',
        ]);
    }

    public function nashikWedding(): string
    {
        return $this->render('pages/city/nashik/wedding', [
            'title'       => 'Wedding Photographers in Nashik | Vineyard & Resort',
            'description' => 'Candid, cinematic and traditional photography for Nashik vineyard and resort weddings. Full day coverage, albums and films. Check your date today.',
            'canonical'   => '/nashik/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Nashik', '/nashik/'], ['Wedding', '/nashik/wedding-photographers/']],
        ]);
    }

    public function nashikPreWedding(): string
    {
        return $this->render('pages/city/nashik/prewedding', [
            'title'       => 'Pre Wedding Shoot in Nashik | Vineyards, Forts & Lakes',
            'description' => 'Pre wedding shoot in Nashik at Sula Vineyards, Pandavleni Caves, Harihar Fort and Gangapur Dam. Cinematic couple photos. Book: +91 83903 67637.',
            'canonical'   => '/nashik/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Nashik', '/nashik/'], ['Pre-Wedding', '/nashik/pre-wedding-shoot/']],
        ]);
    }

    public function nashikEngagement(): string
    {
        return $this->render('pages/city/nashik/engagement', [
            'title'       => 'Engagement Photographers in Nashik | Vineyard Shoots',
            'description' => 'Engagement photoshoot in Nashik at Sula Vineyards, Pandavleni Caves and Gangapur Dam. Candid couple photos. Book: +91 83903 67637.',
            'canonical'   => '/nashik/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Nashik', '/nashik/'], ['Engagement', '/nashik/engagement-photographers/']],
        ]);
    }

    // ── Chhatrapati Sambhajinagar ─────────────────────────────────────
    public function sambhajinagar(): string
    {
        return $this->render('pages/city/sambhajinagar/index', [
            'title'        => 'Photographers in Chhatrapati Sambhajinagar | Weddings',
            'description'  => 'Wedding, pre wedding, engagement and corporate photographers in Chhatrapati Sambhajinagar (Aurangabad). Heritage spots, candid style. Call now.',
            'canonical'    => '/chhatrapati-sambhajinagar/',
            'breadcrumb'   => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/']],
            'preloadImage' => 'assets/images/mumbai-prewedding-01.webp',
        ]);
    }

    public function sambhajinagarWedding(): string
    {
        return $this->render('pages/city/sambhajinagar/wedding', [
            'title'       => 'Wedding Photographers in Chhatrapati Sambhajinagar',
            'description' => 'Candid, cinematic and traditional wedding photographers in Chhatrapati Sambhajinagar (Aurangabad). Full day coverage, albums and films. Book now.',
            'canonical'   => '/chhatrapati-sambhajinagar/wedding-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/'], ['Wedding', '/chhatrapati-sambhajinagar/wedding-photographers/']],
        ]);
    }

    public function sambhajinagarPreWedding(): string
    {
        return $this->render('pages/city/sambhajinagar/prewedding', [
            'title'       => 'Pre Wedding Shoot in Chhatrapati Sambhajinagar',
            'description' => 'Pre wedding shoot in Chhatrapati Sambhajinagar (Aurangabad) at heritage forts, gardens and city spots. Cinematic couple photos. Book today.',
            'canonical'   => '/chhatrapati-sambhajinagar/pre-wedding-shoot/',
            'breadcrumb'  => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/'], ['Pre-Wedding', '/chhatrapati-sambhajinagar/pre-wedding-shoot/']],
        ]);
    }

    public function sambhajinagarEngagement(): string
    {
        return $this->render('pages/city/sambhajinagar/engagement', [
            'title'       => 'Engagement Photographers in Chhatrapati Sambhajinagar',
            'description' => 'Engagement photoshoot in Chhatrapati Sambhajinagar at Bibi Ka Maqbara, Daulatabad Fort and Ellora Caves. Candid photos. Book: +91 83903 67637.',
            'canonical'   => '/chhatrapati-sambhajinagar/engagement-photographers/',
            'breadcrumb'  => [['Home', '/'], ['Chhatrapati Sambhajinagar', '/chhatrapati-sambhajinagar/'], ['Engagement', '/chhatrapati-sambhajinagar/engagement-photographers/']],
        ]);
    }
}
