<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $useTimestamps = true;
    protected $allowedFields = ['username', 'slug', 'phone', 'password', 'level_user', 'email', 'universitas_pilihan', 'asal_sekolah', 'referal_code', 'login_session', 'last_login'];
}
