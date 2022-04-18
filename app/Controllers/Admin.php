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

    public function question()
    {
        $question = $this->request->getVar('editorQuestion');
        $data = [
            'question' => $question,
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('admin/view-soal', $data);
    }

    public function upload_image()
    {
        $fileupload = $this->request->getFile('my_editor');
        $extension = $fileupload->guessExtension();
        $fileupload_name = 'imagebaru' . '.' . $extension;
        $fileupload->move('assets/upload_image', $fileupload_name);
    }
}
