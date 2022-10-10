<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\CategoryQuizModel;
use App\Models\UserHistoryEventModel;

class PdfController extends BaseController
{
    protected $categoryQuizModel;
    protected $userHistoryEventModel;

    public function __construct()
    {
        $this->categoryQuizModel = new CategoryQuizModel();
        $this->userHistoryEventModel  = new UserHistoryEventModel();
    }

    public function cetak_pembahasan()
    {
        $user = $this->usersModel->where(['email' => session()->get('username')])->first();
        if (session()->get('user_level') != 'users') {
            return redirect()->to(base_url('admin/error_404'));
        }

        $id = $this->request->getVar('id');
        $query = $this->request->getVar('query');

        $categoryQuiz = $this->categoryQuizModel->where(['category_id' => $id])->first();

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
        ])->first();

        $dataJawaban = explode(',', $cekEventResult['answare']);
        $dataSoal = [];
        $dataYourAns = [];
        $x = 0;
        foreach (explode(',', $cekEventResult['id_soal']) as $ds) {
            $bankSoal = $this->bankSoalModel->where([
                'id_soal' => $ds
            ])->first();

            if ($bankSoal) {
                array_push($dataSoal, $bankSoal);
                $dataYourAns[$ds] = $dataJawaban[$x];
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
        $dompdf->loadHtml(view('pdf_pembahasan', $data));
        $dompdf->setPaper('Legal', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename, array('Attachment' => 0));
    }
}
