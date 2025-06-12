<?php

namespace App\Controllers;
use App\Models\PasienModel;

class PasienController extends BaseController {
    private $pasienModel;

    public function __construct() {
        $this->pasienModel = new PasienModel();
    }

    public function index() {
        $data['pasien'] = $this->pasienModel->findAll();
        return view('PasienView', $data);
    }

    public function simpan() {
        
        $data = [
            'no_rm' => $this->request->getPost('no_rm'),
            'nama'  => $this->request->getPost('nama'),
            'jenis' => $this->request->getPost('jenis'),
            'dokter'=> $this->request->getPost('dokter'),
        ];
       
        $this->pasienModel->insert($data);
        return redirect()->to('pasien');
    }

    public function hapus($id) {
        $this->pasienModel->delete($id);
        return redirect()->to('pasien');
    }
}
