<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    // Nama tabel dan primary key
    protected $table      = 'transactions';
    protected $primaryKey = 'id';

    // Aktifkan timestamp otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Kolom mana saja yang boleh di‐insert/update
    protected $allowedFields = [
        'user_id',
        'total_price',
        'status',
        'game',
        'diamond_amount',
        'bank',
        'zone_id',
        'email',
    ];
    public function getByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}