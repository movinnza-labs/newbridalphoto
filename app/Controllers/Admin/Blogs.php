<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Blogs extends BaseController
{
    protected BlogModel $blog;

    public function __construct()
    {
        $this->blog = new BlogModel();
        helper(['form', 'url', 'text']);
    }

    // ── List ──────────────────────────────────────────────────────────
    public function index(): string
    {
        $perPage = 20;
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $offset  = ($page - 1) * $perPage;
        $posts   = $this->blog->getAllForAdmin($perPage, $offset);
        $total   = $this->blog->countAll();

        return view('admin/blog/index', [
            'title'       => 'Manage Blogs — The Bridal Admin',
            'posts'       => $posts,
            'total'       => $total,
            'currentPage' => $page,
            'totalPages'  => (int) ceil($total / $perPage),
            'categories'  => $this->blog->getCategories(),
            'flashSuccess'=> session()->getFlashdata('success'),
            'flashError'  => session()->getFlashdata('error'),
        ]);
    }

    // ── Create Form ───────────────────────────────────────────────────
    public function create(): string
    {
        return view('admin/blog/form', [
            'title'      => 'Add New Blog Post — The Bridal Admin',
            'post'       => null,
            'categories' => $this->blog->getCategories(),
            'isEdit'     => false,
            'flashError' => session()->getFlashdata('error'),
        ]);
    }

    // ── Store ─────────────────────────────────────────────────────────
    public function store()
    {
        $rules = [
            'title'   => 'required|min_length[3]|max_length[255]',
            'content' => 'required',
            'status'  => 'required|in_list[published,draft,archived]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $title   = $this->request->getPost('title');
        $slug    = $this->request->getPost('slug') ?: $this->blog->generateSlug($title);
        $slug    = $this->blog->generateSlug($slug); // ensure uniqueness

        // Handle featured image upload
        $imagePath = '';
        $img = $this->request->getFile('featured_image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            $imagePath = $this->handleImageUpload($img);
        }

        // Handle published_at
        $publishedAt = $this->request->getPost('published_at') ?: date('Y-m-d H:i:s');

        $data = [
            'title'               => $title,
            'slug'                => $slug,
            'excerpt'             => $this->request->getPost('excerpt') ?: '',
            'content'             => $this->request->getPost('content'),
            'featured_image'      => $imagePath,
            'featured_image_alt'  => $this->request->getPost('featured_image_alt') ?: $title,
            'category'            => $this->request->getPost('category') ?: 'general',
            'meta_title'          => $this->request->getPost('meta_title') ?: $title . ' | The Bridal Photography',
            'meta_description'    => $this->request->getPost('meta_description') ?: '',
            'og_image'            => $imagePath,
            'tags'                => $this->request->getPost('tags') ?: '',
            'status'              => $this->request->getPost('status'),
            'is_featured'         => (int) $this->request->getPost('is_featured') === 1 ? 1 : 0,
            'published_at'        => $publishedAt,
        ];

        $this->blog->insert($data);

        session()->setFlashdata('success', 'Blog post "' . esc($title) . '" created successfully.');
        return redirect()->to('/admin/blogs/');
    }

    // ── Edit Form ─────────────────────────────────────────────────────
    public function edit(int $id): string
    {
        $post = $this->blog->find($id);
        if (! $post) {
            session()->setFlashdata('error', 'Blog post not found.');
            return redirect()->to('/admin/blogs/');
        }

        return view('admin/blog/form', [
            'title'      => 'Edit Blog Post — The Bridal Admin',
            'post'       => $post,
            'categories' => $this->blog->getCategories(),
            'isEdit'     => true,
            'flashError' => session()->getFlashdata('error'),
        ]);
    }

    // ── Update ────────────────────────────────────────────────────────
    public function update(int $id)
    {
        $post = $this->blog->find($id);
        if (! $post) {
            session()->setFlashdata('error', 'Blog post not found.');
            return redirect()->to('/admin/blogs/');
        }

        $rules = [
            'title'   => 'required|min_length[3]|max_length[255]',
            'content' => 'required',
            'status'  => 'required|in_list[published,draft,archived]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $title = $this->request->getPost('title');
        $slug  = $this->request->getPost('slug') ?: $post['slug'];

        // Only re-check uniqueness if slug changed
        if ($slug !== $post['slug']) {
            // Check if taken by another post
            $existing = $this->blog->where('slug', $slug)->where('id !=', $id)->first();
            if ($existing) {
                $slug = $slug . '-' . time();
            }
        }

        // Handle image upload
        $imagePath = $post['featured_image'];
        $img = $this->request->getFile('featured_image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            $newPath = $this->handleImageUpload($img);
            if ($newPath) {
                // Delete old image
                if ($imagePath && file_exists(FCPATH . $imagePath)) {
                    unlink(FCPATH . $imagePath);
                }
                $imagePath = $newPath;
            }
        }

        $data = [
            'id'                 => $id, // fills {id} in the model's slug is_unique rule
            'title'              => $title,
            'slug'               => $slug,
            'excerpt'            => $this->request->getPost('excerpt') ?: '',
            'content'            => $this->request->getPost('content'),
            'featured_image'     => $imagePath,
            'featured_image_alt' => $this->request->getPost('featured_image_alt') ?: $title,
            'category'           => $this->request->getPost('category') ?: 'general',
            'meta_title'         => $this->request->getPost('meta_title') ?: $title . ' | The Bridal Photography',
            'meta_description'   => $this->request->getPost('meta_description') ?: '',
            'tags'               => $this->request->getPost('tags') ?: '',
            'status'             => $this->request->getPost('status'),
            'is_featured'        => (int) $this->request->getPost('is_featured') === 1 ? 1 : 0,
            'published_at'       => $this->request->getPost('published_at') ?: $post['published_at'],
        ];

        $this->blog->update($id, $data);

        session()->setFlashdata('success', 'Blog post updated successfully.');
        return redirect()->to('/admin/blogs/');
    }

    // ── Delete ────────────────────────────────────────────────────────
    public function delete(int $id)
    {
        $post = $this->blog->find($id);
        if ($post) {
            // Remove image file
            if ($post['featured_image'] && file_exists(FCPATH . $post['featured_image'])) {
                unlink(FCPATH . $post['featured_image']);
            }
            $this->blog->delete($id);
            session()->setFlashdata('success', 'Blog post "' . esc($post['title']) . '" deleted.');
        }
        return redirect()->to('/admin/blogs/');
    }

    // ── Image Upload (AJAX, for rich editor) ─────────────────────────
    public function uploadImage()
    {
        $img = $this->request->getFile('image');
        if (! $img || ! $img->isValid()) {
            return $this->response->setJSON(['error' => 'Invalid file']);
        }
        $path = $this->handleImageUpload($img);
        if (! $path) {
            return $this->response->setJSON(['error' => 'Upload failed']);
        }
        return $this->response->setJSON([
            'location' => base_url($path),  // TinyMCE expects "location"
        ]);
    }

    // ── Private Helpers ───────────────────────────────────────────────
    private function handleImageUpload($file): string
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext     = strtolower($file->getExtension());

        if (! in_array($ext, $allowed)) {
            return '';
        }

        // SEO-friendly filename: timestamp + sanitized original name
        $originalName = pathinfo($file->getName(), PATHINFO_FILENAME);
        $cleanName    = strtolower(preg_replace('/[^a-z0-9]+/', '-', $originalName));
        $newName      = date('Y-m') . '-' . $cleanName . '-' . time() . '.' . $ext;

        $uploadPath = FCPATH . 'img/blog/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($file->move($uploadPath, $newName)) {
            return 'img/blog/' . $newName;
        }

        return '';
    }
}
