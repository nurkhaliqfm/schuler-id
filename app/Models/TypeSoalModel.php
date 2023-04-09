<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeSoalModel extends Model
{
    protected $table = 'type_soal';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_main_type_soal', 'main_type_soal', 'slug', 'description', 'list_type_soal_id', 'list_type_soal', 'list_type_soal_jumlah', 'event_timer', 'event_quest_numb'];
}
