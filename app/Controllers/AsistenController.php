<?php

namespace App\Controllers;

use App\Models\AsistenModel;

class AsistenController extends BaseController
{
    public function index()
    {
        $model = new AsistenModel();

        // ambil semua data
        $data['asisten'] = $model->findAll();

        // judul halaman
        $data['judul']   = 'Pendaftaran Asisten Praktikum';

        return view('AsistenView', $data);
    }

    public function simpan()
    {
        helper('form');

        if(!$this->request->is('post')){
            return view('simpan');
        }

        $post = $this->request->getPost(['nim', 'nama', 'praktikum', "ipk"]);

        $model = model(AsistenModel::class);

        $model->simpan($post);

        return view('success');
    }

    public function updateAsisten()
	{
		$nim = $this->request->getPost('nim');
		$nama = $this->request->getPost('nama');
		$praktikum = $this->request->getPost('praktikum');
        $ipk = $this->request->getPost('ipk');

        $model = model('AsistenModel');

		$model = model('AsistenModel');
		$model->updateAsisten($nim, $nama, $praktikum, $ipk);

		return view('message_update');
	}
    public function updateAsistenForm()
    {
        return view('update_asisten');
    }

    public function deleteAsisten()
	{
		$nim = $this->request->getPost('nim');

		$model = model('AsistenModel');
		$model->deleteAsisten($nim);

		return view('message_delete');
	}
    public function deleteAsistenForm()
    {
        return view('delete_asisten');
    }
}
