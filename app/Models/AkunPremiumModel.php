<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunPremiumModel extends Model
{
    protected $table = 'akun_premium';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'tgl_mulai', 'tgl_berakhir'];
}
