<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiUserModel extends Model
{
    protected $table = 'transaksi_user';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_transaksi', 'id_user', 'nama_user', 'id_item_beli', 'price', 'status_pembayaran'];
}
