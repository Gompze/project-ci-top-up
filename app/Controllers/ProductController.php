<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $data = [
            'products' => $productModel->orderBy('game','ASC')->findAll()
        ];
        echo view('templates/header', $data);
        echo view('product/index',   $data);
        echo view('templates/footer');
    }

    public function detail($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }
        $data = ['product' => $product];
        echo view('templates/header', $data);
        echo view('product/detail',   $data);
        echo view('templates/footer');
    }
}