<?php

namespace App\Models;

use CodeIgniter\Model;



namespace App\Models;
use CodeIgniter\Model;

class PasienModel extends Model {
    protected $table      = 'pasien';
    protected $primaryKey = 'id';
    protected $allowedFields = ['no_rm', 'nama', 'jenis', 'dokter'];
    protected $useTimestamps = false; 

    
    public function getAllPasien() {
        return $this->pasien;
    }

    public function simpanPasien($data) {
        $data['id'] = count($this->pasien) + 1;
        $this->pasien[] = $data;
        return true;
    }

    public function hapusPasien($id) {
        foreach($this->pasien as $key => $p) {
            if($p['id'] == $id) {
                unset($this->pasien[$key]);
                return true;
            }
        }
        return false;
    }
}
