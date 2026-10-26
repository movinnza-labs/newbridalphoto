<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $blog  = new BlogModel();
        $total = $blog->countAll();
        $pub   = $blog->where('status', 'published')->countAllResults();
        $draft = $blog->where('status', 'draft')->countAllResults();
        $recent= $blog->orderBy('created_at', 'DESC')->findAll(5);

        return view('admin/dashboard', [
            'title'       => 'Dashboard — The Bridal Admin',
            'totalBlogs'  => $total,
            'published'   => $pub,
            'drafts'      => $draft,
            'recentBlogs' => $recent,
        ]);
    }
}
