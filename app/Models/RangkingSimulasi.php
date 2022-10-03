<?php

namespace App\Models;

use CodeIgniter\Model;

class RangkingSimulasi extends Model
{
    protected $table = 'simulasi_rangking';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_user', 'user_name', 'email', 'id_universitas', 'universitas_pilihan', 'asal_sekolah', 'skor'];
}
