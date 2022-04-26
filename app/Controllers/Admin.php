<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;

use App\Models\TypeSoalModel;
use App\Models\BankSoalModel;

class Admin extends BaseController
{
    protected $typeSoalModel;
    protected $bankSoalModel;

    public function __construct()
    {
        $this->typeSoalModel = new TypeSoalModel();
        $this->bankSoalModel = new BankSoalModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('admin/dashboard', $data);
    }

    public function bank_soal()
    {
        $typeSoalModel = $this->typeSoalModel->findAll();
        $data = [
            'title' => 'Bank Soal Schuler.id',
            'user_name' => 'codefm.my.id',
            'type_soal' => $typeSoalModel
        ];

        return view('admin/bank-soal/bank-soal', $data);
    }

    public function jenis_bank_soal()
    {
        $menuSoal = $this->request->getVar('MenuSoal');
        $typeSoalModel = $this->typeSoalModel->where(['id_main_type_soal' => $menuSoal])->first();

        $data = [
            'title' => 'Bank Soal Schuler.id',
            'user_name' => 'codefm.my.id',
            'type_soal' => $typeSoalModel
        ];

        return view('admin/bank-soal/bank-soal-type', $data);
    }

    public function daftar_soal($menuSoal, $submenuSoal)
    {
        $bankSoalModel = $this->bankSoalModel->where([
            'type_soal' => $menuSoal,
            'sub_type_soal' => $submenuSoal
        ])->findAll();


        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => 'codefm.my.id',
            'bank_soal' => $bankSoalModel,
            'menu_soal' => $menuSoal,
            'submenu_soal' => $submenuSoal
        ];

        return view('admin/bank-soal/daftar-soal', $data);
    }

    public function input_soal($id, $type)
    {
        $data = [
            'title' => 'Daftar Soal Schuler.id',
            'user_name' => 'codefm.my.id',
            'menu_soal' => $id,
            'submenu_soal' => $type,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/bank-soal/input-soal', $data);
    }

    public function edit_soal($idSoal)
    {
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
            'user_name' => 'codefm.my.id',
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
            'id_soal' => Uuid::uuid4(),
            'soal' => $this->request->getVar('editorQuestion'),
            'option_a' => $this->request->getVar('option_a'),
            'option_b' => $this->request->getVar('option_b'),
            'option_c' => $this->request->getVar('option_c'),
            'option_d' => $this->request->getVar('option_d'),
            'option_e' => $this->request->getVar('option_e'),
            'jawaban' => md5($questionAns[0]),
            'pembahasan' => $this->request->getVar('editorExplanation'),
            'value' => $this->request->getVar('questionValue')
        ]);

        session()->setFlashdata('success', "Soal Berhasil Ditambahkan.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function duplicat_soal($idSoal)
    {

        $getBankSoal = $this->bankSoalModel->where([
            'id_soal' => $idSoal
        ])->first();

        $menuSoal = $getBankSoal['type_soal'];
        $submenuSoal = $getBankSoal['sub_type_soal'];

        $bankSoalModel = $this->bankSoalModel;
        $bankSoalModel->save([
            'type_soal' => $menuSoal,
            'sub_type_soal' => $submenuSoal,
            'id_soal' => Uuid::uuid4(),
            'soal' => $getBankSoal['soal'],
            'option_a' => $getBankSoal['option_a'],
            'option_b' => $getBankSoal['option_b'],
            'option_c' => $getBankSoal['option_c'],
            'option_d' => $getBankSoal['option_d'],
            'option_e' => $getBankSoal['option_e'],
            'jawaban' => $getBankSoal['jawaban'],
            'pembahasan' => $getBankSoal['pembahasan'],
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

        session()->setFlashdata('success', "Soal Berhasil Ditambahkan.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function update_soal()
    {
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
        $bankSoalModel->update($this->request->getVar('id'), [
            'soal' => $this->request->getVar('editorQuestion'),
            'option_a' => $this->request->getVar('option_a'),
            'option_b' => $this->request->getVar('option_b'),
            'option_c' => $this->request->getVar('option_c'),
            'option_d' => $this->request->getVar('option_d'),
            'option_e' => $this->request->getVar('option_e'),
            'jawaban' => md5($questionAns[0]),
            'pembahasan' => $this->request->getVar('editorExplanation'),
            'value' => $this->request->getVar('questionValue')
        ]);

        session()->setFlashdata('success_ubah', "Soal Berhasil Diubah.");
        return redirect()->to(base_url('admin/daftar_soal/' . $menuSoal . '/' . $submenuSoal))->withInput();
    }

    public function upload_image()
    {
        $allowExt = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }

        if (in_array($extension, $allowExt)) {
            $fileupload_name = sha1(microtime()) . "." . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "/assets/upload_image/" . $fileupload_name);

            $response = ["link" => $protocol . $_SERVER["HTTP_HOST"] . "/assets/upload_image/" . $fileupload_name];
            return $this->response->setJSON($response);
        }
    }

    public function deleted_image()
    {
        $src = $this->request->getJsonVar('src');
        $src = str_replace(base_url('/'), "", $src);
        if (file_exists(getcwd() . $src)) {
            unlink(getcwd() . $src);
        }
    }

    public function generate_id()
    {
        $id_main_type_soal_tps = Uuid::uuid4();
        $id_main_type_soal_saintek = Uuid::uuid4();
        $id_main_type_soal_soshum = Uuid::uuid4();
        $id_main_type_soal_bing = Uuid::uuid4();

        $id_type_soal_tps_1 = Uuid::uuid4();
        $id_type_soal_tps_2 = Uuid::uuid4();
        $id_type_soal_tps_3 = Uuid::uuid4();
        $id_type_soal_tps_4 = Uuid::uuid4();

        $id_type_soal_soshum_1 = Uuid::uuid4();
        $id_type_soal_soshum_2 = Uuid::uuid4();
        $id_type_soal_soshum_3 = Uuid::uuid4();
        $id_type_soal_soshum_4 = Uuid::uuid4();

        $id_type_soal_saintek_1 = Uuid::uuid4();
        $id_type_soal_saintek_2 = Uuid::uuid4();
        $id_type_soal_saintek_3 = Uuid::uuid4();
        $id_type_soal_saintek_4 = Uuid::uuid4();

        $id_type_soal_bing = Uuid::uuid4();

        $data = [
            'id_main_type_soal_tps' => [
                'id' => "$id_main_type_soal_tps",
                'id_1' => "$id_type_soal_tps_1",
                'id_2' => "$id_type_soal_tps_2",
                'id_3' => "$id_type_soal_tps_3",
                'id_4' => "$id_type_soal_tps_4"
            ],
            'id_main_type_soal_saintek' => [
                'id' => "$id_main_type_soal_saintek",
                'id_1' => "$id_type_soal_saintek_1",
                'id_2' => "$id_type_soal_saintek_2",
                'id_3' => "$id_type_soal_saintek_3",
                'id_4' => "$id_type_soal_saintek_4"
            ],
            'id_main_type_soal_soshum' => [
                'id' => "$id_main_type_soal_soshum",
                'id_1' => "$id_type_soal_soshum_1",
                'id_2' => "$id_type_soal_soshum_2",
                'id_3' => "$id_type_soal_soshum_3",
                'id_4' => "$id_type_soal_soshum_4"
            ],
            'id_main_type_soal_bing' => [
                'id' => "$id_main_type_soal_bing",
                'id_1' => "$id_type_soal_bing",
            ],
        ];

        dd($data);
    }
}
