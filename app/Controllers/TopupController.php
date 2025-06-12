<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use CodeIgniter\Controller;

class TopupController extends Controller
{
  public function purchase()
    {
        helper('form');
        echo view('templates/header');
        echo view('topup/purchase');
        echo view('templates/footer');
    }

    public function processPurchase()
    {
        helper('form');

        // Validasi input (tanpa user_id, sudah pakai session)
        $rules = [
            'selected_game'   => 'required',
            'zone_id'         => 'permit_empty|integer',
            'diamond_amount'  => 'required|integer',
            'diamond_price'   => 'required|integer',
            'payment_method'  => 'required',
            'email'           => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            echo view('templates/header');
            echo view('topup/purchase', ['validation' => $this->validator]);
            echo view('templates/footer');
            return;
        }

        // Ambil POST
        $game           = $this->request->getPost('selected_game');
        $zoneId         = $this->request->getPost('zone_id') ?: null;
        $diamondAmount  = $this->request->getPost('diamond_amount');
        $diamondPrice   = $this->request->getPost('diamond_price');
        $paymentMethod  = $this->request->getPost('payment_method');
        $email          = $this->request->getPost('email');

        // user_id dari session
        $userId = session()->get('id');

        // Simpan transaksi
        $transactionModel = new TransactionModel();
        $newTxnId = $transactionModel->insert([
            'user_id'        => $userId,
            'game'           => $game,
            'diamond_amount' => $diamondAmount,
            'total_price'    => $diamondPrice,
            'bank'           => $paymentMethod,
            'zone_id'        => $zoneId,
            'email'          => $email,
            'status'         => 'waiting_confirmation',
        ]);

        // Simpan di session untuk konfirmasi
        session()->set('current_txn_id', $newTxnId);
        session()->set('selected_bank', $paymentMethod);

        // Tampilkan detail (opsional)
        echo view('templates/header');
        echo view('topup/detail', [
            'txn_id'         => $newTxnId,
            'game'           => $game,
            'user_id'        => session()->get('id'),
            'zone_id'        => $zoneId,
            'diamond_amount' => $diamondAmount,
            'diamond_price'  => $diamondPrice,
            'payment_method' => $paymentMethod,
            'email'          => $email,
        ]);
        echo view('templates/footer');
    }

    public function confirmTransfer()
    {
        // Ambil bank dan akun dari session + model
        $bank = session()->get('selected_bank');
        $txn  = (new TransactionModel())->find(session()->get('current_txn_id'));

        $accounts = [
            'BCA'     => '123-456-7890 a.n. PT. PayStore',
            'Mandiri' => '098-765-4321 a.n. PT. PayStore',
            'BNI'     => '321-654-0987 a.n. PT. PayStore',
            'BRI'     => '789-012-3456 a.n. PT. PayStore',
        ];

        echo view('templates/header');
        echo view('topup/confirm_transfer', [
            'bank'    => $bank,
            'account' => $accounts[$bank] ?? null,
            'amount'  => $txn['total_price'] ?? 0,
        ]);
        echo view('templates/footer');
    }

    public function uploadBuktiForm()
    {
        helper('form');
        echo view('templates/header');
        echo view('topup/upload_bukti_form');
        echo view('templates/footer');
    }

    public function uploadBuktiProcess()
    {
        helper('form');

        $file = $this->request->getFile('bukti_transfer');
        if (! $file->isValid()) {
            session()->setFlashdata('error', 'Gagal unggah bukti transfer.');
            return redirect()->back()->withInput();
        }

        // Validasi MIME type
        $allowed = ['image/jpeg','image/png','application/pdf'];
        if (! in_array($file->getMimeType(), $allowed)) {
            session()->setFlashdata('error', 'Tipe file tidak didukung.');
            return redirect()->back()->withInput();
        }

        // Simpan file
        $uploadPath = WRITEPATH . 'uploads/bukti/';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        // Update status transaksi
        $txnId = session()->get('current_txn_id');
        if ($txnId) {
            (new TransactionModel())->update($txnId, ['status' => 'paid']);
        }

        session()->setFlashdata('success', 'Bukti transfer berhasil diunggah.');
        return redirect()->to('/transactions');
    }
}
