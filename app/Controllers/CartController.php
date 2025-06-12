<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionItemModel;
use CodeIgniter\Controller;

class CartController extends Controller
{
    protected $session;
    protected $cartModel;
    protected $productModel;
    protected $transactionModel;
    protected $txnItemModel;

    public function __construct()
    {
        $this->session = session();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->transactionModel = new TransactionModel();
        $this->txnItemModel = new TransactionItemModel();

        // Cek jika belum login → redirect ke /login
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $userId = $this->session->get('id');
        $carts  = $this->cartModel->getCartByUser($userId);

        $total = 0;
        foreach ($carts as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        $data = [
            'carts' => $carts,
            'total' => $total
        ];
        echo view('templates/header', $data);
        echo view('cart/index', $data);
        echo view('templates/footer');
    }

    public function add()
    {
        $userId    = $this->session->get('id');
        $productId = $this->request->getPost('product_id');
        $qty       = (int) $this->request->getPost('quantity');

        // Cek apakah produk sudah ada di keranjang → update atau save baru
        $existing = $this->cartModel
                         ->where('user_id', $userId)
                         ->where('product_id', $productId)
                         ->first();

        if ($existing) {
            $newQty = $existing['quantity'] + $qty;
            $this->cartModel->update($existing['id'], ['quantity' => $newQty]);
        } else {
            $this->cartModel->save([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $qty
            ]);
        }

        return redirect()->to('/cart');
    }

    public function update($cartId)
    {
        $qty = (int) $this->request->getPost('quantity');
        if ($qty < 1) {
            // hapus item jika quantity < 1
            $this->cartModel->delete($cartId);
        } else {
            $this->cartModel->update($cartId, ['quantity' => $qty]);
        }
        return redirect()->to('/cart');
    }

    public function checkout()
    {
        $userId = $this->session->get('id');
        $carts  = $this->cartModel->getCartByUser($userId);

        if (empty($carts)) {
            $this->session->setFlashdata('error', 'Keranjang kosong.');
            return redirect()->to('/cart');
        }

        // Hitung total
        $totalAll = 0;
        foreach ($carts as $item) {
            $totalAll += ($item['price'] * $item['quantity']);
        }

        // Simpan header transaksi (langsung status = 'paid' untuk demo)
        $txnId = $this->transactionModel->insert([
            'user_id'     => $userId,
            'game'        => $item['game'],         // jika tiap transaksi hanya 1 item, bisa ambil game dari $item
            'diamond_amount' => $item['diamond'],   // jika produk menyimpan field 'diamond'
            'total_price' => $totalAll,
            'bank'        => 'CartCheckout',       // contoh, atau simpan metode pembayaran lain
            'status'      => 'paid',
        ]);

        // Simpan detail tiap item
        foreach ($carts as $item) {
            $this->txnItemModel->insert([
                'transaction_id' => $txnId,
                'product_id'     => $item['product_id'],
                'quantity'       => $item['quantity'],
                'price_each'     => $item['price'],
                'subtotal'       => $item['price'] * $item['quantity'],
            ]);
        }

        // Bersihkan keranjang
        $this->cartModel->where('user_id', $userId)->delete();

        $this->session->setFlashdata('success', 'Pembayaran berhasil. Terima kasih!');
        return redirect()->to('/transactions');
    }
}
