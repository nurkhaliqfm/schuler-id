<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\CategoryQuizModel;
use App\Models\UserHistoryEventModel;
use App\Models\MitraModel;
use App\Models\MitraStudentModel;
use App\Models\MitraEventModel;
use App\Models\UserHistoryEventOfflineModel;
use App\Models\TypeSoalModel;

class PdfController extends BaseController
{
    protected $typeSoalModel;
    protected $categoryQuizModel;
    protected $userHistoryEventModel;
    protected $mitraModel;
    protected $mitraStudentModel;
    protected $mitraEventModel;
    protected $userHistoryEventOfflineModel;

    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->categoryQuizModel = new CategoryQuizModel();
        $this->userHistoryEventModel  = new UserHistoryEventModel();
        $this->mitraModel = new MitraModel();
        $this->mitraStudentModel = new MitraStudentModel();
        $this->mitraEventModel = new MitraEventModel();
        $this->userHistoryEventOfflineModel  = new UserHistoryEventOfflineModel();
    }

    public function cetak_pembahasan()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');

        $categoryQuiz = $this->categoryQuizModel->where(['group' => '3'])->first();

        $cekAccount = $this->akunEventModel->where([
            'user_id' => $user['slug'],
            'paket_name' => $categoryQuiz['slug']
        ])->first();

        $cekEventResult = $this->userHistoryEventModel->where([
            'user_id' => $user['slug'],
            'quiz_type' => $categoryQuiz['slug'],
        ])->first();

        $dataQuiz = $this->bankQuizModel->where([
            'quiz_id' => $query,
        ])->orderBy('quiz_subject', 'quiz_sub_subject')->findAll();

        $dataJawaban = explode(',', $cekEventResult['answare']);
        $dataSoal = [];
        $dataYourAns = [];
        $x = 0;
        foreach ($dataQuiz as $ds) {
            $bankSoal = $this->bankSoalModel->where([
                'id_soal' => $ds['quiz_question']
            ])->first();
            if ($bankSoal) {
                array_push($dataSoal, $bankSoal);
                $dataYourAns[$ds['quiz_question']] = $dataJawaban[$x];
                $x++;
            }
        }

        if (!$cekAccount && !$cekEventResult) {
            return redirect()->to(base_url('home/event-simulasi'));
        }

        $data = [
            'user_name' => $user['username'],
            'data_soal' => $dataSoal,
            'data_jawaban' => $dataYourAns,
        ];

        $filename = 'Pembahasan-Event-UTBK-2023-' . date('y-m-d-H-i-s');
        $dompdf = new Dompdf();
        $option = new Options();
        $dompdf->loadHtml(view('pdf_pembahasan', $data));
        $dompdf->setPaper('Legal', 'portrait');
        $option->set('isRemoteEnabled', true);
        $dompdf->setOptions($option);
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => 0));
        exit();
    }
    
    public function cetak_kartu_peserta()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $mitraID = $this->request->getVar('m');
        
        $mitraEvent = $this->mitraEventModel->where([
            'mitra_id' => $mitraID,
        ])->first();

        $cekEventAccount = $this->mitraStudentModel->where([
            'user_id' => $user['slug'],
        ])->first();
        
        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();
        
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
        $schedule = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

        $data = [
            'user_name' => $user['username'],
            'peserta_name' => $cekEventAccount['peserta_name'],
            'nomor_peserta' => $cekEventAccount['nomor_peserta'],
            'tgl_lahir' => $cekEventAccount['tgl_lahir'],
            'nisn' => $cekEventAccount['peserta_id'],
            'hari' => $hari[$num],
            'tanggal' => $schedule,
            'jam' => $cekEventAccount['schedule'],
            'pusat_simulasi' => $cekEventAccount['mitra_name'],
            'ruangan' => $cekEventAccount['location'],
            'universitas_pilihan' => $getUniversitas['nama_universitas'],
        ];

        $filename = 'Kartu-Peserta-Simulasi-UTBK-2023-' . date('y-m-d-H-i-s');
        $dompdf = new Dompdf();
        $option = new Options();
        $dompdf->loadHtml(view('kartu-pendaftaran', $data));
        $dompdf->setPaper('A4', 'portrait');
        $option->set('isRemoteEnabled', true);
        $dompdf->setOptions($option);
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => 0));
        exit();
    }
    
    public function cetak_sertifikat_peserta()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $query = $this->request->getVar('query');
        $mitraID = $this->request->getVar('m');
        
        $mitraEvent = $this->mitraEventModel->where([
            'mitra_id' => $mitraID,
        ])->first();

        $cekEventAccount = $this->mitraStudentModel->where([
            'user_id' => $user['slug'],
        ])->first();
        
        $getUniversitas = $this->universitasModel->where(['id_universitas' => $user['universitas_pilihan']])->first();
        
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
        $schedule = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
        
        $userHistoryEvent = $this->userHistoryEventOfflineModel->where([
            'quiz_id' => "566cf1a1-c0f4-4d16-9dbf-9ad9beb39b00",
            'user_id' => $cekEventAccount['user_id']
        ])->first();
        
        if (!$userHistoryEvent) {
            session()->setFlashdata('failed', "Mohon Maaf Data Simulasi Anda Tidak Ditemukan.");
            return redirect()->to(base_url('home/offline_simulasi_guide?id=' . $id . '&query=' . $query . '&m=' . $mitraID))->withInput();
        } 
        
        $explodeSoalID = explode(",", $userHistoryEvent['id_soal']);
        $explodeSoalAns = explode(",", $userHistoryEvent['answare']);
        
        $AllCategoryQuiz = $this->categoryQuizModel->where(['slug' => 'snbt_utbk_2023'])->first();
        $listCategory = explode(',', $AllCategoryQuiz['category_item']);
        
        foreach($listCategory as $lC){
            $getTestCategory = $this->typeSoalModel->where([
                'id_main_type_soal' => $lC
            ])->first();
            
            $dataSubtestID = explode(',', $getTestCategory['list_type_soal_id']);
            $dataSubtestName = explode(',', $getTestCategory['list_type_soal']);
            
            $dataEachSubsubject = [];
            
            for($j=0; $j<sizeof($dataSubtestID); $j++){
                $namaSubjectSoal = $dataSubtestName[$j];
                
                $benar = 0;
                
                $cekBankQuiz = $this->bankQuizModel->where([
                    'quiz_id' => "566cf1a1-c0f4-4d16-9dbf-9ad9beb39b00",
                    'quiz_sub_subject' => $dataSubtestID[$j]
                ])->findAll();
                
                foreach($cekBankQuiz as $cBQ){
                    $quiz_id = $cBQ['quiz_question'];
                    $userAnsId = array_search($quiz_id, $explodeSoalID);
                    $cekSoalId = $this->bankSoalModel->where([
                        'id_soal' => $quiz_id,
                    ])->first();
                    
                    if($explodeSoalAns[$userAnsId] == $cekSoalId['ans_id']){
                        $benar++;
                    }
                }
                
                $dataAnsCategory[$namaSubjectSoal] = [
                    'Poin' => $benar*50
                ]; 
                
                array_push($dataEachSubsubject, $dataAnsCategory);
            }
        }

        $data = [
            'user_name' => $user['username'],
            'peserta_name' => $cekEventAccount['peserta_name'],
            'nomor_peserta' => $cekEventAccount['nomor_peserta'],
            'tgl_lahir' => $cekEventAccount['tgl_lahir'],
            'nisn' => $cekEventAccount['peserta_id'],
            'hari' => $hari[$num],
            'tanggal' => $schedule,
            'poin' => $dataEachSubsubject[0],
            'jam' => $cekEventAccount['schedule'],
            'pusat_simulasi' => $cekEventAccount['mitra_name'],
        ];

        $filename = 'Sertifikat-Peserta-Simulasi-UTBK-2023-' . date('y-m-d-H-i-s');
        $dompdf = new Dompdf();
        $option = new Options();
        $dompdf->loadHtml(view('sertifikat-peserta', $data));
        $dompdf->setPaper('A4', 'portrait');
        $option->set('isRemoteEnabled', true);
        $dompdf->setOptions($option);
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => 0));
        exit();
    }
}
