<?php

namespace App\Models;

use CodeIgniter\Model;

class Bukumodel extends Model
{
    public function ambilBuku()
    {
        $buku = [
            'author' => 'Yuval Noah Harari',
            'title' => 'Sapiens: A Brief History of Humankind'
        ];
        return $buku;
    }
}