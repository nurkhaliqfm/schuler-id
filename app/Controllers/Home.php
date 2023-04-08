<?php

namespace App\Controllers;

use App\Models\TypeSoalModel;
use App\Models\BankSoalModel;
use App\Models\BankQuizModel;
use App\Models\QuizModel;
use App\Models\CategoryQuizModel;
use App\Models\UserHistoryModel;
use App\Models\UserHistoryUtbkModel;
use App\Models\UserHistoryEventModel;
use App\Models\UserHistoryEventOfflineModel;
use App\Models\UserAnswareModel;
use DateTime;
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
    protected $userHistoryEventModel;
    protected $userHistoryEventOfflineModel;
    protected $userAnswareModel;


    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->bankQuizModel = new BankQuizModel();
        $this->quizModel = new QuizModel();
        $this->categoryQuizModel = new CategoryQuizModel();
        $this->userHistoryModel  = new UserHistoryModel();
        $this->userHistoryUtbkModel  = new UserHistoryUtbkModel();
        $this->userHistoryEventModel  = new UserHistoryEventModel();
        $this->userHistoryEventOfflineModel  = new UserHistoryEventOfflineModel();
        $this->userAnswareModel  = new UserAnswareModel();
    }

    public function index()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $getQuizSoal = $this->utbkShopModel->countAllResults();

        $cekAccount = $this->akunPremiumModel->where(['user_id' => $user['slug']])->first();

        if ($cekAccount) {
            $split_deadline = explode("-", $cekAccount['tgl_berakhir']);
            $deatline_time = $split_deadline[2] . "-" . $split_deadline[1] . "-" . $split_deadline[0];

            $curret_date = date('Y-m-d');
            $split_current_date = explode("-", $curret_date);
            $tcurrent_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

            $date_different = strtotime($tcurrent_date_time) - strtotime($deatline_time);
            $selisih = $date_different / 86400;

            if ($selisih < 0) {
                $hasil_tgl = -1 * floor($selisih);
            } else {
                $hasil_tgl = 0;
            }

            if ($hasil_tgl > 0) {
                $getUserQuiz = $this->utbkShopModel->where(['slug' => 'gratis'])->countAllResults();
            }
        } else {
            $getUserQuiz = $this->utbkShopModel->where(['slug' => 'gratis'])->countAllResults();
        }

        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => $user['username'],
            'all_quiz' => $getQuizSoal,
            'user_quiz' => $getUserQuiz,
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

    public function live_class()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $data = [
            'title' => 'Kelas Online SNBT Schuler.id',
            'user_name' => $user['username']
        ];

        return view('home/program-khusus/online-class', $data);
    }

    // MENU UTBK LATIHAN
    public function latihan_home()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->findAll();

        $typeSoalID = [];
        $filterCategory = [];
        foreach ($cekCategoryQuiz as $cC) {
            $idCategoryQuiz = explode(',', $cC['category_item']);
            foreach ($idCategoryQuiz as $id) {
                if (!in_array($id, $typeSoalID)) {
                    $getTypeSoal = $this->typeSoalModel->where(['id_main_type_soal' => $id])->first();
                    if (!$getTypeSoal) {
                        dd($cC);
                    }
                    $name = str_replace('_', ' ', $getTypeSoal['slug']);
                    $typeSoal[] = [
                        'id' => $id,
                        'name' => $name,
                        'slug' => $getTypeSoal['slug'],
                    ];
                    $dataFilter = explode(',', $cC['category_item']);
                    foreach ($dataFilter as $df) {
                        if (!in_array($df, $filterCategory)) {
                            array_push($filterCategory, $df);
                        }
                    }
                    array_push($typeSoalID, $id);
                }
            }
        }

        $remakeBankQuiz = [];
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
            'type_soal' => $typeSoal,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => join(',', $filterCategory)
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
        $getId = $this->request->getVar('id');
        $getQuery = $this->request->getVar('query');

        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekAccount = $this->akunPremiumModel->where(['user_id' => $user['slug']])->findAll();

        if ($cekAccount) {
            $hasil_tgl = 0;
            foreach ($cekAccount as $ca) {
                $split_deadline = explode("-", $ca['tgl_berakhir']);
                $deatline_time = $split_deadline[2] . "-" . $split_deadline[1] . "-" . $split_deadline[0];

                $curret_date = date('Y-m-d');
                $split_current_date = explode("-", $curret_date);
                $tcurrent_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

                $date_different = strtotime($tcurrent_date_time) - strtotime($deatline_time);
                $selisih = $date_different / 86400;

                if ($selisih < 0) {
                    $hasil = -1 * floor($selisih);
                } else {
                    $hasil = 0;
                }

                if ($hasil > $hasil_tgl) {
                    $hasil_tgl = $hasil;
                }
            }

            if ($hasil_tgl == 0) {
                session()->setFlashdata('failed', "Masa Berlaku Akses Kelas Telah Usai.");
                return redirect()->to(base_url('home/latihan_guide?id=' . $getId . '&query=' . $getQuery))->withInput();
            }
        } else {
            session()->setFlashdata('failed', "Anda Tidak Memiliki Akses Ke Kelas Ini, Silahkan Melakukan Pembelian Paket Terlebih Dahulu.");
            return redirect()->to(base_url('home/latihan_guide?id=' . $getId . '&query=' . $getQuery))->withInput();
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
        $navbarTitle = $quizData[0]['quiz_name'];

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
    // SIMULASI GRATIS
    public function simulasi_gratis()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'group' => '2',
        ])->findAll();

        $remakeBankQuiz = [];
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'free_simulation'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $countPart = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'free_simulation',
            ])->groupBy('quiz_sub_subject')->countAllResults();
            $quizSubject = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'free_simulation'
            ])->groupBy('quiz_subject')->findAll();
            $text = "";
            for ($i = 0; $i < sizeof($quizSubject); $i++) {
                $data_text = $this->typeSoalModel->where(['id_main_type_soal' => $quizSubject[$i]['quiz_subject']])->first();
                if ($i == 0) {
                    $text = $data_text['main_type_soal'];
                } else if ($i == sizeof($quizSubject) - 1) {
                    $text = $text . ' & ' . $data_text['main_type_soal'];
                } else if ($i < sizeof($quizSubject) - 1) {
                    $text = $text . ', ' . $data_text['main_type_soal'];
                }
            }

            $dataremakeBankQuiz = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => ($timer['quiz_timer'] / 60) * $countPart,
                'desc' => $text,
                'quiz_type' => $bq['quiz_type']
            );

            array_push($remakeBankQuiz, $dataremakeBankQuiz);
        }

        $data = [
            'title' => 'Simulasi Gratis Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $cekCategoryQuiz,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $this->categoryQuizModel->where(['group' => '2'])->findAll()
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
        $countPart = $this->bankQuizModel->where(['quiz_id' => $query])->groupBy('quiz_sub_subject')->countAllResults();

        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => $user['username'],
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'quiz_part' => $countPart,
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
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];
        $response['quiz_sub_subject'] = $data['quiz_sub_subject'];

        return $this->response->setJSON($response);
    }

    // SIMULASI PREMIUM
    public function simulasi_premium()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'group' => '2',
        ])->findAll();

        $remakeBankQuiz = [];
        $bankQuiz = $this->bankQuizModel->orderBy('id')->where(['quiz_category' => 'premium_simulation'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $countPart = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'premium_simulation',
            ])->groupBy('quiz_sub_subject')->countAllResults();
            $quizSubject = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'premium_simulation'
            ])->groupBy('quiz_subject')->findAll();
            $text = "";
            for ($i = 0; $i < sizeof($quizSubject); $i++) {
                $data_text = $this->typeSoalModel->where(['id_main_type_soal' => $quizSubject[$i]['quiz_subject']])->first();
                if ($i == 0) {
                    $text = $data_text['main_type_soal'];
                } else if ($i == sizeof($quizSubject) - 1) {
                    $text = $text . ' & ' . $data_text['main_type_soal'];
                } else if ($i < sizeof($quizSubject) - 1) {
                    $text = $text . ', ' . $data_text['main_type_soal'];
                }
            }

            $dataremakeBankQuiz = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => ($timer['quiz_timer'] / 60) * $countPart,
                'desc' => $text,
                'quiz_type' => $bq['quiz_type']
            );

            array_push($remakeBankQuiz, $dataremakeBankQuiz);
        }

        $data = [
            'title' => 'Simulasi Premium Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $cekCategoryQuiz,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $this->categoryQuizModel->where(['group' => '2'])->findAll()
        ];

        return view('home/menu-utbk/simulasi-utbk/premium-simulation/simulasi-home', $data);
    }

    public function simulasi_premium_guide()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();
        $countPart = $this->bankQuizModel->where(['quiz_id' => $query])->groupBy('quiz_sub_subject')->countAllResults();

        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => $user['username'],
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'quiz_part' => $countPart,
            'universitas_pilihan' => $getUniversitas['nama_universitas']
        ];

        return view('home/menu-utbk/simulasi-utbk/premium-simulation/simulasi-guide', $data);
    }

    public function kerjakan_simulasi_premium()
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

        $cekAccount = $this->akunPremiumModel->where([
            'user_id' => $user['slug'],
            'paket_name' => $categoryQuiz['slug']
        ])->first();

        if ($cekAccount) {
            $split_deadline = explode("-", $cekAccount['tgl_berakhir']);
            $deatline_time = $split_deadline[2] . "-" . $split_deadline[1] . "-" . $split_deadline[0];

            $curret_date = date('Y-m-d');
            $split_current_date = explode("-", $curret_date);
            $current_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

            $date_different = strtotime($deatline_time) - strtotime($current_date_time);
            $selisih = $date_different / 86400;

            if ($selisih >= 1) {
                $hasil_tgl = floor($selisih);
            } else {
                $hasil_tgl = 0;
            }

            if ($hasil_tgl == 0) {
                session()->setFlashdata('failed', "Masa Berlaku Akses Kelas Telah Usai.");
                return redirect()->to(base_url('home/simulasi_premium_guide?id=' . $id . '&query=' . $query))->withInput();
            }
        } else {
            session()->setFlashdata('failed', "Anda Tidak Memiliki Akses Ke Kelas Ini, Silahkan Melakukan Pembelian Paket Terlebih Dahulu.");
            return redirect()->to(base_url('home/simulasi_premium_guide?id=' . $id . '&query=' . $query))->withInput();
        }

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

        $allQuizData = $this->bankQuizModel->where([
            'quiz_id' => $query,
        ])->findAll();

        $alltypeSoal = $this->typeSoalModel->findAll();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'all_quiz_data' => $allQuizData,
            'all_type_soal' => $alltypeSoal,
            'type_soal' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'utbk_session' => $getSession,
            'utbk_session_limit' => sizeof($listSession)
        ];

        return view('home/menu-utbk/simulasi-utbk/premium-simulation/simulasi-main', $data);
    }

    public function save_simulasi_premium()
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
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];
        $response['quiz_sub_subject'] = $data['quiz_sub_subject'];

        return $this->response->setJSON($response);
    }

    // HASIL SIMULASI
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
                $category = $bankQuiz['quiz_category'] == "free_simulation" ? "Simulasi Gratis" : "Simulasi Premium";
                $data = array(
                    'quiz_id' => $bankQuiz['quiz_id'],
                    'quiz_name' => $bankQuiz['quiz_name'],
                    'category' => $category,
                    'type' => $bankQuiz['quiz_type']
                );

                array_push($dataUser, $data);
            }
        };

        $data = [
            'title' => 'Daftar Hasil Simulasi Schuler.id',
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
        $navbarTitle = $quizData[0]['quiz_name'];

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

    // RANGKING
    public function save_simulasi_rangking()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $cek_rangking = $this->rangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();

        if ($cek_rangking) {
            $this->rangkingSimulasi->update($cek_rangking['id'], [
                'skor' => $data['result'],
            ]);
        } else {
            $this->rangkingSimulasi->save([
                'id_user' => $user['slug'],
                'user_name' => $user['username'],
                'email' => $user['email'],
                'id_universitas' => $kampus['id_universitas'],
                'universitas_pilihan' => $kampus['nama_universitas'],
                'asal_sekolah' => $user['asal_sekolah'],
                'skor' => $data['result']
            ]);
        }

        $response = array();
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['quiz_id'] = $data['quiz_id'];
        $response['status'] = "Success";

        return $this->response->setJSON($response);
    }

    public function rangking()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $data_rangking = $this->rangkingSimulasi->orderBy('skor', 'DESC')->findAll();
        $data_user = $this->rangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();

        if ($data_user) {
            $user_rank = array_search($data_user['email'], array_column($data_rangking, 'email'));
        } else {
            $user_rank = 0;
        }

        $data = [
            'title' => 'Daftar Hasil Latihan Schuler.id',
            'user_name' => $user['username'],
            'user_rank' => $user_rank + 1,
            'data_user' => $data_user,
            'data_rangking' => $data_rangking
        ];

        return view('home/menu-utbk/rangking', $data);
    }

    public function rangking_universitas()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('keyword');
        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();
        if ($query) {
            $data_rangking = $this->rangkingSimulasi->where(['id_universitas' => $query])->orderBy('skor', 'DESC')->findAll();
        } else {
            $data_rangking = $this->rangkingSimulasi->where(['id_universitas' => $kampus['id_universitas']])->orderBy('skor', 'DESC')->findAll();
        }

        $data_user = $this->rangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();


        if ($data_user) {
            $user_rank = array_search($data_user['email'], array_column($data_rangking, 'email'));
        } else {
            $user_rank = 0;
        }

        $data = [
            'title' => 'Daftar Hasil Latihan Schuler.id',
            'user_name' => $user['username'],
            'user_rank' => $user_rank + 1,
            'data_user' => $data_user,
            'university_list' =>  $this->universitasModel->findAll(),
            'kampus' =>  $kampus,
            'data_rangking' => $data_rangking
        ];

        return view('home/menu-utbk/rangking-universitas', $data);
    }

    // EVENT
    public function event_simulasi()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'group' => '3',
        ])->findAll();

        $remakeBankQuiz = [];
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'event'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $countPart = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'event',
            ])->groupBy('quiz_sub_subject')->countAllResults();
            $quizSubject = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'event'
            ])->groupBy('quiz_subject')->findAll();
            $text = "";
            for ($i = 0; $i < sizeof($quizSubject); $i++) {
                $data_text = $this->typeSoalModel->where(['id_main_type_soal' => $quizSubject[$i]['quiz_subject']])->first();
                if ($i == 0) {
                    $text = $data_text['main_type_soal'];
                } else if ($i == sizeof($quizSubject) - 1) {
                    $text = $text . ' & ' . $data_text['main_type_soal'];
                } else if ($i < sizeof($quizSubject) - 1) {
                    $text = $text . ', ' . $data_text['main_type_soal'];
                }
            }

            $dataremakeBankQuiz = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => ($timer['quiz_timer'] / 60) * $countPart,
                'desc' => $text,
                'quiz_type' => $bq['quiz_type']
            );

            array_push($remakeBankQuiz, $dataremakeBankQuiz);
        }

        $cekResult = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
        ])->first();

        $data = [
            'title' => 'Event Simulasi Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $cekCategoryQuiz,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $this->categoryQuizModel->where(['group' => '3'])->findAll(),
            'history' => ($cekResult) ? 'show' : 'hidden',
        ];

        return view('home/event/event-simulation/simulasi-home', $data);
    }

    public function event_simulasi_guide()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();
        $countPart = $this->bankQuizModel->where(['quiz_id' => $query])->groupBy('quiz_sub_subject')->countAllResults();

        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $split_deadline = explode("-", '20-10-2022');
        $deatline_time = $split_deadline[2] . "-" . $split_deadline[1] . "-" . $split_deadline[0];

        $curret_date = date('Y-m-d');
        $split_current_date = explode("-", $curret_date);
        $current_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

        $date_different = strtotime($current_date_time) - strtotime($deatline_time);
        $selisih = $date_different / 86400;

        if ($selisih >= 1) {
            $hasil_tgl = floor($selisih);
        } else {
            $hasil_tgl = 0;
        }

        // if ($hasil_tgl > 0) {
        //     session()->setFlashdata('failed', "Masa Berlaku Pendaftaran Event Simulasi Ini Telah Selesai.");
        //     return redirect()->to(base_url('home/event_simulasi'))->withInput();
        // }

        $list_tgl = [
            '21-10-2022' => '21-10-2022,21 Oktober 2022',
            '22-10-2022' => '22-10-2022,22 Oktober 2022',
            '23-10-2022' => '23-10-2022,23 Oktober 2022',
            '24-10-2022' => '24-10-2022,24 Oktober 2022',
            '25-10-2022' => '25-10-2022,25 Oktober 2022',
            '26-10-2022' => '26-10-2022,26 Oktober 2022',
            '27-10-2022' => '27-10-2022,27 Oktober 2022',
            '28-10-2022' => '28-10-2022,28 Oktober 2022',
            '29-10-2022' => '29-10-2022,29 Oktober 2022',
            '30-10-2022' => '30-10-2022,30 Oktober 2022',
            '31-10-2022' => '31-10-2022,31 Oktober 2022',
        ];

        $list_sesi = [
            'sesi_1' => 'sesi_1,07:30 - 15:30',
            'sesi_2' => 'sesi_2,15:30 - 23:30',
        ];

        $cekEventAccount = $this->akunEventModel->where([
            'user_id' => $user['slug'],
        ])->first();

        $cekEventResult = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
            'quiz_type' => $dataQuiz[0]['quiz_type'],
        ])->first();

        if (!$cekEventAccount) {
            if (!$cekEventResult) {
                $this->akunEventModel->save([
                    'user_id' => $user['slug'],
                    'paket_name' => $dataQuiz[0]['quiz_type'],
                ]);
            }
        }

        if ($cekEventAccount) {
            if ($cekEventAccount['tgl_mulai'] && $cekEventAccount['sesi_pengerjaan']) {
                $getJadwal = explode(',', $list_tgl[$cekEventAccount['tgl_mulai']]);
                $getSesi = explode(',', $list_sesi[$cekEventAccount['sesi_pengerjaan']]);
            } else {
                $getJadwal = ['0', 'Belum Dipilih'];
                $getSesi = ['0', 'Belum Dipilih'];
            }
        } else {
            $getJadwal = ['0', 'Belum Dipilih'];
            $getSesi = ['0', 'Belum Dipilih'];
        }

        $remakeList_tgl = [];
        $remakeList_sesi = [];
        $x = 0;
        foreach ($list_tgl as $lt) {
            foreach ($list_sesi as $ls) {
                $sesiExp = explode(',', $ls);
                $tglExp = explode(',', $lt);

                $countEventAccount = $this->akunEventModel->where([
                    'tgl_mulai' => $tglExp[0],
                    'sesi_pengerjaan' => $sesiExp[0]
                ])->countAllResults();

                if ($countEventAccount < 20) {
                    if (!in_array($lt, $remakeList_tgl)) {
                        array_push($remakeList_tgl, $lt);
                    }

                    $data_sesi = [$tglExp[0], $sesiExp[0], $sesiExp[1]];
                    $remakeList_sesi[$x] = $data_sesi;
                    $x++;
                }
            }
        }

        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => $user['username'],
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $user['slug'],
            'timer' => $timer['quiz_timer'],
            'quiz_part' => $countPart,
            'universitas_pilihan' => $getUniversitas['nama_universitas'],
            'jadwal_tgl' => $getJadwal,
            'jadwal_waktu' => $getSesi,
            'list_tanggal' => $remakeList_tgl,
            'list_sesi' => $remakeList_sesi,
        ];

        return view('home/event/event-simulation//simulasi-guide', $data);
    }

    public function event_simulasi_schedule()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $id = $this->request->getVar('id');
        $tgl = $this->request->getVar('tgl_value');
        $sesi = $this->request->getVar('sesi_value');

        $split_deadline = explode("-", '20-10-2022');
        $deatline_time = $split_deadline[2] . "-" . $split_deadline[1] . "-" . $split_deadline[0];

        $curret_date = date('Y-m-d');
        $split_current_date = explode("-", $curret_date);
        $current_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

        $date_different = strtotime($current_date_time) - strtotime($deatline_time);
        $selisih = $date_different / 86400;

        if ($selisih >= 1) {
            $hasil_tgl = floor($selisih);
        } else {
            $hasil_tgl = 0;
        }

        if ($hasil_tgl > 0) {
            session()->setFlashdata('failed', "Mohon Maaf Jadwal Tidak Dapat Diubah.");
            redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
        }

        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $cekEventAccount = $this->akunEventModel->where([
            'user_id' => $user['slug'],
            'paket_name' => $dataQuiz[0]['quiz_type'],
        ])->first();

        $cekEventResult = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
            'quiz_type' => $dataQuiz[0]['quiz_type'],
        ])->first();
        if ($tgl && $sesi) {
            if (!$cekEventAccount) {
                if (!$cekEventResult) {
                    $this->akunEventModel->save([
                        'user_id' => $user['slug'],
                        'paket_name' => $dataQuiz[0]['quiz_type'],
                        'tgl_mulai' => $tgl,
                        'sesi_pengerjaan' => $sesi,
                    ]);
                }
            } else {
                $this->akunEventModel->update($cekEventAccount['id'], [
                    'tgl_mulai' => $tgl,
                    'sesi_pengerjaan' => $sesi,
                ]);
            }
        }

        return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query));
    }

    public function kerjakan_event_simulasi()
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

        $cekAccount = $this->akunEventModel->where([
            'user_id' => $user['slug'],
            'paket_name' => $categoryQuiz['slug']
        ])->first();

        $cekResult = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
            'quiz_id' => $query
        ])->first();

        if ($cekResult) {
            session()->setFlashdata('failed', "Anda Telah Mengikuti Event Ini.");
            return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
        }

        $userScheduleSesi = $cekAccount['sesi_pengerjaan'];

        $list_sesi = [
            'sesi_1' => '07:30 - 15:30',
            'sesi_2' => '15:30 - 23:30',
        ];

        if ($cekAccount) {
            if ($cekAccount['tgl_mulai']) {
                $sesiUser = explode(' - ', $list_sesi[$userScheduleSesi]);

                $scheduled = DateTime::createFromFormat('H:i', date('H:i'));
                $start = DateTime::createFromFormat('H:i', $sesiUser[0]);
                $end = DateTime::createFromFormat('H:i', $sesiUser[1]);

                $split_deadline = explode("-", $cekAccount['tgl_mulai']);
                $deatline_time = $split_deadline[0] . "-" . $split_deadline[1] . "-" . $split_deadline[2];

                $curret_date = date('Y-m-d');
                $split_current_date = explode("-", $curret_date);
                $current_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

                if ($deatline_time == $current_date_time) {
                    if ($scheduled < $start) {
                        session()->setFlashdata('failed', "Masa Pengerjaan Belum Berlangsung.");
                        return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
                    } else if ($scheduled > $end) {
                        session()->setFlashdata('failed', "Masa Pengerjaan Telah Berlalu.");
                        return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
                    }
                } else {
                    session()->setFlashdata('failed', "Jadwal Pengerjaan Belum Berlangsung.");
                    return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
                }
            } else {
                session()->setFlashdata('failed', "Silahkan Memilih Jadwal Simulasi Terlebih Dahulu.");
                return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
            }
        } else {
            session()->setFlashdata('failed', "Anda Tidak Memiliki Akses Ke Event Ini");
            return redirect()->to(base_url('home/event_simulasi_guide?id=' . $id . '&query=' . $query))->withInput();
        }

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

        $allQuizData = $this->bankQuizModel->where([
            'quiz_id' => $query,
        ])->findAll();

        $alltypeSoal = $this->typeSoalModel->findAll();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'all_quiz_data' => $allQuizData,
            'all_type_soal' => $alltypeSoal,
            'type_soal' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'utbk_session' => $getSession,
            'utbk_session_limit' => sizeof($listSession)
        ];

        return view('home/event/event-simulation/simulasi-main', $data);
    }

    public function save_event_simulasi()
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
        $cekHistoryEvent = $this->userHistoryEventModel->where([
            'user_id' => $users['slug'],
            'quiz_id' => $quizData[0]['quiz_id'],
        ])->first();

        if ($cekHistoryEvent) {
            $this->userHistoryEventModel->update($cekHistoryEvent['id'], [
                'id_soal' => join(',', $id_soal),
                'answare' => join(',', $answare)
            ]);
        } else {
            $this->userHistoryEventModel->save([
                'user_id' => $users['slug'],
                'quiz_id' => $quizData[0]['quiz_id'],
                'id_soal' => join(',', $id_soal),
                'quiz_type' => $quizData[0]['quiz_type'],
                'quiz_category' => $quizData[0]['quiz_category'],
                'answare' => join(',', $answare)
            ]);
        }

        $response = array();
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];
        $response['quiz_sub_subject'] = $data['quiz_sub_subject'];

        return $this->response->setJSON($response);
    }

    // HASIL EVENT SIMULASI
    public function list_hasil_event()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $userHistoryEvent = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
        ])->findAll();

        $dataUser = [];
        foreach ($userHistoryEvent as $history) {
            $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $history['quiz_id']])->first();
            if ($bankQuiz['quiz_category'] == 'event') {
                $data = array(
                    'quiz_id' => $bankQuiz['quiz_id'],
                    'quiz_name' => $bankQuiz['quiz_name'],
                    'category' => "Event Simulasi",
                    'type' => $bankQuiz['quiz_type']
                );

                array_push($dataUser, $data);
            }
        };

        $data = [
            'title' => 'Daftar Hasil Event Simulasi Schuler.id',
            'user_name' => $user['username'],
            'data_user' => $dataUser
        ];

        return view('home/event/hasil-simulasi-list', $data);
    }

    public function hasil_event()
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

        $userHistoryEvent = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
            'quiz_id' => $query
        ])->first();

        $idSoal = explode(',', $userHistoryEvent['id_soal']);
        $userAns = explode(',', $userHistoryEvent['answare']);
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
        $navbarTitle = $quizData[0]['quiz_name'];

        $data = [
            'title' => 'Hasil Event Simulasi Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'bank_soal_remake' => $quizDataSplit,
            'type_soal' => $typeSoal,
            'type_soal_tab' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'user_answare' => $userAnsware
        ];

        return view('home/event/hasil-simulasi', $data);
    }

    // SIMULASI OFFLINE
    public function offline_simulation()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $mitraList = $this->mitraModel->findAll();

        $data = [
            'title' => 'Event Simulasi Schuler.id',
            'user_name' => $user['username'],
            'mitra_list' => $mitraList,
        ];

        return view('home/event/event-simulation-offline/mitra-list', $data);
    }

    public function xhttpOfflineSimulationStatus()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $response = array();

        if ($data['request'] == 'verification') {
            $cekStudent = $this->mitraStudentModel->where(['peserta_id' => $data['id_peserta']])->first();
            if ($cekStudent) {
                if ($cekStudent['nomor_peserta'] != null) {
                    $response['status'] = "Failed";
                } else {
                    $response['status'] = "Success";
                    $response['data'] = $cekStudent;
                }
            } else {
                $response['status'] = "Error";
            }
        } else if ($data['request'] == 'session') {
            $response['data'] = session()->get('offline_simulation');
        }

        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();

        return $this->response->setJSON($response);
    }

    public function registerSimulasiOffline()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekStudent = $this->mitraStudentModel->where([
            'peserta_id' => $this->request->getVar('id_student'),
            'mitra_id' => $this->request->getVar('id_mitra')
        ])->first();

        $allMitraStudent = $this->mitraStudentModel->where([
            'mitra_id' => $this->request->getVar('id_mitra')
        ])->countAllResults();

        $cekStudentCount = $this->mitraStudentModel->where([
            'mitra_id' => $this->request->getVar('id_mitra'),
            'nomor_peserta' => null
        ])->countAllResults();

        if ($allMitraStudent == $cekStudentCount) {
            $nomorPeserta = str_pad(1, 4, '0', STR_PAD_LEFT);
        } else {
            $nomorPeserta = str_pad($allMitraStudent - $cekStudentCount, 4, '0', STR_PAD_LEFT);
        }

        $mitraEvent = $this->mitraEventModel->where([
            'mitra_id' => $this->request->getVar('id_mitra')
        ])->first();

        $listSchedule = explode(',', $mitraEvent['list_schedule']);
        $listLimit = explode(',', $mitraEvent['list_limit']);
        // $userSchedule = '';
        // $location = '';

        for ($i = 0; $i < sizeof($listLimit); $i++) {
            if ($listLimit[$i] > 0) {
                $listLimit[$i] = $listLimit[$i] - 1;
                $userSchedule = $listSchedule[$i];
                $location = 'Ruangan ' . $i + 1;
            }
            break;
        }

        $this->mitraEventModel->update($mitraEvent['id'], [
            'list_limit' => join(',', $listLimit),
        ]);

        $this->mitraStudentModel->update($cekStudent['id'], [
            'user_id' => $user['slug'],
            'pass' => $user['password'],
            'nomor_peserta' => '0407-' . $nomorPeserta,
            'tgl_lahir' => $this->request->getVar('tanggal_lahir'),
            // 'schedule' => $userSchedule,
            // 'location' => $location,
        ]);

        return redirect()->to(base_url('home/offline_simulation'));
    }

    public function loginSimulasiOffline()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $cekStudent = $this->mitraStudentModel->where([
            'peserta_id' => $this->request->getVar('id_student'),
            'mitra_id' => $this->request->getVar('id_mitra')
        ])->first();

        if ($cekStudent) {
            if ($cekStudent['nomor_peserta'] == null) {
                session()->setFlashdata('failed', 'Anda Belum Registrasi Akun');
                return redirect()->to(base_url('home/offline_simulation'));
            } else {
                if ($cekStudent['pass'] === $this->request->getVar('password')) {
                    session()->set([
                        'offline_simulation' => true
                    ]);

                    return redirect()->to(base_url('home/offline_simulation_home?query=' . $this->request->getVar('id_mitra')));
                } else {
                    session()->setFlashdata('failed', 'Kode Akses atau Password Salah');
                    return redirect()->to(base_url('home/offline_simulation'));
                }
            }
        } else {
            session()->setFlashdata('failed', 'Akun Tidak Terdaftar');
            return redirect()->to(base_url('home/offline_simulation'));
        }
    }

    public function offline_simulation_home()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $mitraEvent = $this->mitraEventModel->where([
            'mitra_id' => $this->request->getVar('query')
        ])->first();

        if (!$mitraEvent) {
            return redirect()->to(base_url('home/error_404'));
        }

        if (session()->get('offline_simulation') != true) {
            return redirect()->to(base_url('home/offline_simulation'));
        }

        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'group' => '4',
        ])->findAll();

        $remakeBankQuiz = [];
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where([
            'quiz_category' => 'offline',
            'quiz_id' => $mitraEvent['quiz_id']
        ])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $countPart = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'offline',
            ])->groupBy('quiz_sub_subject')->countAllResults();

            $quizSubject = $this->bankQuizModel->where([
                'quiz_type' => $bq['quiz_type'],
                'quiz_category' => 'offline'
            ])->groupBy('quiz_subject')->findAll();
            $text = "";
            for ($i = 0; $i < sizeof($quizSubject); $i++) {
                $data_text = $this->typeSoalModel->where(['id_main_type_soal' => $quizSubject[$i]['quiz_subject']])->first();
                if ($i == 0) {
                    $text = $data_text['main_type_soal'];
                } else if ($i == sizeof($quizSubject) - 1) {
                    $text = $text . ' & ' . $data_text['main_type_soal'];
                } else if ($i < sizeof($quizSubject) - 1) {
                    $text = $text . ', ' . $data_text['main_type_soal'];
                }
            }

            $dataremakeBankQuiz = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => ($timer['quiz_timer'] / 60) * $countPart,
                'desc' => $text,
                'quiz_type' => $bq['quiz_type']
            );

            array_push($remakeBankQuiz, $dataremakeBankQuiz);
        }

        $data = [
            'title' => 'Offline Simulasi Schuler.id',
            'user_name' => $user['username'],
            'type_soal' => $cekCategoryQuiz,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $this->categoryQuizModel->where(['group' => '3'])->findAll(),
        ];

        return view('home/event/event-simulation-offline/offline-simulation', $data);
    }

    public function offline_simulasi_guide()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $mitraID = $this->request->getVar('m');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();
        $countPart = $this->bankQuizModel->where(['quiz_id' => $query])->groupBy('quiz_sub_subject')->countAllResults();

        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $mitraEvent = $this->mitraEventModel->where([
            'mitra_id' => $mitraID,
        ])->first();

        $cekEventAccount = $this->mitraStudentModel->where([
            'user_id' => $user['slug'],
        ])->first();

        $hari = array(
            1 =>    'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );

        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $mitraEvent['tgl_mulai']);
        $num = date('N', strtotime($mitraEvent['tgl_mulai']));
        $schedule = $hari[$num] . ', ' . $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => $user['username'],
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $user['slug'],
            'timer' => $timer['quiz_timer'],
            'quiz_part' => $countPart,
            'universitas_pilihan' => $getUniversitas['nama_universitas'],
            'jadwal_tgl' => $schedule,
            'jadwal_waktu' => $cekEventAccount['schedule'],
            // $cekEventAccount['schedule']
        ];

        return view('home/event/event-simulation-offline/offline-simulasi-guide', $data);
    }

    public function kerjakan_offline_simulasi()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $id = $this->request->getVar('id');
        $query = $this->request->getVar('query');
        $mitraID = $this->request->getVar('m');
        $getSession = $this->request->getVar('utbk_session');

        $bankSoal = $this->bankSoalModel->findAll();
        $categoryQuiz = $this->categoryQuizModel->where(['category_id' => $id])->first();

        $cekAccount = $this->mitraStudentModel->where([
            'user_id' => $user['slug'],
        ])->first();

        $cekResult = $this->userHistoryEventOfflineModel->where([
            'user_id' => $user['slug'],
            'quiz_id' => $query
        ])->first();

        if ($cekResult) {
            session()->setFlashdata('failed', "Anda Telah Mengikuti Event Ini.");
            return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
        }

        $mitraEvent = $this->mitraEventModel->where([
            'mitra_id' => $mitraID,
        ])->first();
        $userScheduleSesi = $cekAccount['schedule'];

        if ($cekAccount) {
            if (date('Y-m-d') == $mitraEvent['tgl_mulai']) {
                $sesiUser = explode(' - ', $userScheduleSesi);

                $scheduled = DateTime::createFromFormat('H:i', date('H:i'));
                $start = DateTime::createFromFormat('H:i', $sesiUser[0]);
                $end = DateTime::createFromFormat('H:i', $sesiUser[1]);

                $split_deadline = explode("-", $mitraEvent['tgl_mulai']);
                $deatline_time = $split_deadline[0] . "-" . $split_deadline[1] . "-" . $split_deadline[2];

                $curret_date = date('Y-m-d');
                $split_current_date = explode("-", $curret_date);
                $current_date_time = $split_current_date[0] . "-" . $split_current_date[1] . "-" . $split_current_date[2];

                if ($deatline_time == $current_date_time) {
                    if ($scheduled < $start) {
                        session()->setFlashdata('failed', "Masa Pengerjaan Belum Berlangsung.");
                        return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
                    }

                    // else if($scheduled > $end){
                    //     session()->setFlashdata('failed', "Masa Pengerjaan Telah Berlalu.");
                    //     return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
                    // }
                } else {
                    session()->setFlashdata('failed', "Jadwal Pengerjaan Belum Berlangsung.");
                    return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
                }
            } else {
                session()->setFlashdata('failed', "Simulasi Dapat Dikerjakan Sesuai Jadwal Simulasi.");
                return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
            }
        } else {
            session()->setFlashdata('failed', "Anda Tidak Memiliki Akses Ke Kelas Ini");
            return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
        }

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

        $allQuizData = $this->bankQuizModel->where([
            'quiz_id' => $query,
        ])->findAll();

        $alltypeSoal = $this->typeSoalModel->findAll();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'all_quiz_data' => $allQuizData,
            'all_type_soal' => $alltypeSoal,
            'type_soal' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer'],
            'utbk_session' => $getSession,
            'utbk_session_limit' => sizeof($listSession)
        ];

        return view('home/event/event-simulation-offline/simulasi-main', $data);
    }

    public function save_user_answare()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $quizId = $data['quiz_id'];
        $soalId = $data['id_soal'];
        $userAnsware = $data['answare'];
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();

        $cekHistoryAnsware = $this->userAnswareModel->where([
            'user_id' => $users['slug'],
            'quiz_id' => $quizId,
            'id_soal' => $soalId
        ])->first();

        if ($cekHistoryAnsware) {
            $this->userAnswareModel->update($cekHistoryAnsware['id'], [
                'answare' => $userAnsware
            ]);
        } else {
            $this->userAnswareModel->save([
                'user_id' => $users['slug'],
                'quiz_id' => $quizId,
                'id_soal' => $soalId,
                'answare' => $userAnsware
            ]);
        }

        $response = array();
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];

        return $this->response->setJSON($response);
    }

    public function save_offline_simulasi()
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
        $cekHistoryEvent = $this->userHistoryEventOfflineModel->where([
            'user_id' => $users['slug'],
            'quiz_id' => $quizData[0]['quiz_id'],
        ])->first();

        if ($cekHistoryEvent) {
            $this->userHistoryEventOfflineModel->update($cekHistoryEvent['id'], [
                'id_soal' => join(',', $id_soal),
                'answare' => join(',', $answare)
            ]);
        } else {
            $this->userHistoryEventOfflineModel->save([
                'user_id' => $users['slug'],
                'quiz_id' => $quizData[0]['quiz_id'],
                'id_soal' => join(',', $id_soal),
                'quiz_type' => $quizData[0]['quiz_type'],
                'quiz_category' => $quizData[0]['quiz_category'],
                'answare' => join(',', $answare)
            ]);
        }

        $response = array();
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['status'] = "Success";
        $response['quiz_id'] = $data['quiz_id'];
        // $response['quiz_sub_subject'] = $data['quiz_sub_subject'];

        return $this->response->setJSON($response);
    }


    // HASIL EVENT OFFLINE SIMULASI
    public function list_hasil_offline_event()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $userHistoryEvent = $this->userHistoryEventOfflineModel->where([
            'user_id' => $user['slug'],
        ])->findAll();

        $dataUser = [];
        foreach ($userHistoryEvent as $history) {
            $bankQuiz = $this->bankQuizModel->where(['quiz_id' => $history['quiz_id']])->first();
            if ($bankQuiz['quiz_category'] == 'event') {
                $data = array(
                    'quiz_id' => $bankQuiz['quiz_id'],
                    'quiz_name' => $bankQuiz['quiz_name'],
                    'category' => "Event Simulasi",
                    'type' => $bankQuiz['quiz_type']
                );

                array_push($dataUser, $data);
            }
        };

        $data = [
            'title' => 'Daftar Hasil SNBT-UTBK Schuler.id',
            'user_name' => $user['username'],
            'data_user' => $dataUser
        ];

        return view('home/event/event-simulation-offline/hasil-simulasi-list', $data);
    }

    public function hasil_offline_event()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $id = $this->request->getVar('id');

        if (!$query) {
            return redirect()->to(base_url("home/list_hasil_offline_event"));
        }

        $user = $this->usersModel->where(['email' => session()->get('username')])->first();

        $userHistoryEvent = $this->userHistoryEventOfflineModel->where([
            'user_id' => $user['slug'],
            'quiz_id' => $query
        ])->first();

        $idSoal = explode(',', $userHistoryEvent['id_soal']);
        $userAns = explode(',', $userHistoryEvent['answare']);
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
        $navbarTitle = $quizData[0]['quiz_name'];

        $data = [
            'title' => 'Hasil Simulasi UTBK-SNBT Schuler.id',
            'user_name' => $user['username'],
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'bank_soal_remake' => $quizDataSplit,
            'type_soal' => $typeSoal,
            'type_soal_tab' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            'user_answare' => $userAnsware
        ];

        return view('home/event/event-simulation-offline/hasil-simulasi', $data);
    }

    // RANGKING EVENT
    public function save_event_rangking()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $cek_rangking = $this->eventReangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();

        if ($cek_rangking) {
            $this->eventReangkingSimulasi->update($cek_rangking['id'], [
                'skor' => $data['result'],
            ]);
        } else {
            $this->eventReangkingSimulasi->save([
                'id_user' => $user['slug'],
                'user_name' => $user['username'],
                'email' => $user['email'],
                'id_universitas' => $kampus['id_universitas'],
                'universitas_pilihan' => $kampus['nama_universitas'],
                'asal_sekolah' => $user['asal_sekolah'],
                'skor' => $data['result']
            ]);
        }

        $response = array();
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();
        $response['quiz_id'] = $data['quiz_id'];
        $response['status'] = "Success";

        return $this->response->setJSON($response);
    }

    public function event_rangking()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $data_rangking = $this->eventReangkingSimulasi->orderBy('skor', 'DESC')->findAll();
        $data_user = $this->eventReangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();

        if ($data_user) {
            $user_rank = array_search($data_user['email'], array_column($data_rangking, 'email'));
        } else {
            $user_rank = 0;
        }

        $data = [
            'title' => 'Daftar Rangking SNBT Schuler.id',
            'user_name' => $user['username'],
            'user_rank' => $user_rank + 1,
            'data_user' => $data_user,
            'data_rangking' => $data_rangking
        ];

        return view('home/event/rangking', $data);
    }

    public function event_rangking_universitas()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('keyword');
        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();
        if ($query) {
            $data_rangking = $this->eventReangkingSimulasi->where(['id_universitas' => $query])->orderBy('skor', 'DESC')->findAll();
        } else {
            $data_rangking = $this->eventReangkingSimulasi->where(['id_universitas' => $kampus['id_universitas']])->orderBy('skor', 'DESC')->findAll();
        }

        $data_user = $this->eventReangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();


        if ($data_user) {
            $user_rank = array_search($data_user['email'], array_column($data_rangking, 'email'));
        } else {
            $user_rank = 0;
        }

        $data = [
            'title' => 'Daftar Rangking SNBT Schuler.id',
            'user_name' => $user['username'],
            'user_rank' => $user_rank + 1,
            'data_user' => $data_user,
            'university_list' =>  $this->universitasModel->findAll(),
            'kampus' =>  $kampus,
            'data_rangking' => $data_rangking
        ];

        return view('home/event/rangking-universitas', $data);
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

    // MENU BELI PAKET
    public function beli_paket()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $getShopItem = $this->utbkShopModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'title' => 'Beli Paket Schuler.id',
            'user_name' => $user['username'],
            'shop_item' => $getShopItem,
            'session_id' => $user['slug'],
        ];

        return view('home/paket-utbk/home-paket', $data);
    }

    public function payMidtrans()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $item = $this->utbkShopModel->where(['id_item' => $data['id_item']])->first();

        if ($item['discount'] != 0) {
            $price = $item['price'] - (($item['price'] * $item['discount']) / 100);
        } else {
            $price = $item['price'];
        }

        \Midtrans\Config::$serverKey = 'Mid-server-DjgpetlV68OoHGTcJQcFMkHz';
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $items = array(
            array(
                'id' => $item['id_item'],
                'price' => $price,
                'quantity' => 1,
                'name' => 'Paket ' . $item['nama_item']
            ),
        );

        $customer_details = array(
            'first_name'       => $user['username'],
            'email'            => $user['email'],
            'phone'            => $user['phone'],
        );

        $params = [
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $price,
            ),
            'item_details' => $items,
            'customer_details' => $customer_details
        ];

        $response = array();
        $response['status'] = "Success";
        $response['snapToken'] = \Midtrans\Snap::getSnapToken($params);
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();

        return $this->response->setJSON($response);
    }

    public function save_transaksi()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $item = $this->utbkShopModel->where(['id_item' => $data['id_item']])->first();

        if ($item['discount'] != 0) {
            $price = $item['price'] - (($item['price'] * $item['discount']) / 100);
        } else {
            $price = $item['price'];
        }

        \Midtrans\Config::$serverKey = 'Mid-server-DjgpetlV68OoHGTcJQcFMkHz';
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $customer_details = array(
            'first_name' => $user['username'],
            'email' => $user['email'],
            'phone' => $user['phone'],
        );

        $params = [
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $price,
            ),
            'customer_details' => $customer_details
        ];

        $this->transaksiUserModel->save([
            'transaction_id' => $data['transaction_id'],
            'order_id' => $data['order_id'],
            'id_user' => $user['slug'],
            'nama_user' => $user['username'],
            'id_item_beli' =>  $item['id_item'],
            'paket_name' => $item['slug'],
            'price' => $price,
            'payment_type' => $data['payment_type'],
            'va_number' => $data['va_number'],
            'bank' => $data['bank'],
            'transaction_status' => $data['transaction_status'],
            'transaction_time' => $data['transaction_time']
        ]);

        $response = array();
        $response['status'] = "Success";
        $response['snapToken'] = \Midtrans\Snap::getSnapToken($params);
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();

        return $this->response->setJSON($response);
    }

    // INVOICE
    public function pembayaran()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $transaksi = $this->transaksiUserModel->where(['id_user' => $user['slug']])->findAll();
        $pending = $this->transaksiUserModel->where([
            'id_user' => $user['slug'],
            'transaction_status' => 'pending',
        ])->countAllResults();

        $cancel = $this->transaksiUserModel->where([
            'id_user' => $user['slug'],
            'transaction_status' => 'cancel',
        ])->countAllResults();

        $settlement = $this->transaksiUserModel->where([
            'id_user' => $user['slug'],
            'transaction_status' => 'settlement',
        ])->countAllResults();

        $status = [
            'pending' => ['Menunggu Pembayaran', 'waiting'],
            'settlement' => ['Pembayaran Berhasil', 'success'],
            'cancel' => ['Pembayaran Dibatalkan', 'cancel'],
        ];

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => $user['username'],
            'data_transaksi' => $transaksi,
            'list_status' => $status,
            'pending' => $pending,
            'settlement' => $settlement,
            'cancel' => $cancel,
        ];

        return view('home/invoice/invoice', $data);
    }

    public function transactionHandle()
    {
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        \Midtrans\Config::$serverKey = 'Mid-server-DjgpetlV68OoHGTcJQcFMkHz';
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $transaksi =  $this->transaksiUserModel->where(['order_id' => $data['order_id']])->first();

        if ($data['user_order'] == 'cek_transaction') {
            $status = \Midtrans\Transaction::status($data['order_id']);
            $dataInvoice = json_decode(json_encode($status), true);

            if ($dataInvoice['status_code'] == "200") {
                $this->transaksiUserModel->update($transaksi['id'], [
                    'transaction_status' => 'settlement',
                ]);

                $email = session()->get('username');
                $user = $this->usersModel->where(['email' => $email])->first();

                $cekAccount = $this->akunPremiumModel->where(['user_id' => $user['slug']])->first();

                if ($cekAccount) {
                    $tgl_start = explode("-", $cekAccount['tgl_berakhir']);
                    $year = mktime(0, 0, 0, $tgl_start[1], $tgl_start[0] + 365, $tgl_start[2]);
                    $tgl_end = date("d-m-Y", $year);

                    $this->akunPremiumModel->update($cekAccount['id'], [
                        'tgl_berakhir' => $tgl_end
                    ]);
                } else {
                    $tgl_start = date('d-m-Y');
                    $year = mktime(0, 0, 0, date("n"), date("j") + 365, date('Y'));
                    $tgl_end = date("d-m-Y", $year);

                    $this->akunPremiumModel->save([
                        'user_id' => $user['slug'],
                        'paket_name' => $transaksi['paket_name'],
                        'tgl_mulai' => $tgl_start,
                        'tgl_berakhir' => $tgl_end
                    ]);
                }
            }
        } else if ($data['user_order'] == 'cancel') {
            $status = \Midtrans\Transaction::cancel($data['order_id']);

            $this->transaksiUserModel->update($transaksi['id'], [
                'transaction_status' => 'cancel',
            ]);
        }

        $response = array();
        $response['status'] = "Success";
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();

        return $this->response->setJSON($response);
    }

    public function notificationHandle()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        \Midtrans\Config::$serverKey = 'Mid-server-DjgpetlV68OoHGTcJQcFMkHz';
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $response = array();
        $response['data'] = $data;
        $response['status'] = "Success";
        $response['name'] = csrf_token();
        $response['value'] = csrf_hash();

        return $this->response->setJSON($response);
    }

    // ACCOUNT SETTING
    public function account()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => $user['username'],
            'data' => $user,
            'kampus' =>  $kampus,
            'university_list' =>  $this->universitasModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('home/akun/account-setting', $data);
    }

    public function update_sekolah()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        if (!$this->validate([
            'asal_sekolah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Sekolah Harus Dipilih',
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Gagal Mengubah Asal Sekolah.");
            return redirect()->to(base_url('home/account-setting'))->withInput();
        }

        $this->usersModel->update($user['id'], [
            'asal_sekolah' => $this->request->getVar('asal_sekolah'),
        ]);

        $cek_rangking = $this->rangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();

        if ($cek_rangking) {
            $this->rangkingSimulasi->update($cek_rangking['id'], [
                'asal_sekolah' => $this->request->getVar('asal_sekolah'),
            ]);
        }

        session()->setFlashdata('success', "Berhasil Mengubah Asal Sekolah");
        return redirect()->to(base_url('home/account-setting'))->withInput();
    }

    public function update_universitas()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        if (!$this->validate([
            'kampus_1' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kampus Harus Dipilih',
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Gagal Mengubah Kampus.");
            return redirect()->to(base_url('home/account-setting'))->withInput();
        }

        $this->usersModel->update($user['id'], [
            'universitas_pilihan' => $this->request->getVar('kampus_1'),
        ]);

        $cek_rangking = $this->rangkingSimulasi->where([
            'id_user' => $user['slug'],
            'email' => $user['email'],
        ])->first();

        $getUniversitas = $this->universitasModel->where(['id_universitas' => $this->request->getVar('kampus_1')])->first();

        if ($cek_rangking) {
            $this->rangkingSimulasi->update($cek_rangking['id'], [
                'id_universitas' => $getUniversitas['id_universitas'],
                'universitas_pilihan' => $getUniversitas['nama_universitas'],
            ]);
        }

        session()->setFlashdata('success', "Berhasil Mengubah Universitas Impian");
        return redirect()->to(base_url('home/account-setting'))->withInput();
    }

    public function update_pass()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        if (!$this->validate([
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Harus Diisi',
                    'min_length' => 'Pass Minimal 8 Karakter'
                ]
            ],
        ])) {
            session()->setFlashdata('failed', "Gagal Mengubah Password.");
            return redirect()->to(base_url('home/account-setting'))->withInput();
        }

        $this->usersModel->update($user['id'], [
            'password' => $this->request->getVar('password'),
        ]);

        session()->setFlashdata('success', "Berhasil Mengubah Password");
        return redirect()->to(base_url('home/account-setting'))->withInput();
    }

    public function pembahasan()
    {
        $query = $this->request->getVar('query');
        $id = $this->request->getVar('id');

        if (!$query) {
            return redirect()->to(base_url("home/list_hasil_offline_event"));
        }

        $user = $this->usersModel->where(['email' => session()->get('username')])->first();

        $userHistoryEvent = $this->userHistoryEventOfflineModel->where([
            // 'user_id' => $user['slug'],
            'quiz_id' => $query
        ])->first();

        $idSoal = explode(',', $userHistoryEvent['id_soal']);
        // $userAns = explode(',', $userHistoryEvent['answare']);
        // $userAnsware = new stdClass;
        // for ($i = 0; $i < count($idSoal); $i++) {
        //     $userAnsware->{$idSoal[$i]} = $userAns[$i];
        // }

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
        $navbarTitle = $quizData[0]['quiz_name'];

        $data = [
            'title' => 'Hasil Simulasi UTBK-SNBT Schuler.id',
            'user_name' => 'GUEST',
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'bank_soal_remake' => $quizDataSplit,
            'type_soal' => $typeSoal,
            'type_soal_tab' => $remakeTypeSoal,
            'navbar_title' => $navbarTitle,
            // 'user_answare' => $userAnsware
        ];

        return view('home/pembahasan', $data);
    }

    // ERROR
    public function error_404()
    {
        return view('errors/html/error_404');
    }

    public function exp_data_yps()
    {

        $dataMIPA = [
            ['Nama', 'Kelas', 'Penalaran Umum (B)', 'Penalaran Umum (S)', 'Penalaran Umum (K)', 'Penalaran Umum (P)', 'Pemahaman Bacaan & Menulis (B)', 'Pemahaman Bacaan & Menulis (S)', 'Pemahaman Bacaan & Menulis (K)', 'Pemahaman Bacaan & Menulis (P)', 'Pengetahuan & Pemahaman Umum (B)', 'Pengetahuan & Pemahaman Umum (S)', 'Pengetahuan & Pemahaman Umum (K)', 'Pengetahuan & Pemahaman Umum (P)', 'Pengetahuan Kuantitatif (B)', 'Pengetahuan Kuantitatif (S)', 'Pengetahuan Kuantitatif (K)', 'Pengetahuan Kuantitatif (P)', 'Literasi Bahasa Indonesia (B)', 'Literasi Bahasa Indonesia (S)', 'Literasi Bahasa Indonesia (K)', 'Literasi Bahasa Indonesia (P)', 'Literasi Bahasa Inggris (B)', 'Literasi Bahasa Inggris (S)', 'Literasi Bahasa Inggris (K)', 'Literasi Bahasa Inggris (P)', 'Penalaran Matematika (B)', 'Penalaran Matematika (S)', 'Penalaran Matematika (K)', 'Penalaran Matematika (P)']
        ];
        $dataIPS = [
            ['Nama', 'Kelas', 'Penalaran Umum (B)', 'Penalaran Umum (S)', 'Penalaran Umum (K)', 'Penalaran Umum (P)', 'Pemahaman Bacaan & Menulis (B)', 'Pemahaman Bacaan & Menulis (S)', 'Pemahaman Bacaan & Menulis (K)', 'Pemahaman Bacaan & Menulis (P)', 'Pengetahuan & Pemahaman Umum (B)', 'Pengetahuan & Pemahaman Umum (S)', 'Pengetahuan & Pemahaman Umum (K)', 'Pengetahuan & Pemahaman Umum (P)', 'Pengetahuan Kuantitatif (B)', 'Pengetahuan Kuantitatif (S)', 'Pengetahuan Kuantitatif (K)', 'Pengetahuan Kuantitatif (P)', 'Literasi Bahasa Indonesia (B)', 'Literasi Bahasa Indonesia (S)', 'Literasi Bahasa Indonesia (K)', 'Literasi Bahasa Indonesia (P)', 'Literasi Bahasa Inggris (B)', 'Literasi Bahasa Inggris (S)', 'Literasi Bahasa Inggris (K)', 'Literasi Bahasa Inggris (P)', 'Penalaran Matematika (B)', 'Penalaran Matematika (S)', 'Penalaran Matematika (K)', 'Penalaran Matematika (P)']
        ];

        $AllCategoryQuiz = $this->categoryQuizModel->where(['slug' => 'snbt_utbk_2023'])->first();
        $listCategory = explode(',', $AllCategoryQuiz['category_item']);

        $userHistoryEvent = $this->userHistoryEventOfflineModel->where([
            'quiz_id' => "bd30bbba-f5c5-4dac-89ff-43a5073bc9c8"
        ])->findAll();

        foreach ($userHistoryEvent as $uHV) {
            $explodeSoalID = explode(",", $uHV['id_soal']);
            $explodeSoalAns = explode(",", $uHV['answare']);

            $cekEventAccount = $this->mitraStudentModel->where([
                'user_id' => $uHV['user_id'],
            ])->first();

            foreach ($listCategory as $lC) {
                $getTestCategory = $this->typeSoalModel->where([
                    'id_main_type_soal' => $lC
                ])->first();

                $dataSubtestID = explode(',', $getTestCategory['list_type_soal_id']);
                $dataSubtestName = explode(',', $getTestCategory['list_type_soal']);

                $dataEachSubsubject = [];

                for ($j = 0; $j < sizeof($dataSubtestID); $j++) {
                    $namaSubjectSoal = $dataSubtestName[$j];

                    $benar = 0;
                    $salah = 0;
                    $kosong = 0;

                    $cekBankQuiz = $this->bankQuizModel->where([
                        'quiz_id' => "bd30bbba-f5c5-4dac-89ff-43a5073bc9c8",
                        'quiz_sub_subject' => $dataSubtestID[$j]
                    ])->findAll();

                    foreach ($cekBankQuiz as $cBQ) {
                        $quiz_id = $cBQ['quiz_question'];
                        $userAnsId = array_search($quiz_id, $explodeSoalID);
                        $cekSoalId = $this->bankSoalModel->where([
                            'id_soal' => $quiz_id,
                        ])->first();

                        if ($explodeSoalAns[$userAnsId] == $cekSoalId['ans_id']) {
                            $benar++;
                        } elseif ($explodeSoalAns[$userAnsId] != $cekSoalId['ans_id']) {
                            $salah++;
                        } elseif ($explodeSoalAns[$userAnsId] == 0) {
                            $kosong++;
                        }
                    }

                    $dataAnsCategory[$namaSubjectSoal] = [
                        'Benar' => $benar,
                        'Salah' => $salah,
                        'Kosong' => $kosong,
                        'Poin' => $benar * 50
                    ];

                    array_push($dataEachSubsubject, $dataAnsCategory);
                }
            }

            $pesertaName = $cekEventAccount['peserta_name'];
            $pesertaKelas = $cekEventAccount['peserta_info'];

            $kelasExplode = explode(" ", $pesertaKelas);
            $kelasCategory = $kelasExplode[1];

            $listUserEventData = [
                'Nama' => $pesertaName,
                'Kelas' => $pesertaKelas,
                'Penalaran Umum (B)' => $dataEachSubsubject[0]['Penalaran Umum']['Benar'],
                'Penalaran Umum (S)' => $dataEachSubsubject[0]['Penalaran Umum']['Salah'],
                'Penalaran Umum (K)' => $dataEachSubsubject[0]['Penalaran Umum']['Kosong'],
                'Penalaran Umum (P)' => $dataEachSubsubject[0]['Penalaran Umum']['Poin'],
                'Pemahaman Bacaan & Menulis (B)' => $dataEachSubsubject[0]['Pemahaman Bacaan & Menulis']['Benar'],
                'Pemahaman Bacaan & Menulis (S)' => $dataEachSubsubject[0]['Pemahaman Bacaan & Menulis']['Salah'],
                'Pemahaman Bacaan & Menulis (K)' => $dataEachSubsubject[0]['Pemahaman Bacaan & Menulis']['Kosong'],
                'Pemahaman Bacaan & Menulis (P)' => $dataEachSubsubject[0]['Pemahaman Bacaan & Menulis']['Poin'],
                'Pengetahuan & Pemahaman Umum (B)' => $dataEachSubsubject[0]['Pengetahuan & Pemahaman Umum']['Benar'],
                'Pengetahuan & Pemahaman Umum (S)' => $dataEachSubsubject[0]['Pengetahuan & Pemahaman Umum']['Salah'],
                'Pengetahuan & Pemahaman Umum (K)' => $dataEachSubsubject[0]['Pengetahuan & Pemahaman Umum']['Kosong'],
                'Pengetahuan & Pemahaman Umum (P)' => $dataEachSubsubject[0]['Pengetahuan & Pemahaman Umum']['Poin'],
                'Pengetahuan Kuantitatif (B)' => $dataEachSubsubject[0]['Pengetahuan Kuantitatif']['Benar'],
                'Pengetahuan Kuantitatif (S)' => $dataEachSubsubject[0]['Pengetahuan Kuantitatif']['Salah'],
                'Pengetahuan Kuantitatif (K)' => $dataEachSubsubject[0]['Pengetahuan Kuantitatif']['Kosong'],
                'Pengetahuan Kuantitatif (P)' => $dataEachSubsubject[0]['Pengetahuan Kuantitatif']['Poin'],
                'Literasi Bahasa Indonesia (B)' => $dataEachSubsubject[0]['Literasi Bahasa Indonesia']['Benar'],
                'Literasi Bahasa Indonesia (S)' => $dataEachSubsubject[0]['Literasi Bahasa Indonesia']['Salah'],
                'Literasi Bahasa Indonesia (K)' => $dataEachSubsubject[0]['Literasi Bahasa Indonesia']['Kosong'],
                'Literasi Bahasa Indonesia (P)' => $dataEachSubsubject[0]['Literasi Bahasa Indonesia']['Poin'],
                'Literasi Bahasa Inggris (B)' => $dataEachSubsubject[0]['Literasi Bahasa Inggris']['Benar'],
                'Literasi Bahasa Inggris (S)' => $dataEachSubsubject[0]['Literasi Bahasa Inggris']['Salah'],
                'Literasi Bahasa Inggris (K)' => $dataEachSubsubject[0]['Literasi Bahasa Inggris']['Kosong'],
                'Literasi Bahasa Inggris (P)' => $dataEachSubsubject[0]['Literasi Bahasa Inggris']['Poin'],
                'Penalaran Matematika (B)' => $dataEachSubsubject[0]['Penalaran Matematika']['Benar'],
                'Penalaran Matematika (S)' => $dataEachSubsubject[0]['Penalaran Matematika']['Salah'],
                'Penalaran Matematika (K)' => $dataEachSubsubject[0]['Penalaran Matematika']['Kosong'],
                'Penalaran Matematika (P)' => $dataEachSubsubject[0]['Penalaran Matematika']['Poin'],
            ];


            if ($kelasCategory == 'MIPA') {
                array_push($dataMIPA, $listUserEventData);
            } elseif ($kelasCategory == 'IPS') {
                array_push($dataIPS, $listUserEventData);
            }
        }
        $fp_mipa = fopen('Data-Kelas-MIPA-YPS-WOTU.csv', 'w');
        foreach ($dataMIPA as $fields) {
            fputcsv($fp_mipa, $fields);
        }

        fclose($fp_mipa);

        $fp_ips = fopen('Data-Kelas-IPS-YPS-WOTU.csv', 'w');
        foreach ($dataIPS as $fields) {
            fputcsv($fp_ips, $fields);
        }

        fclose($fp_ips);

        dd('Done');
    }

    public function fixData()
    {
        $dataMitra = $this->mitraStudentModel->where(['mitra_id' => '848fcf3a-63b6-47ea-b8d4-9932d7c1d60b'])->findAll();
        foreach ($dataMitra as $x) {
            $getHistory = $this->userHistoryEventOfflineModel->where([
                'user_id' => $x['user_id'],
                'quiz_id' => "bd30bbba-f5c5-4dac-89ff-43a5073bc9c8"
            ])->first();
            if ($getHistory) {
                if (str_contains($getHistory['answare'], '0')) {
                    $cek = explode(',', $getHistory['id_soal']);
                    $cekAns = explode(',', $getHistory['answare']);
                    $index = 0;
                    foreach ($cekAns as $key) {
                        if ($key == '0') {
                            $getAnsw = $this->userAnswareModel->where(['user_id' => $x['user_id'], 'id_soal' => $cek[$index]])->first();
                            if ($getAnsw) {
                                $cekAns[$index] = $getAnsw['answare'];
                            }
                        }
                        $index++;
                    }

                    $idSoal = [];
                    $answare = [];
                    $benar = 0;
                    $idCount = 0;
                    foreach ($cek as $soalId) {
                        $cekSoalId = $this->bankSoalModel->where([
                            'id_soal' => $soalId,
                        ])->first();

                        if ($cekAns[$idCount] == $cekSoalId['ans_id']) {
                            $benar++;
                        }

                        array_push($idSoal, $soalId);
                        array_push($answare, $cekAns[$idCount]);

                        $idCount++;
                    }

                    $cekRangking = $this->eventReangkingSimulasi->where(['id_user' => $x['user_id']])->first();
                    if ($cekRangking) {
                        $this->eventReangkingSimulasi->update($cekRangking['id'], [
                            'skor' => round(($benar * 50) / 7 + 150)
                        ]);
                    } else {
                        $user = $this->usersModel->where(['slug' => $x['user_id']])->first();
                        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

                        $this->eventReangkingSimulasi->save([
                            'id_user' => $user['slug'],
                            'user_name' => $user['username'],
                            'email' => $user['email'],
                            'id_universitas' => $kampus['id_universitas'],
                            'universitas_pilihan' => $kampus['nama_universitas'],
                            'asal_sekolah' => $user['asal_sekolah'],
                            'skor' => round(($benar * 50) / 7 + 150)
                        ]);
                    }

                    $this->userHistoryEventOfflineModel->update($getHistory['id'], [
                        'id_soal' => join(',', $idSoal),
                        'answare' => join(',', $answare),
                    ]);
                    // dd($getHistory);
                }
            } else {
                $cekUserAns = $this->userAnswareModel->where(['user_id' => $x['user_id']])->findAll();
                if (sizeof($cekUserAns) > 0) {
                    $idSoal = [];
                    $answare = [];
                    $benar = 0;
                    foreach ($cekUserAns as $dataAns) {
                        $cekSoalId = $this->bankSoalModel->where([
                            'id_soal' => $dataAns['id_soal'],
                        ])->first();

                        if ($dataAns['answare'] == $cekSoalId['ans_id']) {
                            $benar++;
                        }

                        array_push($idSoal, $dataAns['id_soal']);
                        array_push($answare, $dataAns['answare']);
                    }

                    $cekRangking = $this->eventReangkingSimulasi->where(['id_user' => $x['user_id']])->first();
                    if ($cekRangking) {
                        $this->eventReangkingSimulasi->update($cekRangking['id'], [
                            'skor' => round(($benar * 50) / 7 + 150)
                        ]);
                    } else {
                        $user = $this->usersModel->where(['slug' => $x['user_id']])->first();
                        $kampus = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();

                        $this->eventReangkingSimulasi->save([
                            'id_user' => $user['slug'],
                            'user_name' => $user['username'],
                            'email' => $user['email'],
                            'id_universitas' => $kampus['id_universitas'],
                            'universitas_pilihan' => $kampus['nama_universitas'],
                            'asal_sekolah' => $user['asal_sekolah'],
                            'skor' => round(($benar * 50) / 7 + 150)
                        ]);
                    }

                    $this->userHistoryEventOfflineModel->save([
                        'user_id' => $x['user_id'],
                        'quiz_id' => "bd30bbba-f5c5-4dac-89ff-43a5073bc9c8",
                        'id_soal' => join(',', $idSoal),
                        'quiz_type' => 'snbt_utbk_2023',
                        'quiz_category' => 'offline',
                        'answare' => join(',', $answare),
                    ]);
                    // dd($cekUserAns);
                }
            }
        }
    }
}
