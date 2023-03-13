<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;

class Login extends BaseController
{
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
        $session_id = Uuid::uuid4();
        $users = $this->usersModel;
        $cek = $users->where(['email' => strtolower($this->request->getVar('email'))])->first();
        if ($cek) {
            $user_level = $cek['level_user'];
            $cek_password = $users->where(['email' => strtolower($cek['email']), 'password' => $this->request->getVar('password')])->first();
            if ($cek_password) {
                if ($user_level == 'users') {
                    if ($cek_password['universitas_pilihan'] == "") {
                        return redirect()->to(base_url('login/kampus?slug=' . $cek_password['slug'] . '&query=login'));
                    }
                }

                session()->set([
                    'session_id' => $session_id,
                    'username' => strtolower($this->request->getVar('email')),
                    'password' => $this->request->getVar('password'),
                    'logged_in' => true,
                    'user_level' => $user_level
                ]);

                $users->update($cek['id'], [
                    'last_login' => date('Y-m-d H:i:s'),
                    'login_session' => $session_id
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
        $email = strtolower($this->request->getVar("email"));
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
                    'valid_emails' => 'Email Tidak Valid',
                    'is_unique' => 'Email Telah Terdaftar'
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
            $slug = uniqid();
            $this->usersModel->save([
                'username' => $username,
                'slug' => $slug,
                'phone' => $phoneNumber,
                'password' => $password,
                'level_user' => 'users',
                'email' => $email,
                'referal_code' => "",
                'last_login' => date('Y-m-d H:i:s')
            ]);

            session()->setFlashdata('success', "Berhasil Melakukan Registrasi.");
            return redirect()->to(base_url('login/kampus?slug=' . $slug))->withInput();
        }
    }

    public function kampus()
    {
        $slug = $this->request->getVar('slug');
        if ($slug == null) return redirect()->to(base_url('login'));
        
        $getUser = $this->usersModel->where(['slug' => $slug])->first();

        $data = [
            'asal_sekolah' => $getUser['asal_sekolah'],
            'kampus' => $this->universitasModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('kampus', $data);
    }


    public function kampus_auth()
    {
        $query = $this->request->getVar('query');
        $slug = $this->request->getVar('slug');
        $kampus_1 = $this->request->getVar("kampus_1");

        if (!$this->validate([
            'kampus_1' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib Diisi'
                ]
            ],
            'asalSekolah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib Diisi'
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Gagal Menambahkan Kampus Impian.");
            if ($query == 'login') {
                return redirect()->to(base_url('login/kampus?slug=' . $slug . '&query=' . $query))->withInput();
            } else {
                return redirect()->to(base_url('login/kampus?slug=' . $slug))->withInput();
            }
        }

        $kampus_1 =  $this->universitasModel->where(['id_universitas' => $kampus_1])->first();
        $getUser = $this->usersModel->where(['slug' => $slug])->first();

        $this->usersModel->update($getUser['id'], [
            'universitas_pilihan' => $kampus_1['id_universitas'],
            'asal_sekolah' => $this->request->getVar('asalSekolah'),
        ]);

        if ($query == 'login') {
            session()->setFlashdata('success', "Berhasil Menambah Kampus Impian, Silahkan Login kembali.");
            return redirect()->to(base_url('login'))->withInput();
        } else {
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
