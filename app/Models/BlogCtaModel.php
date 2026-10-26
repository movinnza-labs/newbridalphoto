<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogCtaModel extends Model
{
    protected $table         = 'blog_ctas';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $allowedFields = [
        'blog_id', 'heading', 'button_label', 'button_url',
        'anchor_heading', 'style', 'sort_order', 'is_active',
    ];

    protected $validationRules = [
        'blog_id'      => 'required|integer',
        'heading'      => 'required|max_length[500]',
        'button_label' => 'required|max_length[100]',
        'button_url'   => 'required|max_length[500]',
        'style'        => 'in_list[light,dark]',
    ];

    /** Get all active CTAs for a blog post, ordered. */
    public function getForBlog(int $blogId): array
    {
        return $this->where('blog_id', $blogId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /** Admin: all CTAs for a blog (including inactive). */
    public function getAllForBlog(int $blogId): array
    {
        return $this->where('blog_id', $blogId)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
}
