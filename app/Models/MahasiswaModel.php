<?php

namespace App\models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey       = 'nim';      // pakai nim sebagai PK
    protected $useAutoIncrement = false;      // karena nim bukan auto‐increment
    protected $allowedFields = ['nim', 'nama'];

    public function getAllMahasiswa()
    {
        $daftarMhs = $this->findAll();
        return $daftarMhs;
    }
    public function simpanMahasiswa($data)
{
    $this->save($data);

}
public function updateMahasiswa($nim, $data)
{
    $this->update($nim, $data);
}
public function deleteMahasiswa($nim)
{
    $this->delete($nim);

}
}