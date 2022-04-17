<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('admin/dashboard', $data);
    }

    public function daftar_soal()
    {
        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('admin/daftar-soal', $data);
    }
}
