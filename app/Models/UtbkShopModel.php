<?php

namespace App\Models;

use CodeIgniter\Model;

class UtbkShopModel extends Model
{
    protected $table = 'utbk_shop';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_item', 'nama_item', 'slug', 'price', 'discount', 'item_description'];
}
