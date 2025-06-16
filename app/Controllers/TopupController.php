<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use CodeIgniter\Controller;
use App\Controllers\TransactionController;

class TopupController extends Controller
{
    protected $helpers = ['url','form'];
    protected $transactionController;

    public function __construct()
    {
        $this->transactionController = new TransactionController();
    }
    
    public function purchase()
    {
        
        $productModel = new ProductModel();
        $data['products'] = $productModel
        ->orderBy('game','ASC')
        ->findAll();
        
        echo view('templates/header');
        echo view('topup/purchase', $data);
        echo view('templates/footer');
    }
    
    public function processPurchase()
    {
        helper('form');
        
        
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
        
        
        $game           = $this->request->getPost('selected_game');
        $zoneId         = $this->request->getPost('zone_id') ?: null;
        $diamondAmount  = $this->request->getPost('diamond_amount');
        $diamondPrice   = $this->request->getPost('diamond_price');
        $paymentMethod  = $this->request->getPost('payment_method');
        $email          = $this->request->getPost('email');
        
        
        $userId = session()->get('id');
        
        
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
        
        
        session()->set('current_txn_id', $newTxnId);
        session()->set('selected_bank', $paymentMethod);
        
        
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
    
    public function confirmTransfer(array $data)
    {
        
        $bank = $data['bank'];
        $txn  = (new TransactionModel())->find(session()->get('current_txn_id'));
        
        $accounts = [
            'BCA'     => '123-456-7890 a.n. PT. PayStore',
            'Mandiri' => '098-765-4321 a.n. PT. PayStore',
            'BNI'     => '321-654-0987 a.n. PT. PayStore',
            'BRI'     => '789-012-3456 a.n. PT. PayStore',
        ];

        $selectedBank = '';
        foreach($accounts as $key => $value) {
            if (strtolower($bank) === strtolower($key)) {
                $selectedBank = $value;
                break;
            }
        }


        session()->set('success', 'Transaksi akan diproses dan akan dinotifikasikan melalui email.');
        echo view('templates/header');
        
        echo view('topup/confirm_transfer', [
            'bank'    => $bank,
            'account' => $accounts[$bank] ?? null,
            'amount'  => $data['total'] ?? 0,
        ]);
        
        echo view('templates/footer');
        
        
    }


    
    
}
