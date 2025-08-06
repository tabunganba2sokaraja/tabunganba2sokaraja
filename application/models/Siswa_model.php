<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

     public function get_all_siswa() {
        return $this->db->get('siswa')->result();
    }

    public function get_all_siswa_with_riwayat() {
        $this->db->select('siswa.*, 
                     riwayat_tabungan.saldo_akhir as saldo,
                     riwayat_tabungan.status_riwayat as status_tabungan,
                     (CASE WHEN riwayat_tabungan.id_riwayat IS NOT NULL THEN 1 ELSE 0 END) as has_account');
       $this->db->from('siswa');
       $this->db->join('riwayat_tabungan', 'siswa.id = riwayat_tabungan.id_siswa', 'left');
       return $this->db->get()->result();
    }

    public function get_siswa_with_tabungan() {
    $this->db->select('siswa.*, riwayat_tabungan.saldo_akhir, riwayat_tabungan.status_riwayat');
    $this->db->from('siswa');
    $this->db->join('riwayat_tabungan', 'siswa.id = riwayat_tabungan.id_siswa', 'left');
    return $this->db->get()->result();
}

    public function insert_siswa($data) {
        $this->db->insert('siswa', $data);
        return $this->db->insert_id();
    }

     public function get_siswa_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('siswa')->row();
    }

      public function update_siswa($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('siswa', $data);
    }

    public function update_status_riwayat($id_siswa, $status_siswa) {
    // Mapping enum status siswa ke status riwayat
    $status_map = [
        'aktif' => 'aktif',
        'lulus' => 'diblokir',
        'pindah' => 'ditutup'
    ];

    // Pastikan status siswa valid
    if (!array_key_exists($status_siswa, $status_map)) {
        return false;
    }

    $status_riwayat = $status_map[$status_siswa];

    // Update tabel riwayat jika ada
    $this->db->where('id_siswa', $id_siswa);
    return $this->db->update('riwayat_tabungan', ['status_riwayat' => $status_riwayat]);
}


    public function delete_siswa($id) {
        $this->db->where('id', $id);
        return $this->db->delete('siswa');
    }

    // Insert batch (untuk import)
    public function insert_batch($data) {
        return $this->db->insert_batch('siswa', $data);
    }

    // Get all siswa
    public function get_siswa() {
        return $this->db->get('siswa')->result_array();
    }

}