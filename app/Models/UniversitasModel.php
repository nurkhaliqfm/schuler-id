<?php

namespace App\Models;

use CodeIgniter\Model;

class UniversitasModel extends Model
{
    protected $table = 'universitas';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_universitas', 'nama_universitas'];
}
