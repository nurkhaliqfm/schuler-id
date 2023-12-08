<?php

namespace App\Models;

use CodeIgniter\Model;

class BankSoalModel extends Model
{
    protected $table = 'bank_soal';
    protected $useTimestamps = true;
    protected $allowedFields = ['type_soal', 'sub_type_soal', 'id_soal', 'kode_soal', 'soal_style', 'soal', 'option_a', 'option_b', 'option_c', 'option_d', 'option_e', 'jawaban', 'ans_id', 'pembahasan', 'value', 'sumber_id', 'category_id', 'sub_category_id', 'tahun', 'nomor_soal', 'paket_soal'];
}
