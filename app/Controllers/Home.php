<?php

namespace App\Controllers;

use App\Models\BlogModel;

class Home extends BaseController
{
    public function index(): string
    {
        $blogModel   = new BlogModel();
        $recentBlogs = $blogModel->getPublished(3);

        $data = [
            'title'        => 'Wedding Photographer in Pune | Since 2014, From ₹6,000',
            'description'  => 'Candid wedding, pre wedding and maternity photography in Pune, Mumbai and Goa since 2014. Packages from ₹6,000. Check your date and book a free call.',
            'canonical'    => '/',
            'recentBlogs'  => $recentBlogs,
            // LCP optimisation — preload the hero image referenced in pages/home.php
            'preloadImage' => 'assets/images/hero-prewedding-couple-1.webp',
            // Warm up TLS to YouTube origins used by the 6 video facades on this page
            'extraHead'    =>
                '<link rel="preconnect" href="https://www.youtube.com" crossorigin>' .
                '<link rel="preconnect" href="https://i.ytimg.com" crossorigin>',
        ];

        return view('layouts/main', $data + ['view' => 'pages/home']);
    }
}
