<?php

namespace App\Models;

use CodeIgniter\Model;

class BankSoalTrueFalseModel extends Model
{
    protected $table = 'bank_soal_truefalse';
    protected $useTimestamps = true;
    protected $allowedFields = ['soal_id', 'soal_tag', 'sub_soal_slug', 'sub_soal_id', 'jawaban', 'ans_id'];
}
