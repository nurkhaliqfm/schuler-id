<?php

namespace App\Models;

use CodeIgniter\Model;

class RefSubCategoryModel extends Model
{
    protected $table = 'ref_sub_category';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'kode', 'category_id', 'jumlah', 'event_timer', 'event_quest_number'];
}
