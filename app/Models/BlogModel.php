<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table         = 'blogs';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $allowedFields = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'featured_image_alt', 'category', 'meta_title', 'meta_description',
        'og_image', 'tags', 'status', 'is_featured', 'view_count', 'published_at',
    ];

    protected $validationRules = [
        // Needed so the {id} placeholder in the slug is_unique rule is filled on update
        'id'      => 'permit_empty|is_natural_no_zero',
        'title'   => 'required|min_length[3]|max_length[255]',
        'slug'    => 'required|min_length[3]|max_length[255]|is_unique[blogs.slug,id,{id}]',
        'content' => 'required',
        'status'  => 'in_list[published,draft,archived]',
    ];

    protected $validationMessages = [
        'title'  => ['required' => 'Blog title is required.'],
        'slug'   => ['is_unique' => 'This slug is already taken. Please choose another.'],
        'content'=> ['required' => 'Blog content cannot be empty.'],
    ];

    // ── Public listing ────────────────────────────────────────────────

    public function getPublished(int $limit = 9, int $offset = 0): array
    {
        return $this->where('status', 'published')
                    ->orderBy('published_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    public function getPublishedCount(): int
    {
        return $this->where('status', 'published')->countAllResults();
    }

    public function getFeatured(int $limit = 1): array
    {
        return $this->where('status', 'published')
                    ->where('is_featured', 1)
                    ->orderBy('published_at', 'DESC')
                    ->findAll($limit);
    }

    public function getByCategory(string $cat, int $limit = 9, int $offset = 0): array
    {
        return $this->where('status', 'published')
                    ->where('category', $cat)
                    ->orderBy('published_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    public function getCategoryCount(string $cat): int
    {
        return $this->where('status', 'published')->where('category', $cat)->countAllResults();
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('status', 'published')
                    ->first();
    }

    public function getRelated(int $id, string $category, int $limit = 3): array
    {
        return $this->where('status', 'published')
                    ->where('id !=', $id)
                    ->where('category', $category)
                    ->orderBy('published_at', 'DESC')
                    ->findAll($limit);
    }

    public function incrementViews(int $id): void
    {
        $this->set('view_count', 'view_count + 1', false)->where('id', $id)->update();
    }

    // ── Admin ─────────────────────────────────────────────────────────

    public function getAllForAdmin(int $limit = 20, int $offset = 0): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit, $offset);
    }

    public function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        $base = $slug;
        $i    = 1;
        while ($this->where('slug', $slug)->countAllResults() > 0) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function getCategories(): array
    {
        return [
            'pre-wedding' => 'Pre-Wedding',
            'wedding'     => 'Wedding',
            'maternity'   => 'Maternity & Baby',
            'engagement'  => 'Engagement',
            'tips'        => 'Tips & Guides',
            'locations'   => 'Locations',
            'general'     => 'General',
        ];
    }
}
