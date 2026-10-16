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
            'title'        => 'Wedding Photographer in Pune | The Bridal Photography',
            'description'  => 'Wedding photographer in Pune since 2014. Wedding, pre wedding and maternity shoots in Pune, Mumbai and Goa. 4.9 stars from 1,179 reviews. From Rs 6,000.',
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
