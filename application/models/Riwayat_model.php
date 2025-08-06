<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_model extends CI_Model {

    public function insert_riwayat($data) {
        return $this->db->insert('riwayat_tabungan', $data);
    }

     public function get_all_riwayat() {
        $this->db->select('riwayat_tabungan.*, siswa.nama_lengkap, siswa.nis, COALESCE(riwayat_tabungan.status_riwayat, "aktif") as status_riwayat');
        $this->db->from('riwayat_tabungan');
        $this->db->join('siswa', 'riwayat_tabungan.id_siswa = siswa.id_siswa');
        return $this->db->get()->result();
    }

    public function get_riwayat_by_siswa_id($id_siswa) {
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->get('riwayat_tabungan')->row();
    }

    public function get_riwayat_by_id($id_riwayat) {
        $this->db->where('id_riwayat', $id_riwayat);
        return $this->db->get('riwayat_tabungan')->row();
    }

    public function update_saldo($id_riwayat, $new_saldo) {
        $this->db->where('id_riwayat', $id_riwayat);
        return $this->db->update('riwayat_tabungan', array('saldo_akhir' => $new_saldo));
    }
 }