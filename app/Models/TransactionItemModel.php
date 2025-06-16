<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionItemModel extends Model
{
    protected $table      = 'transaction_items';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['transaction_id','product_id','quantity','price_each','subtotal', 'game'];

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getItemsByTransaction($txnId)
    {
        return $this->select('transaction_items.*, products.game, products.diamond')
                    ->join('products','products.id = transaction_items.product_id')
                    ->where('transaction_items.transaction_id', $txnId)
                    ->findAll();
    }
}
