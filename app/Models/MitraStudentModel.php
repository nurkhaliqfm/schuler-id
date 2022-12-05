<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraStudentModel extends Model
{
    protected $table = 'mitra_student';
    protected $useTimestamps = true;
    protected $allowedFields = ['mitra_id', 'mitra_name', 'user_id', 'peserta_id', 'peserta_name', 'pass', 'nomor_peserta', 'tgl_lahir', 'peserta_info', 'schedule', 'location'];
}
