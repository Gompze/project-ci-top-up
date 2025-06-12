<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['game','diamond','price'];

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
