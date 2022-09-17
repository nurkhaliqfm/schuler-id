<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiUserModel extends Model
{
    protected $table = 'transaksi_user';
    protected $useTimestamps = true;
    protected $allowedFields = ['transaction_id', 'order_id', 'id_user', 'nama_user', 'id_item_beli', 'paket_name', 'price', 'payment_type', 'va_number', 'bank', 'transaction_status', 'transaction_time'];
}
