<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionItemModel;
use CodeIgniter\Controller;
use App\Controllers\TopupController;

class CartController extends Controller
{
    protected $session;
    protected $cartModel;
    protected $productModel;
    protected $transactionModel;
    protected $txnItemModel;
    protected $topupController;
    
    
    protected $helpers = ['url', 'form'];
    
    public function __construct()
    {
        $this->session          = session();
        $this->cartModel        = new CartModel();
        $this->productModel     = new ProductModel();
        $this->transactionModel = new TransactionModel();
        $this->txnItemModel     = new TransactionItemModel();
        $this->topupController   = new TopupController();
    }
    
    
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userId = session()->get('id');
        $carts  = $this->cartModel->getCartByUser($userId);
        
        
        if (empty($carts)) {
            session()->setFlashdata('error', 'Keranjang kosong.');
            $data = [
                'carts' => [],
                'total' => 0
            ];
            echo view('templates/header', $data);
            echo view('cart/index', $data);
            echo view('templates/footer');
            return;
        }
        
        
        $totalAll = array_reduce($carts, fn($sum, $item) => $sum + ($item['diamond_price'] * $item['quantity']), 0);
        
        
        $data = [
            'carts' => $carts,
            'total' => $totalAll
        ];
        
        echo view('templates/header', $data);
        echo view('cart/index', $data);
        echo view('templates/footer');
    }
    
    
    
    
    
    public function add()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userId        = session()->get('id');
        $game          = $this->request->getPost('game');
        $zoneId        = $this->request->getPost('zone_id');
        $diamondAmt    = (int)$this->request->getPost('diamond_amount');
        $itemName = $this->request->getPost('item_name'); 
        $price         = (int)$this->request->getPost('diamond_price');
        $paymentMethod = $this->request->getPost('payment_method');
        $email         = $this->request->getPost('email');
        $qty           = max(1, (int)$this->request->getPost('quantity'));
        
        
        $existing = $this->cartModel
        ->where('user_id', $userId)
        ->where('game', $game)
        ->where('diamond_amount', $diamondAmt)
        ->where('item_name', $itemName) 
        ->where('diamond_price', $price)
        ->where('payment_method', $paymentMethod)
        ->first();
        
        if ($existing) {
            
            $this->cartModel->update($existing['id'], [
                'quantity' => $existing['quantity'] + $qty
            ]);
        } else {
            
            $this->cartModel->save([
                'user_id'        => $userId,
                'game'           => $game,
                'zone_id'        => $zoneId,
                'diamond_amount' => $diamondAmt,
                'diamond_price'  => $price,
                'payment_method' => $paymentMethod,
                'email'          => $email,
                'quantity'       => $qty,
                'item_name'      => $itemName,
            ]);
        }
        $this->updateCartTotalSession();
        return redirect()->to('/cart')
        ->with('success','Berhasil tambah ke keranjang.');
    }
    public function update($cartId)
    {
        $qty = (int) $this->request->getPost('quantity');
        if ($qty < 1) {
            $this->cartModel->delete($cartId);
        } else {
            $this->cartModel->update($cartId, ['quantity' => $qty]);
        }
        $this->updateCartTotalSession();
        return redirect()->to('/cart');
    }
    private function updateCartTotalSession()
    {
        $userId = session()->get('id');
        $carts = $this->cartModel->getCartByUser($userId);
        $totalQty = 0;
        
        foreach ($carts as $item) {
            $totalQty += $item['quantity'];
        }
        
        session()->set('cart_total', $totalQty);
    }
    
    
    
    public function checkout()
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
        

        $data = [
            'carts' => $carts,
            'total' => $totalAll,
            'bank' => $bank,
            'user_id' => $userId,
        ];

        return $this->topupController->confirmTransfer($data);
        
    }
}
