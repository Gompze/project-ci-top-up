<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'total_price',
        'status',
        'game',
        'diamond_amount',
        'bank',
        'zone_id',
        'email',
        'bukti_transfer'  
    ];

  public function getByUserWithItemsFlat($userId)
{
    return $this->db->table('transactions')
     ->select('
    transactions.id as transaction_id,
    transactions.user_id,
    transactions.zone_id,
    transactions.total_price,
    transactions.bank,
    transaction_items.game as game,
    transaction_items.quantity,
    transaction_items.subtotal
')


        ->join('transaction_items', 'transaction_items.transaction_id = transactions.id')
        ->where('transactions.user_id', $userId)
        // ⬇️ Tambahkan pengurutan supaya yang bank-nya isi muncul lebih dulu
        ->orderBy('transactions.id', 'DESC')
        ->orderBy('transactions.bank IS NULL', 'ASC', false) // ini penting
        ->get()
        ->getResultArray();
}


}
