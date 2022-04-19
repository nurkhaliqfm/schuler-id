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
        $allowExt = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }

        if (in_array($extension, $allowExt)) {
            $fileupload_name = sha1(microtime()) . "." . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "/assets/upload_image/" . $fileupload_name);

            $response = ["link" => $protocol . $_SERVER["HTTP_HOST"] . "/assets/upload_image/" . $fileupload_name];
            return $this->response->setJSON($response);
        }
    }

    public function deleted_image()
    {
        $src = $this->request->getJsonVar('src');
        $src = str_replace(base_url('/'), "", $src);
        if (file_exists(getcwd() . $src)) {
            unlink(getcwd() . $src);
        }
    }
}
