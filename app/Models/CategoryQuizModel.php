<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryQuizModel extends Model
{
    protected $table = 'category_quiz';
    protected $useTimestamps = true;
    protected $allowedFields = ['category_id', 'category_name', 'slug', 'group', 'category_item'];
}
