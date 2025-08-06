<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
         is_logged_in();
        $this->load->model('Siswa_model');
        $this->load->model('Transaksi_model');
    }

    public function index() {
        $data['title'] = 'Laporan';
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/index', $data); // Buat folder 'laporan' di views/admin/
        $this->load->view('templates/footer');
    }

    public function siswa() {
        $data['title'] = 'Laporan Data Siswa';
        $data['siswa'] = $this->Siswa_model->get_all_siswa_with_riwayat();
         $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/laporan_siswa', $data);
        $this->load->view('templates/footer');
    }

    public function transaksi() {
        $data['title'] = 'Laporan Riwayat Transaksi';
        // Filter berdasarkan tanggal jika diinginkan (misalnya, via form GET/POST)
        $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : date('Y-m-01');
        $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : date('Y-m-d');

        $data['start_date'] = $start_date;
         $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();
        $data['end_date'] = $end_date;
        $data['transaksi'] = $this->Transaksi_model->get_all_transaksi_by_date($start_date, $end_date); // Tambahkan method ini di model

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/laporan_transaksi', $data);
        $this->load->view('templates/footer');
    }

}