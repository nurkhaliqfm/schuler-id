<?php

namespace App\Controllers;

use App\Models\TypeSoalModel;
use App\Models\BankSoalModel;
use App\Models\BankQuizModel;
use App\Models\QuizModel;
use App\Models\CategoryQuizModel;
use App\Models\UsersModel;

class Home extends BaseController
{
    protected $typeSoalModel;
    protected $bankSoalModel;
    protected $bankQuizModel;
    protected $quizModel;
    protected $categoryQuizModel;
    protected $usersModel;

    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->bankQuizModel = new BankQuizModel();
        $this->quizModel = new QuizModel();
        $this->categoryQuizModel = new CategoryQuizModel();
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/dashboard', $data);
    }

    // PROGRAM KHUSUS
    public function super_camp_utbk()
    {
        $data = [
            'title' => 'Super Camp UTBK Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/program-khusus/super-camp-utbk', $data);
    }

    // MENU UTBK LATIHAN
    public function daftar_latihan()
    {
        $categoryQuiz = $this->categoryQuizModel->where(['group' => '0'])->findAll();
        $data = [
            'title' => 'Daftar Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'data_type' => $categoryQuiz
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-list', $data);
    }

    public function latihan_home($slug = "")
    {
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

        $filterCategory = $this->categoryQuizModel->where(['slug' => $slug])->first();
        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'practice'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $remakeBankQuiz[] = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => $timer['quiz_timer'] / 60
            );
        }

        $data = [
            'title' => 'Daftar Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'quiz_group' => $slug,
            'type_soal' => $typeSoal,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $filterCategory['category_item']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-home', $data);
    }

    public function latihan_guide()
    {
        $query = $this->request->getVar('query');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();

        $data = [
            'title' => 'Petunjuk Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-guide', $data);
    }

    public function kerjakan_latihan()
    {
        $query = $this->request->getVar('query');

        $quizData = $this->bankQuizModel->where([
            'quiz_id' => $query
        ])->findAll();

        $bankSoal = $this->bankSoalModel->findAll();
        $typeSoal = $this->typeSoalModel->findAll();
        $navbarTitle = "Latihan " . $quizData[0]['quiz_name'];
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $quizData[0]['quiz_category']])->first();

        $data = [
            'title' => 'Kerjakan Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'type_soal' => $typeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-main', $data);
    }

    public function hasil_latihan()
    {
        $data = [
            'title' => 'Hasil Latihan Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/latihan-utbk/hasil-latihan', $data);
    }

    // MENU UTBK SIMULASI
    public function simulasi_gratis()
    {
        $cekCategoryQuiz = $this->categoryQuizModel->where([
            'group' => '0'
        ])->findAll();

        $bankQuiz = $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_category' => 'free_simulation'])->groupBy(['quiz_id'])->findAll();
        foreach ($bankQuiz as  $bq) {
            $count = $this->bankQuizModel->where(['quiz_id' => $bq['quiz_id']])->findAll();
            $timer = $this->quizModel->where(['slug' => $bq['quiz_category']])->first();
            $remakeBankQuiz[] = array(
                'quiz_id' => $bq['quiz_id'],
                'quiz_subject' => $bq['quiz_subject'],
                'quiz_name' => $bq['quiz_name'],
                'total_soal' => count($count),
                'timer' => ($timer['quiz_timer'] / 60) * 8,
                'quiz_type' => $bq['quiz_type']
            );
        }

        $data = [
            'title' => 'Simulasi Gratis Schuler.id',
            'user_name' => 'codefm.my.id',
            'type_soal' => $cekCategoryQuiz,
            'bank_quiz' => $remakeBankQuiz,
            'filter_category' => $this->categoryQuizModel->where(['group' => '0'])->findAll()
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-home', $data);
    }

    public function simulasi_gratis_guide()
    {
        $query = $this->request->getVar('query');
        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $dataQuiz[0]['quiz_category']])->first();

        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => 'codefm.my.id',
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz),
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer']
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-guide', $data);
    }

    public function kerjakan_simulasi_geratis()
    {
        $query = $this->request->getVar('query');

        $quizData = $this->bankQuizModel->where([
            'quiz_id' => $query
        ])->findAll();

        $bankSoal = $this->bankSoalModel->findAll();
        $typeSoal = $this->typeSoalModel->findAll();
        $navbarTitle = "Simulasi " . strtoupper($quizData[0]['quiz_name']);
        $users = $this->usersModel->where(['email' => session()->get('username')])->first();
        $timer = $this->quizModel->where(['slug' => $quizData[0]['quiz_category']])->first();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => 'codefm.my.id',
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'type_soal' => $typeSoal,
            'navbar_title' => $navbarTitle,
            'session_id' => $users['slug'],
            'timer' => $timer['quiz_timer']
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-main', $data);
    }

    public function simulasi_premium()
    {
        $data = [
            'title' => 'Simulasi Premium Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/simulasi-premium', $data);
    }
    public function hasil_simulasi()
    {
        $data = [
            'title' => 'Hasil Simulasi Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/hasil-simulasi', $data);
    }
}
