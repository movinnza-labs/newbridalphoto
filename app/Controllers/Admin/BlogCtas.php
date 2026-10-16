<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogCtaModel;
use App\Models\BlogModel;

class BlogCtas extends BaseController
{
    protected BlogCtaModel $ctaModel;
    protected BlogModel    $blogModel;

    public function __construct()
    {
        $this->ctaModel  = new BlogCtaModel();
        $this->blogModel = new BlogModel();
        helper(['form', 'url']);
    }

    /** List all CTAs for a given blog post. */
    public function index(int $blogId): string
    {
        $post = $this->blogModel->find($blogId);
        if (! $post) {
            session()->setFlashdata('error', 'Blog post not found.');
            return redirect()->to('/admin/blogs/');
        }

        return view('admin/blog-cta/index', [
            'title'        => 'Manage CTAs - ' . $post['title'],
            'post'         => $post,
            'ctas'         => $this->ctaModel->getAllForBlog($blogId),
            'flashSuccess' => session()->getFlashdata('success'),
            'flashError'   => session()->getFlashdata('error'),
        ]);
    }

    /** Create form. */
    public function create(int $blogId): string
    {
        $post = $this->blogModel->find($blogId);
        if (! $post) {
            session()->setFlashdata('error', 'Blog post not found.');
            return redirect()->to('/admin/blogs/');
        }

        return view('admin/blog-cta/form', [
            'title'      => 'Add CTA - ' . $post['title'],
            'post'       => $post,
            'cta'        => null,
            'isEdit'     => false,
            'flashError' => session()->getFlashdata('error'),
        ]);
    }

    /** Store new CTA. */
    public function store(int $blogId)
    {
        $post = $this->blogModel->find($blogId);
        if (! $post) {
            return redirect()->to('/admin/blogs/');
        }

        $rules = [
            'heading'      => 'required|max_length[500]',
            'button_label' => 'required|max_length[100]',
            'button_url'   => 'required|max_length[500]',
        ];
        if (! $this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $this->ctaModel->insert([
            'blog_id'        => $blogId,
            'heading'        => $this->request->getPost('heading'),
            'button_label'   => $this->request->getPost('button_label'),
            'button_url'     => $this->request->getPost('button_url') ?: '/contact/',
            'anchor_heading' => $this->request->getPost('anchor_heading') ?: null,
            'style'          => $this->request->getPost('style') ?: 'light',
            'sort_order'     => (int) $this->request->getPost('sort_order'),
            'is_active'      => (int) $this->request->getPost('is_active') === 1 ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'CTA added successfully.');
        return redirect()->to('/admin/blogs/' . $blogId . '/ctas/');
    }

    /** Edit form. */
    public function edit(int $blogId, int $id): string
    {
        $post = $this->blogModel->find($blogId);
        $cta  = $this->ctaModel->find($id);
        if (! $post || ! $cta || (int) $cta['blog_id'] !== $blogId) {
            session()->setFlashdata('error', 'CTA not found.');
            return redirect()->to('/admin/blogs/' . $blogId . '/ctas/');
        }

        return view('admin/blog-cta/form', [
            'title'      => 'Edit CTA - ' . $post['title'],
            'post'       => $post,
            'cta'        => $cta,
            'isEdit'     => true,
            'flashError' => session()->getFlashdata('error'),
        ]);
    }

    /** Update existing CTA. */
    public function update(int $blogId, int $id)
    {
        $cta = $this->ctaModel->find($id);
        if (! $cta || (int) $cta['blog_id'] !== $blogId) {
            return redirect()->to('/admin/blogs/' . $blogId . '/ctas/');
        }

        $rules = [
            'heading'      => 'required|max_length[500]',
            'button_label' => 'required|max_length[100]',
            'button_url'   => 'required|max_length[500]',
        ];
        if (! $this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $this->ctaModel->update($id, [
            'heading'        => $this->request->getPost('heading'),
            'button_label'   => $this->request->getPost('button_label'),
            'button_url'     => $this->request->getPost('button_url') ?: '/contact/',
            'anchor_heading' => $this->request->getPost('anchor_heading') ?: null,
            'style'          => $this->request->getPost('style') ?: 'light',
            'sort_order'     => (int) $this->request->getPost('sort_order'),
            'is_active'      => (int) $this->request->getPost('is_active') === 1 ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'CTA updated successfully.');
        return redirect()->to('/admin/blogs/' . $blogId . '/ctas/');
    }

    /** Delete CTA. */
    public function delete(int $blogId, int $id)
    {
        $cta = $this->ctaModel->find($id);
        if ($cta && (int) $cta['blog_id'] === $blogId) {
            $this->ctaModel->delete($id);
            session()->setFlashdata('success', 'CTA deleted.');
        }
        return redirect()->to('/admin/blogs/' . $blogId . '/ctas/');
    }
}
