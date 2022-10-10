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
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'premium_simulation'])->groupBy(['quiz_id'])->findAll();
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

            $date_different = strtotime($current_date_time) - strtotime($deatline_time);
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


        $split_deadline = explode("-", '19-10-2022');
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
            session()->setFlashdata('failed', "Masa Berlaku Pendaftaran Event Simulasi Ini Telah Selesai.");
            return redirect()->to(base_url('home/event_simulasi'))->withInput();
        }

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

        $getJadwal = explode(',', $list_tgl[$cekEventAccount['tgl_mulai']]);
        $getSesi = explode(',', $list_sesi[$cekEventAccount['sesi_pengerjaan']]);

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

        $sesiUser = explode(' - ', $list_sesi[$userScheduleSesi]);

        $scheduled = DateTime::createFromFormat('H:i', date('H:i'));
        $start = DateTime::createFromFormat('H:i', $sesiUser[0]);
        $end = DateTime::createFromFormat('H:i', $sesiUser[1]);

        if ($cekAccount) {
            if ($cekAccount['tgl_mulai']) {
                $split_deadline = explode("-", $cekAccount['tgl_mulai']);
                $deatline_time = $split_deadline[0] . "-" . $split_deadline[1] . "-" . $split_deadline[2];

                $curret_date = date('Y-m-d');
                $split_current_date = explode("-", $curret_date);
                $current_date_time = $split_current_date[2] . "-" . $split_current_date[1] . "-" . $split_current_date[0];

                if ($deatline_time == $current_date_time) {
                    if ($scheduled < $start && $scheduled > $end) {
                        session()->setFlashdata('failed', "Masa Pengerjaan Belum Berlangsung.");
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
            session()->setFlashdata('failed', "Anda Tidak Memiliki Akses Ke Kelas Ini, Silahkan Melakukan Pembelian Paket Terlebih Dahulu.");
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
            'title' => 'Daftar Hasil Latihan Schuler.id',
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
            'title' => 'Daftar Hasil Latihan Schuler.id',
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

        \Midtrans\Config::$serverKey = 'SB-Mid-server-6FN2MeuPD9HI0q9MDl4E8_6b';
        \Midtrans\Config::$isProduction = false;
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

        \Midtrans\Config::$serverKey = 'SB-Mid-server-6FN2MeuPD9HI0q9MDl4E8_6b';
        \Midtrans\Config::$isProduction = false;
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

        \Midtrans\Config::$serverKey = 'SB-Mid-server-6FN2MeuPD9HI0q9MDl4E8_6b';
        \Midtrans\Config::$isProduction = false;
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

        \Midtrans\Config::$serverKey = 'SB-Mid-server-6FN2MeuPD9HI0q9MDl4E8_6b';
        \Midtrans\Config::$isProduction = false;
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

    // ERROR
    public function error_404()
    {
        return view('errors/html/error_404');
    }
}
