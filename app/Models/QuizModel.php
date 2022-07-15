<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'quiz';
    protected $useTimestamps = true;
    protected $allowedFields = ['quiz_id', 'quiz_name', 'slug', 'category_group'];
}
