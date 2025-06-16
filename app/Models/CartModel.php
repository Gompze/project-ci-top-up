<?php namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table         = 'carts';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id',
        'game',
        'zone_id',
        'diamond_amount',
        'diamond_price',
        'payment_method',
        'email',
        'quantity',
    ];

    
    public function getCartByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
