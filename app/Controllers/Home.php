<?php

namespace App\Controllers;

use App\Models\TypeSoalModel;
use App\Models\BankSoalModel;
use App\Models\BankQuizModel;
use App\Models\QuizModel;
use App\Models\CategoryQuizModel;

class Home extends BaseController
{
    protected $typeSoalModel;
    protected $bankSoalModel;
    protected $bankQuizModel;
    protected $quizModel;
    protected $categoryQuizModel;

    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->bankQuizModel = new BankQuizModel();
        $this->quizModel = new QuizModel();
        $this->categoryQuizModel = new CategoryQuizModel();
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

        $data = [
            'title' => 'Daftar Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'quiz_group' => $slug,
            'type_soal' => $typeSoal,
            'bank_quiz' => $this->bankQuizModel->orderBy('quiz_name')->where(['quiz_type' => 'practice'])->groupBy(['quiz_id'])->findAll(),
            'filter_category' => $filterCategory['category_item']
        ];

        return view('home/menu-utbk/latihan-utbk/latihan-home', $data);
    }

    public function latihan_guide()
    {
        $query = $this->request->getVar('query');

        $dataQuiz = $this->bankQuizModel->where(['quiz_id' => $query])->findAll();
        $data = [
            'title' => 'Petunjuk Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'nama_quiz' => $dataQuiz[0]['quiz_name'],
            'jumlah_soal' => count($dataQuiz)
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

        $data = [
            'title' => 'Kerjakan Latihan Schuler.id',
            'user_name' => 'codefm.my.id',
            'bank_soal' => $bankSoal,
            'quiz_data' => $quizData,
            'type_soal' => $typeSoal,
            'navbar_title' => $navbarTitle
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
        $data = [
            'title' => 'Simulasi Gratis Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-home', $data);
    }

    public function simulasi_gratis_guide()
    {
        $data = [
            'title' => 'Petunjuk Simulasi Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-guide', $data);
    }

    public function simulasi_gratis_main()
    {
        $bankSoalModel = $this->bankSoalModel->where([
            'type_soal' => '22b9f14e-867a-41d0-a758-55070c6bd603'
        ])->findAll();

        $data = [
            'title' => 'Simulasi Schuler.id',
            'user_name' => 'codefm.my.id',
            'bank_soal' => $bankSoalModel
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
