<?php

namespace App\Models;

use CodeIgniter\Model;

class BankQuizModel extends Model
{
    protected $table = 'bank_quiz';
    protected $useTimestamps = true;
    protected $allowedFields = ['quiz_id', 'quiz_name', 'quiz_subject', 'quiz_sub_subject', 'quiz_question', 'quiz_type', 'soal_type'];
}
