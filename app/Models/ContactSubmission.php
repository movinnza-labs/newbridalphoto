<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactSubmission extends Model
{
    protected $table            = 'contact_submissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'phone',
        'email',
        'address',
        'service',
        'source',
        'status',
        'ip_address',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
