<?php

namespace App\Controllers;

use App\Models\TypeSoalModel;
use App\Models\BankSoalModel;
use App\Models\BankQuizModel;
use App\Models\CategoryQuizModel;
use App\Models\QuizModel;
use App\Models\UniversitasModel;
use App\Models\UserHistoryModel;
use App\Models\UserHistoryUtbkModel;
use Exception;
use Ramsey\Uuid\Uuid;

class Admin extends BaseController
{
    protected $typeSoalModel;
    protected $bankSoalModel;
    protected $bankQuizModel;
    protected $categoryQuizModel;
    protected $quizModel;
    protected $universitasModel;
    protected $userHistoryModel;
    protected $userHistoryUtbkModel;

    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->bankQuizModel = new BankQuizModel();
        $this->categoryQuizModel = new CategoryQuizModel();
        $this->quizModel = new QuizModel();
        $this->universitasModel = new UniversitasModel();
        $this->userHistoryModel  = new UserHistoryModel();
        $this->userHistoryUtbkModel  = new UserHistoryUtbkModel();
    }

    public function index()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => $user['username']
        ];

        return view('admin/dashboard', $data);
    }

    // BANK SOAL SECTION
    public function bank_soal()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $typeSoalModel = $this->typeSoalModel->findAll();

        $data = [];
        foreach ($typeSoalModel as $ts) {
            $dataId = explode(',', $ts['list_type_soal_id']);
            $dataName = explode(',', $ts['list_type_soal']);
            $dataNumb = explode(',', $ts['list_type_soal_jumlah']);

            for ($i = 0; $i < count($dataId); $i++) {
                $item = [
                    'dataId' => $dataId[$i],
                    'dataName' => $dataName[$i],
                    'dataNumb' => $dataNumb[$i],
                    'slug' => $ts['slug']
                ];
                array_push($data, $item);
            }
        }

        $data = [
            'title' => 'Bank Soal Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $typeSoalModel,
            'data_category' => $data
        ];

        return view('admin/bank-soal/bank-soal', $data);
    }

    public function jenis_bank_soal()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $menuSoal = $this->request->getVar('query');
        $typeSoalModel = $this->typeSoalModel->where(['id_main_type_soal' => $menuSoal])->first();

        $data = [
            'title' => 'Bank Soal Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $typeSoalModel
        ];

        return view('admin/bank-soal/bank-soal-type', $data);
    }

    public function daftar_soal($menuSoal, $submenuSoal)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $bankSoalModel = $this->bankSoalModel->where([
            'type_soal' => $menuSoal,
            'sub_type_soal' => $submenuSoal
        ])->findAll();

        // dd($bankSoalModel);

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoalModel,
            'menu_soal' => $menuSoal,
            'submenu_soal' => $submenuSoal
        ];

        return view('admin/bank-soal/daftar-soal', $data);
    }

    public function input_soal($id, $type, $style)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }


        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'menu_soal' => $id,
            'submenu_soal' => $type,
            'soal_style' => $style,
            'validation' => \Config\Services::validation()
        ];

        if ($style == 'normal') {
            return view('admin/bank-soal/input-soal', $data);
        } else {
            return view('admin/bank-soal/input-soal-truefalse', $data);
        }
    }

    // Soal Normal
    public function edit_soal($idSoal)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $bankSoalModel = $this->bankSoalModel->where([
            'id_soal' => $idSoal
        ])->first();

        $listOption = ['option_a', 'option_b', 'option_c', 'option_d', 'option_e'];
        foreach ($listOption as $lo) {
            if (md5($lo) == $bankSoalModel['jawaban']) {
                $questionAns = $lo;
            }
        }

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'menu_soal' => $bankSoalModel['type_soal'],
            'submenu_soal' => $bankSoalModel['sub_type_soal'],
            'bank_soal' => $bankSoalModel,
            'answer_quest' => $questionAns,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/bank-soal/edit-soal', $data);
    }

    public function save_soal()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $menuSoal = $this->request->getVar('MenuSoal');
        $submenuSoal = $this->request->getVar('SubmenuSoal');

        if (!$this->validate([
            'editorQuestion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Soal Harus Diisi',
                ]
            ],
            'option_a' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan A Harus Diisi',
                ]
            ],
            'option_b' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan B Harus Diisi',
                ]
            ],
            'option_c' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan C Harus Diisi',
                ]
            ],
            'option_d' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan D Harus Diisi',
                ]
            ],
            'option_e' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan E Harus Diisi',
                ]
            ],
            'checkbox' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jawaban Soal Belum Dipilih',
                ]
            ],
            'questionValue' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Point Soal Harus Diisi',
                ]
            ],
            'editorExplanation' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pembahasan Harus Diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Soal Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/input_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
        }

        $questionAns = $this->request->getVar('checkbox');
        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->save([
            'type_soal' => $menuSoal,
            'sub_type_soal' => $submenuSoal,
            'id_soal' => uniqid(),
            'soal' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('editorQuestion')),
            'option_a' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_a')),
            'option_b' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_b')),
            'option_c' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_c')),
            'option_d' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_d')),
            'option_e' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_e')),
            'jawaban' => md5($questionAns[0]),
            'ans_id' => $questionAns[0],
            'pembahasan' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('editorExplanation')),
            'value' => $this->request->getVar('questionValue')
        ]);

        $TypeSoalModel = $this->typeSoalModel;
        $getTypeSoal = $TypeSoalModel->where(['id_main_type_soal' => $menuSoal])->first();
        $typeSoalId = explode(",", $getTypeSoal['list_type_soal_id']);
        $valueSoal = explode(",", $getTypeSoal['list_type_soal_jumlah']);
        $arrayLong = sizeof($valueSoal);
        for ($i = 0; $i < $arrayLong; $i++) {
            if ($typeSoalId[$i] == $submenuSoal) {
                $valueSoal[$i] = $valueSoal[$i] + 1;
            }
        };

        $TypeSoalModel->update($getTypeSoal['id'], [
            'list_type_soal_jumlah' => join(",", $valueSoal)
        ]);

        session()->setFlashdata('success', "Soal Berhasil Ditambahkan.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function save_soal_truefalse()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $menuSoal = $this->request->getVar('MenuSoal');
        $submenuSoal = $this->request->getVar('SubmenuSoal');

        if (!$this->validate([
            'editorQuestion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Soal Harus Diisi',
                ]
            ],
            'option_a' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan A Harus Diisi',
                ]
            ],
            'option_b' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan B Harus Diisi',
                ]
            ],
            'option_c' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan C Harus Diisi',
                ]
            ],
            'option_d' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan D Harus Diisi',
                ]
            ],
            'option_e' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan E Harus Diisi',
                ]
            ],
            'checkbox' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jawaban Soal Belum Dipilih',
                ]
            ],
            'questionValue' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Point Soal Harus Diisi',
                ]
            ],
            'editorExplanation' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pembahasan Harus Diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Soal Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/input_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
        }

        $questionAns = $this->request->getVar('checkbox');
        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->save([
            'type_soal' => $menuSoal,
            'sub_type_soal' => $submenuSoal,
            'id_soal' => uniqid(),
            'soal' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('editorQuestion')),
            'option_a' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_a')),
            'option_b' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_b')),
            'option_c' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_c')),
            'option_d' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_d')),
            'option_e' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('option_e')),
            'jawaban' => md5($questionAns[0]),
            'ans_id' => $questionAns[0],
            'pembahasan' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('editorExplanation')),
            'value' => $this->request->getVar('questionValue')
        ]);

        $TypeSoalModel = $this->typeSoalModel;
        $getTypeSoal = $TypeSoalModel->where(['id_main_type_soal' => $menuSoal])->first();
        $typeSoalId = explode(",", $getTypeSoal['list_type_soal_id']);
        $valueSoal = explode(",", $getTypeSoal['list_type_soal_jumlah']);
        $arrayLong = sizeof($valueSoal);
        for ($i = 0; $i < $arrayLong; $i++) {
            if ($typeSoalId[$i] == $submenuSoal) {
                $valueSoal[$i] = $valueSoal[$i] + 1;
            }
        };

        $TypeSoalModel->update($getTypeSoal['id'], [
            'list_type_soal_jumlah' => join(",", $valueSoal)
        ]);

        session()->setFlashdata('success', "Soal Berhasil Ditambahkan.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function duplicat_soal($idSoal)
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $getBankSoal = $this->bankSoalModel->where([
            'id_soal' => $idSoal
        ])->first();

        $new_image_soal = [];
        $old_image_soal = [];
        $new_image_pembahasan = [];
        $old_image_pembahasan = [];
        $new_image_optionA = [];
        $old_image_optionA = [];
        $new_image_optionB = [];
        $old_image_optionB = [];
        $new_image_optionC = [];
        $old_image_optionC = [];
        $new_image_optionD = [];
        $old_image_optionD = [];
        $new_image_optionE = [];
        $old_image_optionE = [];
        $explodeSoal = explode('/assets/upload_image/', $getBankSoal['soal']);
        $explodePembahasan = explode('/assets/upload_image/', $getBankSoal['pembahasan']);
        $explodeoptionA = explode('/assets/upload_image/', $getBankSoal['option_a']);
        $explodeoptionB = explode('/assets/upload_image/', $getBankSoal['option_b']);
        $explodeoptionC = explode('/assets/upload_image/', $getBankSoal['option_c']);
        $explodeoptionD = explode('/assets/upload_image/', $getBankSoal['option_d']);
        $explodeoptionE = explode('/assets/upload_image/', $getBankSoal['option_e']);
        $new_soal = $getBankSoal['soal'];
        $new_pembahasan = $getBankSoal['pembahasan'];
        $new_option_a = $getBankSoal['option_a'];
        $new_option_b = $getBankSoal['option_b'];
        $new_option_c = $getBankSoal['option_c'];
        $new_option_d = $getBankSoal['option_d'];
        $new_option_e = $getBankSoal['option_e'];
        foreach ($explodeSoal as $es) {
            $cekExplode = explode('"', $es);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_soal, $img_name);
                array_push($old_image_soal, $oldImg);
            }
        }

        foreach ($explodePembahasan as $ep) {
            $cekExplode = explode('"', $ep);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_pembahasan, $img_name);
                array_push($old_image_pembahasan, $oldImg);
            }
        }

        foreach ($explodeoptionA as $ep) {
            $cekExplode = explode('"', $ep);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_optionA, $img_name);
                array_push($old_image_optionA, $oldImg);
            }
        }

        foreach ($explodeoptionB as $ep) {
            $cekExplode = explode('"', $ep);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_optionB, $img_name);
                array_push($old_image_optionB, $oldImg);
            }
        }

        foreach ($explodeoptionC as $ep) {
            $cekExplode = explode('"', $ep);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_optionC, $img_name);
                array_push($old_image_optionC, $oldImg);
            }
        }

        foreach ($explodeoptionD as $ep) {
            $cekExplode = explode('"', $ep);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_optionD, $img_name);
                array_push($old_image_optionD, $oldImg);
            }
        }

        foreach ($explodeoptionE as $ep) {
            $cekExplode = explode('"', $ep);
            if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                $oldImg = $cekExplode[0];
                $img = explode('.', $cekExplode[0]);
                $img_name = sha1(microtime()) . "." . $img[1];
                copy(getcwd() . '/assets/upload_image/' . $oldImg, getcwd() . '/assets/upload_image/' . $img_name);

                array_push($new_image_optionE, $img_name);
                array_push($old_image_optionE, $oldImg);
            }
        }

        $new_soal = str_replace($old_image_soal, $new_image_soal, $getBankSoal['soal']);
        $new_pembahasan = str_replace($old_image_pembahasan, $new_image_pembahasan, $getBankSoal['pembahasan']);
        $new_option_a = str_replace($old_image_optionA, $new_image_optionA, $getBankSoal['option_a']);
        $new_option_b = str_replace($old_image_optionB, $new_image_optionB, $getBankSoal['option_b']);
        $new_option_c = str_replace($old_image_optionC, $new_image_optionC, $getBankSoal['option_c']);
        $new_option_d = str_replace($old_image_optionD, $new_image_optionD, $getBankSoal['option_d']);
        $new_option_e = str_replace($old_image_optionE, $new_image_optionE, $getBankSoal['option_e']);

        $menuSoal = $getBankSoal['type_soal'];
        $submenuSoal = $getBankSoal['sub_type_soal'];

        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->save([
            'type_soal' => $menuSoal,
            'sub_type_soal' => $submenuSoal,
            'id_soal' => uniqid(),
            'soal' => $new_soal,
            'option_a' => $new_option_a,
            'option_b' => $new_option_b,
            'option_c' => $new_option_c,
            'option_d' => $new_option_d,
            'option_e' => $new_option_e,
            'jawaban' => $getBankSoal['jawaban'],
            'ans_id' => $getBankSoal['ans_id'],
            'pembahasan' => $new_pembahasan,
            'value' => $getBankSoal['value']
        ]);

        $TypeSoalModel = $this->typeSoalModel;
        $getTypeSoal = $TypeSoalModel->where(['id_main_type_soal' => $menuSoal])->first();
        $typeSoalId = explode(",", $getTypeSoal['list_type_soal_id']);
        $valueSoal = explode(",", $getTypeSoal['list_type_soal_jumlah']);
        $arrayLong = sizeof($valueSoal);
        for ($i = 0; $i < $arrayLong; $i++) {
            if ($typeSoalId[$i] == $submenuSoal) {
                $valueSoal[$i] = $valueSoal[$i] + 1;
            }
        };

        $TypeSoalModel->update($getTypeSoal['id'], [
            'list_type_soal_jumlah' => join(",", $valueSoal)
        ]);

        session()->setFlashdata('success', "Soal Berhasil Diduplikat.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function update_soal()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $menuSoal = $this->request->getVar('MenuSoal');
        $submenuSoal = $this->request->getVar('SubmenuSoal');

        if (!$this->validate([
            'editorQuestion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Soal Harus Diisi',
                ]
            ],
            'option_a' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan A Harus Diisi',
                ]
            ],
            'option_b' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan B Harus Diisi',
                ]
            ],
            'option_c' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan C Harus Diisi',
                ]
            ],
            'option_d' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan D Harus Diisi',
                ]
            ],
            'option_e' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilihan E Harus Diisi',
                ]
            ],
            'checkbox' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jawaban Soal Belum Dipilih',
                ]
            ],
            'questionValue' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Point Soal Harus Diisi',
                ]
            ],
            'editorExplanation' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pembahasan Harus Diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Soal Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/input_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
        }

        $cleanList = ['<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '<p><br></p>', '<p>', '</p>'];
        $optionA = $this->request->getVar('option_a');
        $optionB = $this->request->getVar('option_b');
        $optionC = $this->request->getVar('option_c');
        $optionD = $this->request->getVar('option_d');
        $optionE = $this->request->getVar('option_e');
        foreach ($cleanList as $cl) {
            $optionA = str_replace($cl, '', $optionA);
            $optionB = str_replace($cl, '', $optionB);
            $optionC = str_replace($cl, '', $optionC);
            $optionD = str_replace($cl, '', $optionD);
            $optionE = str_replace($cl, '', $optionE);
        };

        $questionAns = $this->request->getVar('checkbox');
        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->update($this->request->getVar('id'), [
            'soal' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('editorQuestion')),
            'option_a' => $optionA,
            'option_b' => $optionB,
            'option_c' => $optionC,
            'option_d' => $optionD,
            'option_e' => $optionE,
            'jawaban' => md5($questionAns[0]),
            'ans_id' => $questionAns[0],
            'pembahasan' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $this->request->getVar('editorExplanation')),
            'value' => $this->request->getVar('questionValue')
        ]);

        session()->setFlashdata('success_ubah', "Soal Berhasil Diubah.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function upload_image()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        try {
            $allowExt = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if (in_array(strtolower($extension), $allowExt)) {
                $fileupload_name = sha1(microtime()) . "." . $extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "/assets/upload_image/" . $fileupload_name);

                $response = array();
                $response['tokenName'] = csrf_token();
                $response['tokenValue'] = csrf_hash();
                $response["link"] = "/assets/upload_image/" . $fileupload_name;
                return $this->response->setJSON($response);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(404);
        }
    }

    public function deleted_image()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $src = str_replace(base_url('/'), "", $data['src']);
        if (file_exists(getcwd() . $src)) {
            unlink(getcwd() . $src);
        }

        $response = array();
        $response['tokenName'] = csrf_token();
        $response['tokenValue'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    public function deleted_soal($id_soal)
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $bank_soal = $this->bankSoalModel;
        $selectedSoal = $bank_soal->where(['id_soal' => $id_soal])->first();
        $cekInQuiz = $this->bankQuizModel->where(['quiz_question' => $id_soal])->first();
        $explodeSoal = explode('/assets/upload_image/', $selectedSoal['soal']);
        $explodePembahasan = explode('/assets/upload_image/', $selectedSoal['pembahasan']);
        $explodeoptionA = explode('/assets/upload_image/', $selectedSoal['option_a']);
        $explodeoptionB = explode('/assets/upload_image/', $selectedSoal['option_b']);
        $explodeoptionC = explode('/assets/upload_image/', $selectedSoal['option_c']);
        $explodeoptionD = explode('/assets/upload_image/', $selectedSoal['option_d']);
        $explodeoptionE = explode('/assets/upload_image/', $selectedSoal['option_e']);

        $menuSoal = $selectedSoal['type_soal'];
        $submenuSoal = $selectedSoal['sub_type_soal'];

        if (!$cekInQuiz) {
            if ($selectedSoal) {
                foreach ($explodeSoal as $es) {
                    $cekExplode = explode('"', $es);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                foreach ($explodePembahasan as $ep) {
                    $cekExplode = explode('"', $ep);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                foreach ($explodeoptionA as $ep) {
                    $cekExplode = explode('"', $ep);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                foreach ($explodeoptionB as $ep) {
                    $cekExplode = explode('"', $ep);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                foreach ($explodeoptionC as $ep) {
                    $cekExplode = explode('"', $ep);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                foreach ($explodeoptionD as $ep) {
                    $cekExplode = explode('"', $ep);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                foreach ($explodeoptionE as $ep) {
                    $cekExplode = explode('"', $ep);
                    if (str_contains($cekExplode[0], ".jpg") || str_contains($cekExplode[0], ".png") || str_contains($cekExplode[0], ".jpeg")) {
                        $oldImg = $cekExplode[0];
                        $src = "/assets/upload_image/" . $oldImg;
                        if (file_exists($src)) {
                            unlink(getcwd() . $src);
                        }
                    }
                }

                $TypeSoalModel = $this->typeSoalModel;
                $getTypeSoal = $TypeSoalModel->where(['id_main_type_soal' => $menuSoal])->first();
                $typeSoalId = explode(",", $getTypeSoal['list_type_soal_id']);
                $valueSoal = explode(",", $getTypeSoal['list_type_soal_jumlah']);
                $arrayLong = sizeof($valueSoal);
                for ($i = 0; $i < $arrayLong; $i++) {
                    if ($typeSoalId[$i] == $submenuSoal) {
                        $valueSoal[$i] = $valueSoal[$i] - 1;
                    }
                };

                $TypeSoalModel->update($getTypeSoal['id'], [
                    'list_type_soal_jumlah' => join(",", $valueSoal)
                ]);

                $bank_soal->delete($selectedSoal['id']);
                session()->setFlashdata('success', "Soal Berhasil Di Hapus");
            }
        } else {
            session()->setFlashdata('failed', "Soal gagal dihapus karena terdaftar dalam quiz " . $cekInQuiz['quiz_name']);
        }
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    // QUIZ SECTION
    public function quiz()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $quiz = $this->quizModel->findAll();
        $bankQuiz = $this->bankQuizModel->groupBy('quiz_id')->findAll();
        $category = $this->categoryQuizModel->findAll();

        $data = [
            'title' => 'Quiz Schuler.id',
            'user_name' => $user['username'],
            'quiz_type' => $quiz,
            'bank_quiz' => $bankQuiz,
            'category_quiz' =>  $category
        ];

        return view('admin/input-quiz/quiz', $data);
    }

    public function daftar_quiz()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $slug = $this->request->getVar('slug');
        $quizListQuestion = $this->bankQuizModel->groupBy(['quiz_id'])->where(['quiz_type' => $slug])->findAll();
        $number_soal = [];
        foreach ($quizListQuestion as $qlQ) {
            $data_number = $this->bankQuizModel->where(['quiz_id' => $qlQ['quiz_id']])->countAllResults();
            array_push($number_soal, $data_number);
        }
        $data = [
            'title' => 'Daftar Quiz Schuler.id',
            'user_name' => $user['username'],
            'bankQuiz' => $quizListQuestion,
            'quiz_number' => $number_soal

        ];

        return view('admin/input-quiz/daftar-quiz', $data);
    }

    public function input_quiz()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $slug = $this->request->getVar('slug');
        $getBankSoalSubject = $this->categoryQuizModel->where(['slug' => $slug])->first();
        if (!$getBankSoalSubject) return redirect()->to(base_url('admin/quiz'));

        $getBankSoalSubject = explode(',', $getBankSoalSubject['category_item']);
        for ($j = 0; $j < count($getBankSoalSubject); $j++) {
            $getTypeSoal = $this->typeSoalModel->where([
                'id_main_type_soal' => $getBankSoalSubject[$j]
            ])->first();

            $subTypeListId = explode(',', $getTypeSoal['list_type_soal_id']);
            $subTypeListName = explode(',', $getTypeSoal['list_type_soal']);

            $subjectName[] = [
                'type_soal_id' => $getBankSoalSubject[$j],
                'type_soal_name' => $getTypeSoal['slug'],
            ];

            for ($i = 0; $i < count($subTypeListId); $i++) {
                $subjectName[$j][$subTypeListId[$i]] = $subTypeListName[$i];
            }
        }

        $remakBankSoal = [];
        $getBankSoal = $this->bankSoalModel->orderBy('sub_type_soal')->findAll();
        foreach ($getBankSoal as $bs) {
            for ($i = 0; $i < sizeof($subjectName); $i++) {
                $cekSoal = $this->bankQuizModel->where(['quiz_question' => $bs['id_soal']])->findAll();
                if (!$cekSoal) {
                    if ($subjectName[$i]['type_soal_id'] == $bs['type_soal']) {
                        array_push($remakBankSoal, $bs);
                    }
                }
            }
        }

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'soal_subject' => $subjectName,
            'bank_soal' => $remakBankSoal,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/input-quiz/input-quiz', $data);
    }

    public function save_quiz()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $uri = current_url(true)->getSegment(4);
        $quizType = $this->request->getVar('slug');
        $quizName = $this->request->getVar('QuizName');
        $quizListQuestion = $this->request->getVar('quiz_list_question');
        $quizId = Uuid::uuid4();

        if (!$this->validate([
            'QuizName' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Quiz Harus Diisi',
                ]
            ]
        ])) {
            session()->setFlashdata('failed', "Quiz Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/input_quiz'))->withInput();
        }

        if (!$quizListQuestion) {
            session()->setFlashdata('failed', "Quiz Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/input_quiz'))->withInput();
        }

        foreach ($quizListQuestion as $qLQ) {
            $bankSoalData = $this->bankSoalModel->where(['id_soal' => $qLQ])->first();
            $this->bankQuizModel->save([
                'quiz_id' => $quizId,
                'quiz_name' => $quizName,
                'quiz_subject' => $bankSoalData['type_soal'],
                'quiz_sub_subject' => $bankSoalData['sub_type_soal'],
                'quiz_question' => $qLQ,
                'quiz_type' => $quizType,
                'quiz_category' => $uri,
            ]);
        }

        return redirect()->to(base_url('admin/daftar_quiz/' . $uri . '?slug=' . $quizType))->withInput();
    }

    public function detail_quiz($quiz_id)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $quiz_id])->findAll();
        $slug = $this->request->getVar('slug');
        $getBankSoal = $this->bankSoalModel->orderBy('sub_type_soal')->findAll();
        $getBankSoalSubject = $this->categoryQuizModel->where(['slug' => $slug])->first();
        if (!$getBankSoalSubject) return redirect()->to(base_url('admin/quiz'));
        $quiz_name = $bankQuiz[0]['quiz_name'];
        $bank_quiz_soal = [];
        $bankSoal = [];
        $bankSoalOption = [];
        foreach ($bankQuiz as $bq) {
            array_push($bank_quiz_soal, $bq['quiz_question']);
        }

        foreach ($getBankSoal as $gBs) {
            if (in_array($gBs['id_soal'], $bank_quiz_soal)) {
                array_push($bankSoal, $gBs);
            } else {
                array_push($bankSoalOption, $gBs);
            }
        }

        $getBankSoalSubject = explode(',', $getBankSoalSubject['category_item']);
        for ($j = 0; $j < count($getBankSoalSubject); $j++) {
            $getTypeSoal = $this->typeSoalModel->where([
                'id_main_type_soal' => $getBankSoalSubject[$j]
            ])->first();

            $subTypeListId = explode(',', $getTypeSoal['list_type_soal_id']);
            $subTypeListName = explode(',', $getTypeSoal['list_type_soal']);

            $subjectName[] = [
                'type_soal_id' => $getBankSoalSubject[$j],
                'type_soal_name' => $getTypeSoal['slug'],
            ];

            for ($i = 0; $i < count($subTypeListId); $i++) {
                $subjectName[$j][$subTypeListId[$i]] = $subTypeListName[$i];
            }
        }

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'soal_subject' => $subjectName,
            'bank_soal' => $bankSoal,
            'bank_soal_option' => $bankSoalOption,
            'quiz_name' => $quiz_name,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/input-quiz/detail-quiz', $data);
    }

    public function delete_soal_quiz()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $quiz_id = $this->request->getVar('quiz_id');
        $soal_id = $this->request->getVar('id_soal');
        $slug = $this->request->getVar('slug');
        $u = $this->request->getVar('u');

        $bankQuiz = $this->bankQuizModel->where([
            'quiz_id' => $quiz_id,
            'quiz_question' => $soal_id
        ])->first();

        if ($bankQuiz) {
            $cekHistory = $this->userHistoryModel->where([
                'quiz_id' => $bankQuiz['quiz_id'],
            ])->findAll();

            if ($cekHistory) {
                foreach ($cekHistory as $h) {
                    $this->userHistoryModel->delete($h['id']);
                }
            }

            $cekHistoryUtbk = $this->userHistoryUtbkModel->where([
                'quiz_id' => $bankQuiz['quiz_id'],
            ])->findAll();

            if ($cekHistoryUtbk) {
                foreach ($cekHistoryUtbk as $h) {
                    $this->userHistoryUtbkModel->delete($h['id']);
                }
            }

            $this->bankQuizModel->delete($bankQuiz['id']);
            return redirect()->to(base_url('admin/detail_quiz' . '/' . $quiz_id . '?slug=' . $slug . '&' . 'u=' . $u));
        } else {
            return redirect()->to(base_url('admin/quiz'));
        }
    }

    public function save_soal_quiz()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $quiz_id = $this->request->getVar('quiz_id');
        $slug = $this->request->getVar('slug');
        $u = $this->request->getVar('u');

        $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $quiz_id])->first();
        $quizName = $bankQuiz['quiz_name'];
        $quizListQuestion = $this->request->getVar('quiz_list_question');

        if (!$quizListQuestion) {
            session()->setFlashdata('failed', "Soal Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/detail_quiz' . '/' . $quiz_id . '?slug=' . $slug . '&' . 'u=' . $u))->withInput();
        }

        foreach ($quizListQuestion as $qLQ) {
            $bankSoalData = $this->bankSoalModel->where(['id_soal' => $qLQ])->first();
            $this->bankQuizModel->save([
                'quiz_id' => $quiz_id,
                'quiz_name' => $quizName,
                'quiz_subject' => $bankSoalData['type_soal'],
                'quiz_sub_subject' => $bankSoalData['sub_type_soal'],
                'quiz_question' => $qLQ,
                'quiz_type' => $slug,
                'quiz_category' => $u,
            ]);
        }

        $cekHistory = $this->userHistoryModel->where([
            'quiz_id' => $bankQuiz['quiz_id'],
        ])->findAll();

        if ($cekHistory) {
            foreach ($cekHistory as $h) {
                $this->userHistoryModel->delete($h['id']);
            }
        }

        $cekHistoryUtbk = $this->userHistoryUtbkModel->where([
            'quiz_id' => $bankQuiz['quiz_id'],
        ])->findAll();

        if ($cekHistoryUtbk) {
            foreach ($cekHistoryUtbk as $h) {
                $this->userHistoryUtbkModel->delete($h['id']);
            }
        }

        return redirect()->to(base_url('admin/detail_quiz' . '/' . $quiz_id . '?slug=' . $slug . '&' . 'u=' . $u));
    }

    public function deleted_quiz($quiz_id)
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $uri = $this->request->getVar('u');
        $slug = $this->request->getVar('slug');
        $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $quiz_id])->findAll();
        $cekHistory = $this->userHistoryModel->where([
            'quiz_id' => $bankQuiz[0]['quiz_id'],
        ])->findAll();


        if ($cekHistory) {
            foreach ($cekHistory as $h) {
                $this->userHistoryModel->delete($h['id']);
            }
        }

        $cekHistoryUtbk = $this->userHistoryUtbkModel->where([
            'quiz_id' => $bankQuiz[0]['quiz_id'],
        ])->findAll();

        if ($cekHistoryUtbk) {
            foreach ($cekHistoryUtbk as $h) {
                $this->userHistoryUtbkModel->delete($h['id']);
            }
        }

        foreach ($bankQuiz as $bq) {
            $this->bankQuizModel->delete($bq['id']);
        }
        return redirect()->to(base_url('admin/daftar_quiz/' . $uri . '?slug=' . $slug));
    }

    public function input_kampus()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $kampus = $this->universitasModel->findAll();

        $data = [
            'title' => 'Daftar Quiz Schuler.id',
            'user_name' => $user['username'],
            'daftar_Kampus' => $kampus,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/input-kampus', $data);
    }

    public function save_kampus()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        if (!$this->validate([
            'nama_kampus' => [
                'rules' => 'required|is_unique[universitas.nama_universitas]',
                'errors' => [
                    'required' => 'Nama Kampus Harus Diisi',
                ]
            ]
        ])) {
            session()->setFlashdata('failed', "Kampus Gagal Ditambahkan.");
            return redirect()->to(base_url('admin/input_kampus'))->withInput();
        }

        $this->universitasModel->save([
            'id_universitas' => uniqid(),
            'nama_universitas' => strtoupper($this->request->getVar('nama_kampus'))
        ]);

        session()->setFlashdata('success', "Kampus Berhasil Ditambahkan.");
        return redirect()->to(base_url('admin/input_kampus'));
    }

    public function deleted_kampus($universitas_id)
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $kampus = $this->universitasModel->where(['id_universitas' => $universitas_id])->first();

        $this->universitasModel->delete($kampus['id']);
        return redirect()->to(base_url('admin/input_kampus'));
    }

    public function session_login()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $user = $this->usersModel->where(['email' => session()->get('username')])->first();

        $response = array();
        if ($user['login_session'] != session()->get('session_id')) {
            $response['status'] = "Logout";
        } else {
            $response['status'] = "Login";
        }

        return $this->response->setJSON($response);
    }

    // ERROR
    public function error_404()
    {
        return view('errors/html/error_404');
    }

    public function clean()
    {
        $bankSoal = $this->bankSoalModel->findAll();
        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('<p></p>', '', $bs['option_a']),
                    'option_b' => str_replace('<p></p>', '', $bs['option_b']),
                    'option_c' => str_replace('<p></p>', '', $bs['option_c']),
                    'option_d' => str_replace('<p></p>', '', $bs['option_d']),
                    'option_e' => str_replace('<p></p>', '', $bs['option_e']),
                ]
            );
        }

        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('<p id="isPasted">', '', $bs['option_a']),
                    'option_b' => str_replace('<p id="isPasted">', '', $bs['option_b']),
                    'option_c' => str_replace('<p id="isPasted">', '', $bs['option_c']),
                    'option_d' => str_replace('<p id="isPasted">', '', $bs['option_d']),
                    'option_e' => str_replace('<p id="isPasted">', '', $bs['option_e']),
                ]
            );
        }

        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('</p>', '', $bs['option_a']),
                    'option_b' => str_replace('</p>', '', $bs['option_b']),
                    'option_c' => str_replace('</p>', '', $bs['option_c']),
                    'option_d' => str_replace('</p>', '', $bs['option_d']),
                    'option_e' => str_replace('</p>', '', $bs['option_e']),
                ]
            );
        }

        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['option_a']),
                    'option_b' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['option_b']),
                    'option_c' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['option_c']),
                    'option_d' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['option_d']),
                    'option_e' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['option_e']),
                    'pembahasan' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['pembahasan']),
                    'soal' => str_replace('<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>', '', $bs['soal'])
                ]
            );
        }

        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('<p><br></p>', '', $bs['option_a']),
                    'option_b' => str_replace('<p><br></p>', '', $bs['option_b']),
                    'option_c' => str_replace('<p><br></p>', '', $bs['option_c']),
                    'option_d' => str_replace('<p><br></p>', '', $bs['option_d']),
                    'option_e' => str_replace('<p><br></p>', '', $bs['option_e']),
                ]
            );
        }

        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('</p>', '', $bs['option_a']),
                    'option_b' => str_replace('</p>', '', $bs['option_b']),
                    'option_c' => str_replace('</p>', '', $bs['option_c']),
                    'option_d' => str_replace('</p>', '', $bs['option_d']),
                    'option_e' => str_replace('</p>', '', $bs['option_e']),
                ]
            );
        }

        foreach ($bankSoal as $bs) {
            $this->bankSoalModel->update(
                $bs['id'],
                [
                    'option_a' => str_replace('<p>', '', $bs['option_a']),
                    'option_b' => str_replace('<p>', '', $bs['option_b']),
                    'option_c' => str_replace('<p>', '', $bs['option_c']),
                    'option_d' => str_replace('<p>', '', $bs['option_d']),
                    'option_e' => str_replace('<p>', '', $bs['option_e']),
                ]
            );
        }
    }
}
