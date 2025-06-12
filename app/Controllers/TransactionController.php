<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionItemModel;
use CodeIgniter\Controller;

class TransactionController extends Controller
{
    protected $session;
    protected $transactionModel;
    protected $txnItemModel;

    public function __construct()
    {
        $this->session = session();
        $this->transactionModel = new TransactionModel();
        $this->txnItemModel = new TransactionItemModel();

        if (! $this->session->get('isLoggedIn')) {
            // redirect di constructor tidak bisa langsung return,
            // jadi kita bisa lempar exception atau set flag:
            header('Location: ' . base_url('login'));
            exit;
        }
    }

    public function index()
    {
        $userId = $this->session->get('id');
        $txns   = $this->transactionModel->getByUser($userId);

        $data = ['transactions' => $txns];

        echo view('templates/header');
        echo view('transactions/index',  $data);
        echo view('templates/footer');
    }

    public function detail($id)
    {
        $userId = $this->session->get('id');
        $txn    = $this->transactionModel->find($id);

        if (! $txn || $txn['user_id'] != $userId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Transaksi tidak ditemukan.');
        }

        $items = $this->txnItemModel->getItemsByTransaction($id);
        $data  = ['transaction' => $txn, 'items' => $items];

        echo view('templates/header');
        echo view('transactions/detail', $data);
        echo view('templates/footer');
    }
}
