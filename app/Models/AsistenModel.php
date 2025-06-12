<?php namespace App\Models;

use CodeIgniter\Model;

class AsistenModel extends Model
{
    protected $table            = 'asisten';
    protected $primaryKey       = 'NIM';         // pakai NIM sebagai PK
    protected $useAutoIncrement = false;         // non-aktifkan auto-inc
    protected $returnType       = 'array';
    protected $allowedFields    = ['NIM','NAMA','PRAKTIKUM','IPK'];
    
    public function simpan(array $record)
    {
        // Pastikan key array sesuai allowedFields (uppercase)
        $this->save([
            'NIM'       => $record['nim'],        // asalnya lowercase di controller
            'NAMA'      => $record['nama'],
            'PRAKTIKUM' => $record['praktikum'],
            'IPK'       => $record['ipk'],
        ]);
    }

    public function updateAsisten($nim, $nama, $praktikum, $ipk)
	{

		$this->update($nim, [
			"NAMA" => $nama,
			"PRAKTIKUM" => $praktikum,
            "IPK" => $ipk
		]);
	}

    public function deleteAsisten($nim)
	{
		$this->delete($nim);
	}
}
