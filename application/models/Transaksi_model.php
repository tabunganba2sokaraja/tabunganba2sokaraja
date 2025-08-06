<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    public function insert_transaksi($data) {
        return $this->db->insert('transaksi_tabungan', $data);
    }

    public function get_transaksi_by_riwayat($id_riwayat) {
        $this->db->where('id_riwayat', $id_riwayat);
        $this->db->order_by('tanggal_transaksi', 'DESC');
        return $this->db->get('transaksi_tabungan')->result();
    }

    public function get_all_transaksi_with_details() {
        $this->db->select('transaksi_tabungan.*, siswa.nama_lengkap as nama_siswa, siswa.nis, riwayat_tabungan.tanggal_pembuatan, users.nama as nama_admin');
        $this->db->from('transaksi_tabungan');
        $this->db->join('siswa', 'transaksi_tabungan.id_siswa = siswa.id', 'left');
        $this->db->join('riwayat_tabungan', 'transaksi_tabungan.id_riwayat = riwayat_tabungan.id_riwayat', 'left');
        $this->db->join('users', 'transaksi_tabungan.dicatat_oleh = users.id', 'left');
        $this->db->order_by('transaksi_tabungan.tanggal_transaksi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_transaksi_by_date($start_date, $end_date) {
    $this->db->select('transaksi_tabungan.*, siswa.nama_lengkap as nama_siswa, siswa.nis, riwayat_tabungan.tanggal_pembuatan, users.nama as nama_admin');
    $this->db->from('transaksi_tabungan');
    $this->db->join('siswa', 'transaksi_tabungan.id_siswa = siswa.id', 'left');
    $this->db->join('riwayat_tabungan', 'transaksi_tabungan.id_riwayat = riwayat_tabungan.id_riwayat', 'left');
    $this->db->join('users', 'transaksi_tabungan.dicatat_oleh = users.id', 'left');
    $this->db->where('DATE(transaksi_tabungan.tanggal_transaksi) >=', $start_date);
    $this->db->where('DATE(transaksi_tabungan.tanggal_transaksi) <=', $end_date);
    $this->db->order_by('transaksi_tabungan.tanggal_transaksi', 'ASC');
    return $this->db->get()->result();
}
}