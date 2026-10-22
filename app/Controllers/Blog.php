<?php

namespace App\Controllers;

use App\Models\BlogModel;

class Blog extends BaseController
{
    protected BlogModel $blog;

    public function __construct()
    {
        $this->blog = new BlogModel();
    }

    // ── Blog Listing ──────────────────────────────────────────────────
    public function index(): string
    {
        $perPage = 9;
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $cat     = $this->request->getGet('cat') ?? '';
        $offset  = ($page - 1) * $perPage;

        if ($cat && $cat !== 'all') {
            $posts = $this->blog->getByCategory($cat, $perPage);
            $total = count($posts);
        } else {
            $posts = $this->blog->getPublished($perPage, $offset);
            $total = $this->blog->getPublishedCount();
        }

        $featured   = $this->blog->getFeatured(1);
        $totalPages = (int) ceil($total / $perPage);

        $data = [
            'title'       => 'Pre Wedding Ideas, Location Guides & Tips | Photo Blog',
            'description' => 'Free pre wedding location guides, shoot ideas and photo tips from Pune photographers with 10+ years of shoots. Plan a better shoot today.',
            'canonical'   => '/blog/',
            'view'        => 'blog/index',
            'posts'       => $posts,
            'featured'    => $featured[0] ?? null,
            'categories'  => $this->blog->getCategories(),
            'currentCat'  => $cat,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'total'       => $total,
            'breadcrumb'  => [['Home', '/'], ['Blog', '/blog/']],
        ];

        return view('layouts/main', $data);
    }

    // ── Blog Detail ───────────────────────────────────────────────────
    public function detail(string $slug): string
    {
        $post = $this->blog->getBySlug($slug);

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                "Blog post '{$slug}' not found."
            );
        }

        // Increment view count
        $this->blog->incrementViews($post['id']);

        // Related posts (same category, exclude self)
        $related = $this->blog->getRelated($post['id'], $post['category'] ?? 'general', 3);

        $metaTitle = $post['meta_title'] ?: $post['title'] . ' | The Bridal Photography';
        $metaDesc  = $post['meta_description'] ?: strip_tags(substr($post['excerpt'] ?: $post['content'], 0, 160));
        $ogImage   = $post['og_image'] ?: $post['featured_image'];

        $data = [
            'title'      => $metaTitle,
            'description'=> $metaDesc,
            'og_image'   => $ogImage,
            'canonical'  => '/blog/' . $post['slug'] . '/',
            'view'       => 'blog/detail',
            'post'       => $post,
            'related'    => $related,
            'breadcrumb' => [['Home', '/'], ['Blog', '/blog/'], [$post['title'], '/blog/' . $post['slug'] . '/']],
        ];

        return view('layouts/main', $data);
    }
}
