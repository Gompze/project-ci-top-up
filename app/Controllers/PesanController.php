<?php   

namespace App\Controllers;

class PesanController extends BaseController
{
    public function proses($p = 'kosong')
    {
        $data['pesan'] = $_GET['pesan'];
        return view('tampil', $data);
    }
    public function input()
    {
        return view('input');
    }
}