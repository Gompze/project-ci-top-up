<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionItemModel;
use CodeIgniter\Controller;
use App\Models\CartModel;

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
        $this->cartModel        = new CartModel();
        
        if (! $this->session->get('isLoggedIn')) {
            
            header('Location: ' . base_url('login'));
            exit;
        }
    }
    
    public function index()
    {
        $userId = $this->session->get('id');
        $txns = $this->transactionModel->getByUserWithItemsFlat($userId);
        
        // ⬇️ Ganti blok ini
        $bankMap = [];
        
        foreach ($txns as &$row) {
            $txnId = $row['transaction_id'];
            if (!isset($bankMap[$txnId])) {
                $bankMap[$txnId] = $row['bank'];
            }
            
            // Selalu timpa, karena bank untuk 1 transaksi pasti sama
            $row['bank'] = $bankMap[$txnId];
        }
        unset($row);
        
        $data = ['transactions' => $txns];
        
        echo view('templates/header');
        echo view('transactions/index', $data);
        echo view('templates/footer');
    }
    
    public function create()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userId = session()->get('id');
        $carts  = $this->cartModel->getCartByUser($userId);
        
        if (empty($carts)) {
            session()->setFlashdata('error', 'Keranjang kosong.');
            return redirect()->to('/cart');
        }
        
        $totalAll = array_reduce($carts, fn($sum, $item) => $sum + ($item['diamond_price'] * $item['quantity']), 0);
        
        $bank = '';
        foreach ($carts as $item) {
            if (!empty($item['payment_method'])) {
                $bank = $item['payment_method'];
                break; // ambil yang pertama ditemukan
            }
        }

        $first = $carts[0];
        $txnId = $this->transactionModel->insert([
            'user_id'        => $userId,
            'game'           => $first['game'],
            'diamond_amount' => $first['diamond_amount'],
            'total_price'    => $totalAll,
            'bank'           => $bank, 
        ]);
        
        
        foreach ($carts as $item) {
            $this->txnItemModel->insert([
                'transaction_id' => $txnId,
                'product_id'     => $item['product_id'],
                'game'           => $item['game'],
                'quantity'       => $item['quantity'],
                'price_each'     => $item['diamond_price'],
                'subtotal'       => $item['diamond_price'] * $item['quantity'],
            ]);
        }
        
        
        $this->cartModel->where('user_id', $userId)->delete();
        session()->remove('cart_total');
        
        session()->set('last_transaction_id', $txnId);
        
        return redirect()->to('/transactions');
    }
    
}
