<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table = 'mitra_schuler';
    protected $useTimestamps = true;
    protected $allowedFields = ['mitra_id', 'mitra_name', 'mitra_logo'];
}
