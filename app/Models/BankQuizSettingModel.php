<?php

namespace App\Models;

use CodeIgniter\Model;

class BankQuizModel extends Model
{
    protected $table = 'bank_quiz_setting';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_quiz', 'quiz_time', 'quiz_flow'];
}
