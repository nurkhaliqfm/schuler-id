<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAnswareModel extends Model
{
    protected $table = 'user_answare';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'quiz_id', 'id_soal', 'answare'];
}
