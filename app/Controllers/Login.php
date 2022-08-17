<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{

    protected $usersModel;


    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }


    public function index()
    {
        if (session()->get('user_level') == 'admin super') {
            return redirect()->to(base_url('admin'));
        } elseif (session()->get('user_level') == 'admin biasa') {
            return redirect()->to(base_url('admin'));
        } elseif (session()->get('user_level') == 'users') {
            return redirect()->to(base_url('home'));
        }

        return view('login');
    }

    public function regist()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];

        return view('registrasi', $data);
    }

    public function forget_password()
    {
        return view('forget-pass');
    }

    public function auth()
    {
        $users = $this->usersModel;
        $cek = $users->where(['email' => $this->request->getVar('email')])->first();
        if ($cek) {
            $user_level = $cek['level_user'];
            $cek_password = $users->where(['email' => $cek['email'], 'password' => $this->request->getVar('password')])->first();
            if ($cek_password) {
                session()->set([
                    'username' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'logged_in' => true,
                    'user_level' => $user_level
                ]);

                $users->save([
                    'id' => $cek['id'],
                    'last_login' => date('Y-m-d H:i:s')
                ]);

                session()->setFlashdata('success', 'Login Berhasil');
                if ($user_level == 'users') {
                    return redirect()->to(base_url('home'));
                } else {
                    return redirect()->to(base_url('admin'));
                }
            } else {
                session()->setFlashdata('user_or_pass', 'Username atau Password Anda Salah');
                return redirect()->to(base_url('login'));
            }
        } else {
            session()->setFlashdata('user_or_pass', 'Username atau Password Anda Salah');
            return redirect()->to(base_url('login'));
        }
    }

    public function regist_auth()
    {
        $username = $this->request->getVar("username");
        $phoneNumber = $this->request->getVar("phoneNumber");
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");
        $passwordConfrm = $this->request->getVar("passwordConfrm");
        $referalCode = $this->request->getVar('referalCode');

        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib Diisi'
                ]
            ],
            'phoneNumber' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Wajib Diisi',
                    'numeric' => 'Format Nomor Tlpn Salah'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|valid_emails|is_unique[users.email]',
                'errors' => [
                    'required' => 'Wajib Diisi',
                    'valid_email' => 'Email Tidak Valid',
                    'valid_emails' => 'Email Tidak Valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib Diisi'
                ]
            ],
            'passwordConfrm' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib Diisi'
                ]
            ]
        ])) {
            session()->setFlashdata('failed', "Gagal Melakukan Registrasi.");
            return redirect()->to(base_url('login/regist'))->withInput();
        }

        if ($password != $passwordConfrm) {
            session()->setFlashdata('failed', "Gagal Melakukan Registrasi.");
            return redirect()->to(base_url('login/regist'))->withInput();
        } else {

            $this->usersModel->save([
                'username' => $username,
                'slug' => uniqid(),
                'phone' => $phoneNumber,
                'password' => $password,
                'level_user' => 'users',
                'email' => $email,
                'referal_code' => "",
                'last_login' => date('Y-m-d H:i:s')
            ]);

            session()->setFlashdata('success', "Berhasil Melakukan Registrasi.");
            return redirect()->to(base_url('login'))->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
