<?php

namespace App\Models;

use CodeIgniter\Model;

class UserHistoryEventModel extends Model
{
    protected $table = 'user_history_event';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'quiz_id', 'id_soal', 'quiz_type', 'quiz_category', 'answare'];
}
