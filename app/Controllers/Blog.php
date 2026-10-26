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
        $perPage    = 9;
        $categories = $this->blog->getCategories();
        // ?page=0, -3 or abc used to give a negative SQL offset (500 error)
        $page = max(1, (int) $this->request->getGet('page'));
        $cat  = (string) $this->request->getGet('cat');
        if (! isset($categories[$cat])) {
            $cat = '';
        }
        $offset = ($page - 1) * $perPage;

        if ($cat !== '') {
            $posts = $this->blog->getByCategory($cat, $perPage, $offset);
            $total = $this->blog->getCategoryCount($cat);
        } else {
            $posts = $this->blog->getPublished($perPage, $offset);
            $total = $this->blog->getPublishedCount();
        }

        $totalPages = (int) ceil($total / $perPage);
        if ($page > 1 && $page > $totalPages) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $featured = $this->blog->getFeatured(1);

        $data = [
            'title'       => 'Pre Wedding Ideas, Location Guides & Tips | Photo Blog',
            'description' => 'Free pre wedding location guides, shoot ideas and photo tips from Pune photographers with 10+ years of shoots. Plan a better shoot today.',
            'canonical'   => '/blog/',
            // Filtered and paged listings repeat /blog/: keep them out of the index
            'robots'      => ($cat !== '' || $page > 1) ? 'noindex, follow' : 'index, follow',
            'view'        => 'blog/index',
            'posts'       => $posts,
            'featured'    => $featured[0] ?? null,
            'categories'  => $categories,
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

        // Count a view once per visitor session, and never for bots
        $seen = session()->get('blog_viewed') ?? [];
        if (! $this->request->getUserAgent()->isRobot() && ! in_array($post['id'], $seen, true)) {
            $this->blog->incrementViews($post['id']);
            session()->set('blog_viewed', [...$seen, $post['id']]);
        }

        // Related posts (same category, exclude self)
        $related = $this->blog->getRelated($post['id'], $post['category'] ?? 'general', 3);

        $metaTitle = $post['meta_title'] ?: $post['title'] . ' | The Bridal Photography';
        $metaDesc  = $post['meta_description'] ?: mb_substr(trim(strip_tags($post['excerpt'] ?: $post['content'])), 0, 160);
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
