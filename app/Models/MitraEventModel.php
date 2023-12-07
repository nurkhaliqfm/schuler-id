<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraEventModel extends Model
{
    protected $table = 'mitra_event_offline';
    protected $useTimestamps = true;
    protected $allowedFields = ['mitra_id', 'quiz_id', 'tgl_mulai', 'list_schedule', 'list_limit'];
}
