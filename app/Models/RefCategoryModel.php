<?php

namespace App\Models;

use CodeIgniter\Model;

class RefCategoryModel extends Model
{
    protected $table = 'ref_category';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'kode'];
}
