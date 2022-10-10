<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunEventModel extends Model
{
    protected $table = 'akun_event';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'paket_name', 'tgl_mulai', 'sesi_pengerjaan'];
}
