<?php

namespace App\Models;

use CodeIgniter\Model;

class RefSumberPaketModel extends Model
{
    protected $table = 'ref_sumber_paket';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'kode'];
}
