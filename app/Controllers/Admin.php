<?php

namespace App\Controllers;

use App\Models\TypeSoalModel;
use App\Models\RefCategoryModel;
use App\Models\RefSubCategoryModel;
use App\Models\RefSumberPaketModel;
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
    protected $refCategoryModel;
    protected $refSubCategoryModel;
    protected $refSumberPaketModel;
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
        $this->refCategoryModel = new RefCategoryModel();
        $this->refSubCategoryModel = new RefSubCategoryModel();
        $this->refSumberPaketModel = new RefSumberPaketModel();
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

        $refCategory = $this->refCategoryModel->findAll();
        $refSubCategory = $this->refSubCategoryModel->findAll();

        $data = [
            'title' => 'Bank Soal Schuler.id',
            'user_name' => $user['username'],
            'category' => $refCategory,
            'sub_category' => $refSubCategory
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

    public function daftar_soal($categoryId, $subCategoryId)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $bankSoalModel = $this->bankSoalModel->where([
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId
        ])->findAll();

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoalModel,
            'category' => $categoryId,
            'sub_category' => $subCategoryId
        ];

        return view('admin/bank-soal/daftar-soal', $data);
    }

    public function input_soal($category, $sub_category)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();

        $refSumberPaket = $this->refSumberPaketModel->findAll();

        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'category' => $category,
            'ref_sumber' => $refSumberPaket,
            'sub_category' => $sub_category,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/bank-soal/input-soal', $data);
    }

    public function edit_soal($idSoal)
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $bankSoalModel = $this->bankSoalModel->where([
            'id' => $idSoal
        ])->first();

        $refSumberPaket = $this->refSumberPaketModel->findAll();

        $listOption = ['option_a', 'option_b', 'option_c', 'option_d', 'option_e'];
        foreach ($listOption as $lo) {
            if (md5($lo) == $bankSoalModel['jawaban']) {
                $questionAns = $lo;
            }
        }

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'category' => $bankSoalModel['category_id'],
            'ref_sumber' => $refSumberPaket,
            'sub_category' => $bankSoalModel['sub_category_id'],
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

        $category = $this->request->getVar('category');
        $subCategory = $this->request->getVar('sub_category');
        $sumberPaket = $this->request->getVar('sumberPaket');
        $nomorSoal = $this->request->getVar('nomorSoal');
        $paketSoal = $this->request->getVar('paketSoal');
        $tahun = date('Y');

        $refSubCategory = $this->refSubCategoryModel->where(['id' => $subCategory])->first();
        $refSumberPaket = $this->refSumberPaketModel->where(['id' => $sumberPaket])->first();
        $kodeSoal = $tahun . $refSumberPaket['kode'] . '-' . $paketSoal . $refSubCategory['kode'] . '-' . $nomorSoal;

        if (!$this->validate([
            'editorQuestion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Soal Harus Diisi',
                ]
            ],
            'nomorSoal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Soal Harus Diisi',
                ]
            ],
            'paketSoal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Paket Soal Harus Diisi',
                ]
            ],
            'sumberPaket' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Sumber Paket Soal Harus Dipilih',
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
            return redirect()->to(base_url('admin/input_soal/' . $category . '/' . $subCategory))->withInput();
        }

        $questionAns = $this->request->getVar('checkbox');
        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->save([
            'type_soal' => $category,
            'sub_type_soal' => $subCategory,
            'category_id' => $category,
            'sub_category_id' => $subCategory,
            'sumber_id' => $sumberPaket,
            'nomor_soal' => $nomorSoal,
            'paket_soal' => $paketSoal,
            'tahun' => $tahun,
            'kode_soal' => $kodeSoal,
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

        $subCategoryModel = $this->refSubCategoryModel;
        $currentCategoryState = $subCategoryModel->where(['id' => $subCategory])->first();

        $subCategoryModel->update($subCategory, [
            'jumlah' => $currentCategoryState['jumlah'] + 1
        ]);

        session()->setFlashdata('success', "Soal Berhasil Ditambahkan.");
        return redirect()->to(base_url('admin/daftar_soal/' . $category . '/' . $subCategory))->withInput();
    }

    public function duplicat_soal($idSoal)
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $getBankSoal = $this->bankSoalModel->where([
            'id' => $idSoal
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

        $category = $getBankSoal['category_id'];
        $subCategory = $getBankSoal['sub_category_id'];
        $sumberPaket = $getBankSoal['sumber_id'];
        $nomorSoal = $getBankSoal['nomor_soal'];
        $paketSoal = $getBankSoal['paket_soal'];
        $tahun = date('Y');

        $refSubCategory = $this->refSubCategoryModel->where(['id' => $subCategory])->first();
        $refSumberPaket = $this->refSumberPaketModel->where(['id' => $sumberPaket])->first();
        $kodeSoal = $tahun . $refSumberPaket['kode'] . '-' . $paketSoal . $refSubCategory['kode'] . '-' .  $nomorSoal;

        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->save([
            'type_soal' => $category,
            'sub_type_soal' => $subCategory,
            'category_id' => $category,
            'sub_category_id' => $subCategory,
            'sumber_id' => $sumberPaket,
            'nomor_soal' => $nomorSoal,
            'paket_soal' => $paketSoal,
            'tahun' => $tahun,
            'kode_soal' => $kodeSoal,
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


        $subCategoryModel = $this->refSubCategoryModel;
        $currentCategoryState = $subCategoryModel->where(['id' => $subCategory])->first();

        $subCategoryModel->update($subCategory, [
            'jumlah' => $currentCategoryState['jumlah'] + 1
        ]);

        session()->setFlashdata('success', "Soal Berhasil Diduplikat.");
        return redirect()->to(base_url('admin/daftar_soal/' . $category . '/' . $subCategory))->withInput();
    }

    public function update_soal()
    {
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $category = $this->request->getVar('category');
        $subCategory = $this->request->getVar('sub_category');
        $sumberPaket = $this->request->getVar('sumberPaket');
        $nomorSoal = $this->request->getVar('nomorSoal');
        $paketSoal = $this->request->getVar('paketSoal');
        $tahun = date('Y');

        $refSubCategory = $this->refSubCategoryModel->where(['id' => $subCategory])->first();
        $refSumberPaket = $this->refSumberPaketModel->where(['id' => $sumberPaket])->first();
        $kodeSoal = $tahun . $refSumberPaket['kode'] . '-' . $paketSoal . $refSubCategory['kode'] . '-' . $nomorSoal;

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
            return redirect()->to(base_url('admin/input_soal/' . $category . '/' . $subCategory))->withInput();
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
            'sumber_id' => $sumberPaket,
            'nomor_soal' => $nomorSoal,
            'tahun' => $tahun,
            'kode_soal' => $kodeSoal,
            'paket_soal' => $paketSoal,
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
        return redirect()->to(base_url('admin/daftar_soal/' . $category . '/' . $subCategory))->withInput();
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
        $selectedSoal = $bank_soal->where(['id' => $id_soal])->first();
        $cekInQuiz = $this->bankQuizModel->where(['quiz_question' => $id_soal])->first();
        $explodeSoal = explode('/assets/upload_image/', $selectedSoal['soal']);
        $explodePembahasan = explode('/assets/upload_image/', $selectedSoal['pembahasan']);
        $explodeoptionA = explode('/assets/upload_image/', $selectedSoal['option_a']);
        $explodeoptionB = explode('/assets/upload_image/', $selectedSoal['option_b']);
        $explodeoptionC = explode('/assets/upload_image/', $selectedSoal['option_c']);
        $explodeoptionD = explode('/assets/upload_image/', $selectedSoal['option_d']);
        $explodeoptionE = explode('/assets/upload_image/', $selectedSoal['option_e']);

        $category = $selectedSoal['category_id'];
        $subCategory = $selectedSoal['sub_category_id'];

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

                $subCategoryModel = $this->refSubCategoryModel;
                $currentCategoryState = $subCategoryModel->where(['id' => $subCategory])->first();

                $subCategoryModel->update($subCategory, [
                    'jumlah' => $currentCategoryState['jumlah'] - 1
                ]);

                $bank_soal->delete($selectedSoal['id']);
                session()->setFlashdata('success', "Soal Berhasil Di Hapus");
            }
        } else {
            session()->setFlashdata('failed', "Soal gagal dihapus karena terdaftar dalam quiz " . $cekInQuiz['quiz_name']);
        }
        return redirect()->to(base_url('admin/daftar_soal/' . $category . '/' . $subCategory))->withInput();
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
        $quizListQuestion = $this->bankQuizModel->groupBy(['quiz_id'])->where(['quiz_type' => $slug])->orderBy('id')->findAll();

        foreach ($quizListQuestion as $qlQ) {
            $data_number = $this->bankQuizModel->where(['quiz_id' => $qlQ['quiz_id']])->countAllResults();
            $remakeBankQuiz[] = [
                'quiz_id' => $qlQ['quiz_id'],
                'quiz_name' => $qlQ['quiz_name'],
                'quiz_category' => $qlQ['quiz_category'],
                'number_soal' => $data_number,
            ];
        }


        $data = [
            'title' => 'Daftar Quiz Schuler.id',
            'user_name' => $user['username'],
            'bankQuiz' => $remakeBankQuiz,
        ];

        return view('admin/input-quiz/daftar-quiz', $data);
    }

    public function input_quiz()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'admin super') {
            return redirect()->to(base_url('home/error_404'));
        }

        $refCategory = $this->refCategoryModel->findAll();
        $refSubCategory = $this->refSubCategoryModel->findAll();

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
        $getBankSoal = $this->bankSoalModel->orderBy('sub_category_id')->findAll();
        foreach ($getBankSoal as $bs) {
            for ($i = 0; $i < sizeof($refCategory); $i++) {
                $cekSoal = $this->bankQuizModel->where(['quiz_question' => $bs['id_soal']])->findAll();
                if (!$cekSoal) {
                    if ($refCategory[$i]['kode'] == $bs['category_id']) {
                        array_push($remakBankSoal, $bs);
                    }
                }
            }
        }

        usort($remakBankSoal, function ($a, $b) {
            if ($a['sub_category_id'] === $b['sub_category_id']) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            } else {
                return strcmp($a['sub_category_id'], $b['sub_category_id']);
            }
        });

        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => $user['username'],
            'category' => $refCategory,
            'sub_category' => $refSubCategory,
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
        $getBankSoal = $this->bankSoalModel->orderBy('created_at')->findAll();
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

        usort($bankSoal, function ($a, $b) {
            if ($a['sub_type_soal'] === $b['sub_type_soal']) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            } else {
                return strcmp($a['sub_type_soal'], $b['sub_type_soal']);
            }
        });

        usort($bankSoalOption, function ($a, $b) {
            if ($a['sub_type_soal'] === $b['sub_type_soal']) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            } else {
                return strcmp($a['sub_type_soal'], $b['sub_type_soal']);
            }
        });

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

    public function renew_bank_soal()
    {
        $bank_soal = $this->bankSoalModel->findAll();

        $listType = [
            '22b9f14e-867a-41d0-a758-55070c6bd603' => 1,
            '399da42a-5c50-431e-8601-7cb58c30e1e8' => 2,
            'abca1845-062f-46dc-8eb3-56ff6dc0508c' => 2,
            'ef304127-7592-422d-ab27-7248c4a706c9' => 2,
            '8a7baa68-e091-498e-821c-fed64230e12f' => 3,
            'ee88908b-8d8c-4815-8898-f6bd6d07b147' => 4,
            '33c2f14e-867z-41d9-d758-34070c6bd603' => 0
        ];

        $listSubType = [
            '9b97b305-93c0-49d0-b60b-5ae02315a62f' => 1,
            'b664ce29-a532-47aa-a56c-6cd911ddbd9d' => 2,
            'be81bf87-f836-4e14-bf36-b5b4310a285a' => 3,
            '5d79fefb-1c32-48cb-a576-c7b37a7d31b9' => 4,
            '06834f36-fee9-4f77-a7e1-cb1509514dc7' => 5,
            'ze85bf87-f892-5h15-bf36-j1k4310a292z' => 6,
            'v665ce29-j537-47aa-x56w-6cd956ddbd9m' => 7,
            'f9ff51b1-36b0-4023-8f2c-63bc567bc0a1' => 8,
            'c4dde305-7508-4e5c-acdd-7be0af66e133' => 9,
            'c8d8ada8-bbb0-4b1c-a2bd-5f26321ebd87' => 10,
            '77090d1a-07cd-4123-8bbf-8e288ef0fbe0' => 11,
            '3c7ae53c-4999-4857-bb8f-b258c7c6fc25' => 12,
            '6f27c012-4ac2-4340-94c4-d425e3b23fc4' => 13,
            '221586a5-79b6-4199-a5d6-3557d3ff8635' => 14,
            'dec0e691-7f62-4766-972b-32cc5f6db700' => 15,
            '3u97b382-51c0-49d0-b60b-9st02315a62f' => 0
        ];

        $db = \Config\Database::connect();
        $builder = $db->query('SELECT bank_soal.id, bank_soal.tahun,bank_soal.nomor_soal, bank_soal.paket_soal ref_sumber_paket.kode as sumber_paket_kode, ref_sub_category.kode as sub_category_kode FROM bank_soal INNER JOIN ref_sumber_paket ON ref_sumber_paket.id = bank_soal.sumber_id INNER JOIN ref_category ON ref_category.id = bank_soal.category_id INNER JOIN ref_sub_category ON ref_sub_category.id = bank_soal.sub_category_id');

        $result = $builder->getResult();

        foreach ($result as $row) {
            $kodeSoal = $row->tahun . $row->sumber_paket_kode . '-' . $row->paket_soal . $row->sub_category_kode . '-' . $row->nomor_soal;

            $idSoal = (int) $row->id;

            $db->table('bank_soal')->where('id', $idSoal)->update([
                'kode_soal' => $kodeSoal
            ]);
        }

        // dd($result[0]->tahun . $result[0]->sumber_paket_kode . $result[0]->category_kode . $result[0]->sub_category_kode . $result[0]->category_kode);

        // foreach ($bank_soal as $bs) {
        //     $categoryId = $listType[$bs['type_soal']];
        //     $subCategoryId = $listSubType[$bs['sub_type_soal']];
        //     $tahun = date('Y', strtotime($bs['created_at']));
        //     $this->bankSoalModel->update(
        //         $bs['id'],
        //         [
        //             'category_id' => $categoryId,
        //             'sub_category_id' => $subCategoryId,
        //             'tahun' => $tahun
        //         ]
        //     );
        // };

        // dd('done');
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
