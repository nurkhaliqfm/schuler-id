<?php

namespace App\Controllers;

use App\Models\TypeSoalModel;
use App\Models\BankSoalModel;
use App\Models\BankQuizModel;
use App\Models\QuizModel;
use App\Models\CategoryQuizModel;
use App\Models\UserHistoryModel;
use App\Models\UserHistoryUtbkModel;
use stdClass;

class Home extends BaseController
{
    protected $typeSoalModel;
    protected $bankSoalModel;
    protected $bankQuizModel;
    protected $quizModel;
    protected $categoryQuizModel;
    protected $userHistoryModel;
    protected $userHistoryUtbkModel;

    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->bankQuizModel = new BankQuizModel();
        $this->quizModel = new QuizModel();
        $this->categoryQuizModel = new CategoryQuizModel();
        $this->userHistoryModel  = new UserHistoryModel();
        $this->userHistoryUtbkModel  = new UserHistoryUtbkModel();
    }

    public function index()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => $user['username']
        ];

        return view('home/dashboard', $data);
    }

    // PROGRAM KHUSUS
    public function super_camp_utbk()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $data = [
            'title' => 'Super Camp UTBK Schuler.id',
            'user_name' => $user['username']
        ];

        return view('home/program-khusus/super-camp-utbk', $data);
    }

    // MENU UTBK LATIHAN
    public function daftar_latihan()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $categoryQuiz = $this->categoryQuizModel->where(['group' => '0'])->findAll();
        $data = [
            'title' => 'Daftar Latihan Schuler.id',
            'user_name' => $user['username'],
            'data_type' => $categoryQuiz
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-list', $data);
    }

    public function latihan_home($slug = "")
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'slug' => $slug,
            'group' => '0'
        ])->first();
        if (!$cekCategoryQuiz) return redirect()->to(base_url('home/daftar_latihan'));
        $idCategoryQuiz = explode(',', $cekCategoryQuiz['category_item']);

        foreach ($idCategoryQuiz as $id) {
            $getTypeSoal = $this->typeSoalModel->where(['id_main_type_soal' => $id])->first();
            $typeSoal[] = [
                'id' => $id,
                'name' => $getTypeSoal['main_type_soal'],
                'slug' => $getTypeSoal['slug'],
            ];
        }

        if (!$cekCategoryQuiz) {
            return redirect()->to(base_url('home/daftar_latihan'));
        }

        $remakeBankQuiz = [];
        $filterCategory = $this->categoryQuizModel->where(['slug' => $slug])->first();
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'practice'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $dataremakeBankQuiz = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => $timer['quiz_timer'] / 60
            );

            array_push($remakeBankQuiz, $dataremakeBankQuiz);
        }

        $data = [
            'title' => 'Daftar Latihan Schuler.id',
            'user_name' => $user['username'],
            'quiz_group' => $slug,
            'type_soal' => $typeSoal,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $filterCategory['category_item']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-home', $data);
    }

    public function latihan_guide()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();

        $data = [
            'title' => 'Petunjuk Latihan Schuler.id',
            'user_name' => $user['username'],
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-guide', $data);
    }

    public function kerjakan_latihan()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $quizData = $this->bankQuizModel->where([
            'quiz_id' => $query
        ])->findAll();

        $bankSoal = $this->bankSoalModel->findAll();
        $typeSoal = $this->typeSoalModel->findAll();
        $navbarTitle = $quizData[0]['quiz_name'];
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $quizData[0]['quiz_category']])->first();

        $data = [
            'title' => 'Kerjakan Latihan Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'type_soal' => $typeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-main', $data);
    }

    public function save_hasil_latihan()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $quizData = $this->bankQuizModel->where([
            'quiz_id' => $data['quiz_id']
        ])->findAll();


        foreach ($quizData as $qd) {
            if (array_key_exists($qd['quiz_question'], $data)) {
                $id_soal[] =  $qd['quiz_question'];
                $answare[] = $data[$qd['quiz_question']];
            } else {
                $id_soal[] =  $qd['quiz_question'];
                $answare[] = '0';
            }
        }

        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $cekHistory = $this->userHistoryModel->where([
            'user_id' => $users['slug'],
            'quiz_id' => $quizData[0]['quiz_id'],
        ])->first();

        if ($cekHistory) {
            $this->userHistoryModel->update($cekHistory['id'], [
                'id_soal' => join(',', $id_soal),
                'answare' => join(',', $answare)
            ]);
        } else {
            $this->userHistoryModel->save([
                'user_id' => $users['slug'],
                'quiz_id' => $quizData[0]['quiz_id'],
                'id_soal' => join(',', $id_soal),
                'quiz_type' => $quizData[0]['quiz_type'],
                'quiz_category' => $quizData[0]['quiz_category'],
                'answare' => join(',', $answare)
            ]);
        }

        $response = array();
        $response['token'] = csrf_token();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];

        return $this->response->setJSON($response);
    }

    public function list_hasil_latihan()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $userHistory = $this->userHistoryModel->where([
            'user_id' => $user['slug'],
        ])->findAll();

        $dataUser = [];
        foreach ($userHistory as $history) {
            $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $history['quiz_id']])->first();
            if ($bankQuiz) {
                $typeSoal = $this->typeSoalModel->where(['id_main_type_soal' => $bankQuiz['quiz_subject']])->first();
                $data = array(
                    'quiz_id' => $bankQuiz['quiz_id'],
                    'quiz_name' => $bankQuiz['quiz_name'],
                    'type' => join(' ', explode('_', $typeSoal['slug'])),
                    'category' => $typeSoal['list_type_soal']
                );

                array_push($dataUser, $data);
            }
        };

        $data = [
            'title' => 'Daftar Hasil Latihan Schuler.id',
            'user_name' => $user['username'],
            'data_user' => $dataUser
        ];

        return view('home/menu-utbk/latihan-utbk/hasil-latihan-list', $data);
    }

    public function hasil_latihan()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();

        $userHistory = $this->userHistoryModel->where([
            'user_id' => $users['slug'],
            'quiz_id' => $query
        ])->first();

        $idSoal = explode(',', $userHistory['id_soal']);
        $userAns = explode(',', $userHistory['answare']);
        $userAnsware = new stdClass;
        for ($i = 0; $i < count($idSoal); $i++) {
            $userAnsware->{$idSoal[$i]} = $userAns[$i];
        }

        $quizData = $this->bankQuizModel->where([
            'quiz_id' => $query
        ])->findAll();

        $bankSoal = $this->bankSoalModel->findAll();
        $typeSoal = $this->typeSoalModel->findAll();
        $navbarTitle = "Hasil & Jawaban " . $quizData[0]['quiz_name'];

        $data = [
            'title' => 'Hasil Latihan Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'type_soal' => $typeSoal,
            'navbar_title' => $navbarTitle,
            'user_answare' => $userAnsware
        ];

        return view('home/menu-utbk/latihan-utbk/hasil-latihan', $data);
    }

    // MENU UTBK SIMULASI
    public function simulasi_gratis()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'group' => '0'
        ])->findAll();

        $remakeBankQuiz = [];
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'free_simulation'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $dataremakeBankQuiz = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => ($timer['quiz_timer'] / 60) * 9,
                'quiz_type' => $bq['quiz_type']
            );

            array_push($remakeBankQuiz, $dataremakeBankQuiz);
        }

        $data = [
            'title' => 'Simulasi Gratis Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $cekCategoryQuiz,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $this->categoryQuizModel->where(['group' => '0'])->findAll()
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-home', $data);
    }

    public function simulasi_gratis_guide()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();

        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => $user['username'],
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'universitas_pilihan' => $getUniversitas['nama_universitas']
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-guide', $data);
    }

    public function kerjakan_simulasi_geratis()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $id = $this->request->getVar('id');
        $query = $this->request->getVar('query');
        $getSession = $this->request->getVar('utbk_session');

        $bankSoal = $this->bankSoalModel->findAll();
        $categoryQuiz = $this->categoryQuizModel->where(['category_id' => $id])->first();
        $subcategoryQuiz = explode(',', $categoryQuiz['category_item']);
        $remakeTypeSoal = [];
        foreach ($subcategoryQuiz as $scQ) {
            $typeSoal = $this->typeSoalModel->where(['id_main_type_soal' => $scQ])->first();
            array_push($remakeTypeSoal, $typeSoal);
        }

        $listSession = [];
        foreach ($subcategoryQuiz as $scq) {
            $selectedType = $this->typeSoalModel->where([
                'id_main_type_soal' => $scq
            ])->first();
            $subTypeId = explode(',', $selectedType['list_type_soal_id']);

            foreach ($subTypeId as $stid) {
                $listSessionItem = [
                    'quiz_subject' => $selectedType['id_main_type_soal'],
                    'quiz_sub_subject' => $stid
                ];

                array_push($listSession, $listSessionItem);
            }
        }

        if ($getSession == null) {
            $getSession = 0;
            $quizData = $this->bankQuizModel->where([
                'quiz_id' => $query,
                'quiz_subject' => $listSession[0]['quiz_subject'],
                'quiz_sub_subject' => $listSession[0]['quiz_sub_subject']
            ])->findAll();
        } else {
            $quizData = $this->bankQuizModel->where([
                'quiz_id' => $query,
                'quiz_subject' => $listSession[$getSession]['quiz_subject'],
                'quiz_sub_subject' => $listSession[$getSession]['quiz_sub_subject']
            ])->findAll();
        }

        $navbarTitle = strtoupper($quizData[0]['quiz_name']);
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $quizData[0]['quiz_category']])->first();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'type_soal' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'utbk_session' => $getSession,
            'utbk_session_limit' => sizeof($listSession)
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-main', $data);
    }

    public function save_simulasi_geratis()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $quizData = $this->bankQuizModel->where([
            'quiz_id' => $data['quiz_id'],
        ])->findAll();


        foreach ($quizData as $qd) {
            if (array_key_exists($qd['quiz_question'], $data)) {
                $id_soal[] =  $qd['quiz_question'];
                $answare[] = $data[$qd['quiz_question']];
            } else {
                $id_soal[] =  $qd['quiz_question'];
                $answare[] = '0';
            }
        }

        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $cekHistoryUtbk = $this->userHistoryUtbkModel->where([
            'user_id' => $users['slug'],
            'quiz_id' => $quizData[0]['quiz_id'],
        ])->first();

        if ($cekHistoryUtbk) {
            $this->userHistoryUtbkModel->update($cekHistoryUtbk['id'], [
                'id_soal' => join(',', $id_soal),
                'answare' => join(',', $answare)
            ]);
        } else {
            $this->userHistoryUtbkModel->save([
                'user_id' => $users['slug'],
                'quiz_id' => $quizData[0]['quiz_id'],
                'id_soal' => join(',', $id_soal),
                'quiz_type' => $quizData[0]['quiz_type'],
                'quiz_category' => $quizData[0]['quiz_category'],
                'answare' => join(',', $answare)
            ]);
        }

        $response = array();
        $response['token'] = csrf_token();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];
        $response['quiz_sub_subject'] = $data['quiz_sub_subject'];

        return $this->response->setJSON($response);
    }

    public function simulasi_premium()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $data = [
            'title' => 'Simulasi Premium Schuler.id',
            'user_name' => $user['username']
        ];

        return view('home/menu-utbk/simulasi-utbk/simulasi-premium', $data);
    }

    public function list_hasil_simulasi()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $userHistoryUtbk = $this->userHistoryUtbkModel->where([
            'user_id' => $user['slug'],
        ])->findAll();

        $dataUser = [];
        foreach ($userHistoryUtbk as $history) {
            $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $history['quiz_id']])->first();
            if ($bankQuiz) {
                $typeSoal = $this->typeSoalModel->where(['id_main_type_soal' => $bankQuiz['quiz_subject']])->first();
                $data = array(
                    'quiz_id' => $bankQuiz['quiz_id'],
                    'quiz_name' => $bankQuiz['quiz_name'],
                    'type' => join(' ', explode('_', $typeSoal['slug'])),
                    'category' => $typeSoal['list_type_soal']
                );

                array_push($dataUser, $data);
            }
        };

        $data = [
            'title' => 'Daftar Hasil Latihan Schuler.id',
            'user_name' => $user['username'],
            'data_user' => $dataUser
        ];

        return view('home/menu-utbk/simulasi-utbk/hasil-simulasi-list', $data);
    }

    public function hasil_simulasi()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $id = $this->request->getVar('id');

        if (!$query) {
            return redirect()->to(base_url("home/list_hasil_simulasi"));
        }

        $user = $this->usersModel->where(['email' => session()->get('username')])->first();

        $userHistoryUtbk = $this->userHistoryUtbkModel->where([
            'user_id' => $user['slug'],
            'quiz_id' => $query
        ])->first();

        $idSoal = explode(',', $userHistoryUtbk['id_soal']);
        $userAns = explode(',', $userHistoryUtbk['answare']);
        $userAnsware = new stdClass;
        for ($i = 0; $i < count($idSoal); $i++) {
            $userAnsware->{$idSoal[$i]} = $userAns[$i];
        }

        $getQUizType = $this->bankQuizModel->where([
            'quiz_id' => $query
        ])->first();

        $getcategorySoalData = $this->categoryQuizModel->where(['slug' => $getQUizType['quiz_type']])->first();
        $categorySoal = explode(',', $getcategorySoalData['category_item']);

        if ($id == null) {
            $id = $categorySoal[0];
        };

        $quizData = [];
        $quizDataSplit = [];
        foreach ($categorySoal as $cs) {
            $getTypesoalData = $this->typeSoalModel->where(['id_main_type_soal' => $cs])->first();
            $typeSoal = explode(',', $getTypesoalData['list_type_soal_id']);
            $remakeTypeSoal[] = [
                'id' => $cs,
                'name' => $getTypesoalData['main_type_soal'],
                'slug' => $getTypesoalData['slug'],
            ];

            foreach ($typeSoal as $ts) {
                $getQuizSoal = $this->bankQuizModel->where([
                    'quiz_id' => $query,
                    'quiz_subject' => $cs,
                    'quiz_sub_subject' => $ts
                ])->findAll();

                $getQuizSplit = $this->bankQuizModel->where([
                    'quiz_id' => $query,
                    'quiz_subject' => $id,
                    'quiz_sub_subject' => $ts
                ])->orderBy('quiz_sub_subject')->findAll();

                foreach ($getQuizSoal as $qQs) {
                    array_push($quizData, $qQs);
                }

                foreach ($getQuizSplit as $qS) {
                    array_push($quizDataSplit, $qS);
                }
            }
        }

        $bankSoal = $this->bankSoalModel->findAll();
        $typeSoal = $this->typeSoalModel->findAll();
        $navbarTitle = "Hasil & Jawaban " . $quizData[0]['quiz_name'];

        $data = [
            'title' => 'Hasil Simulasi Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'bank_soal_remake' => $quizDataSplit,
            'type_soal' => $typeSoal,
            'type_soal_tab' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'user_answare' => $userAnsware
        ];

        return view('home/menu-utbk/simulasi-utbk/hasil-simulasi', $data);
    }

    public function session_login()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
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
}
