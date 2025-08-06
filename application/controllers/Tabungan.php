<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tabungan extends CI_Controller
{
      public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->model('Siswa_model');
        $this->load->model('Riwayat_model');
        $this->load->model('Transaksi_model');
    }

    public function index(){
        $data['title'] = 'Manajemen Tabungan';
        $data['siswa'] = $this->Siswa_model->get_all_siswa_with_riwayat();
        $data['siswa'] = $this->db->select('
            siswa.id,
            siswa.nis,
            siswa.nama_lengkap,
            riwayat_tabungan.id_riwayat,
            riwayat_tabungan.saldo_akhir,
            riwayat_tabungan.status_riwayat
        ')
        ->from('siswa')
        ->join('riwayat_tabungan', 'siswa.id = riwayat_tabungan.id_siswa', 'left')
        ->get()
        ->result();
        
        $data['transaksi'] = $this->Transaksi_model->get_all_transaksi_with_details();
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tabungan/index', $data);
        $this->load->view('templates/footer');
        
        
    }

    public function setor($id_riwayat = NULL) {
        $data['title'] = 'Setor Tabungan';
        $data['riwayat'] = $this->Riwayat_model->get_riwayat_by_id($id_riwayat);
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();

        if (!$data['riwayat']) {
            $this->session->set_flashdata('error', 'Riwayat tidak ditemukan.');
            redirect('tabunga');
        }

        $data['siswa'] = $this->Siswa_model->get_siswa_by_id($data['riwayat']->id_siswa);

        $this->form_validation->set_rules('jumlah_setor', 'Jumlah Setor', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('tabungan/setor', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_setor = $this->input->post('jumlah_setor');
            $keterangan   = $this->input->post('keterangan');
            $saldo_sebelum = $data['riwayat']->saldo_akhir;
            $saldo_sesudah = $saldo_sebelum + $jumlah_setor;

            $data_transaksi = array(
                'id_riwayat'     => $id_riwayat,
                'id_siswa'        => $data['riwayat']->id_siswa,
                'jenis_transaksi' => 'setor',
                'jumlah'          => $jumlah_setor,
                'saldo_sebelum'   => $saldo_sebelum,
                'saldo_sesudah'   => $saldo_sesudah,
                'tanggal_transaksi' => date('Y-m-d H:i:s'),
                'keterangan'      => $keterangan,
                'dicatat_oleh'    => $this->session->userdata('id')
            );

            // Transaksi database
            $this->db->trans_begin();
            $this->Transaksi_model->insert_transaksi($data_transaksi);
            $this->Riwayat_model->update_saldo($id_riwayat, $saldo_sesudah);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal melakukan transaksi setor.');
                redirect('tabungan/setor/' . $id_riwayat);
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Setor tabungan berhasil!');
                redirect('tabungan');
            }
        }
    }

    public function tarik($id_riwayat = NULL) {
        $data['title'] = 'Tarik Tabungan';
        $data['riwayat'] = $this->Riwayat_model->get_riwayat_by_id($id_riwayat);
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();

        if (!$data['riwayat']) {
            $this->session->set_flashdata('error', 'riwayat tidak ditemukan.');
            redirect('tabungan');
        }

        $data['siswa'] = $this->Siswa_model->get_siswa_by_id($data['riwayat']->id_siswa);

        $this->form_validation->set_rules('jumlah_tarik', 'Jumlah Tarik', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('tabungan/tarik', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_tarik = $this->input->post('jumlah_tarik');
            $keterangan   = $this->input->post('keterangan');
            $saldo_sebelum = $data['riwayat']->saldo_akhir;

            if ($jumlah_tarik > $saldo_sebelum) {
                $this->session->set_flashdata('error', 'Saldo tidak cukup untuk penarikan ini.');
                redirect('tabungan/tarik/' . $id_riwayat);
            }

            $saldo_sesudah = $saldo_sebelum - $jumlah_tarik;

            $data_transaksi = array(
                'id_riwayat'     => $id_riwayat,
                'id_siswa'        => $data['riwayat']->id_siswa,
                'jenis_transaksi' => 'tarik',
                'jumlah'          => $jumlah_tarik,
                'saldo_sebelum'   => $saldo_sebelum,
                'saldo_sesudah'   => $saldo_sesudah,
                'tanggal_transaksi' => date('Y-m-d H:i:s'),
                'keterangan'      => $keterangan,
                'dicatat_oleh'    => $this->session->userdata('user_id')
            );

            // Transaksi database
            $this->db->trans_begin();
            $this->Transaksi_model->insert_transaksi($data_transaksi);
            $this->Riwayat_model->update_saldo($id_riwayat, $saldo_sesudah);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal melakukan transaksi tarik.');
                redirect('tabungan/tarik/' . $id_riwayat);
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Tarik tabungan berhasil!');
                redirect('tabungan');
            }
        }
    }

     public function riwayat_transaksi($id_riwayat = NULL) {
        if ($id_riwayat === NULL) {
            redirect('tabungan');
        }

        $data['riwayat'] = $this->Riwayat_model->get_riwayat_by_id($id_riwayat);
        if (!$data['riwayat']) {
            $this->session->set_flashdata('error', 'riwayat tidak ditemukan.');
            redirect('admin');
        }

        $data['siswa'] = $this->Siswa_model->get_siswa_by_id($data['riwayat']->id_siswa);
        $data['title'] = 'Riwayat Transaksi ' . htmlspecialchars($data['siswa']->nama_lengkap, ENT_QUOTES, 'UTF-8');
        $data['transaksi_list'] = $this->Transaksi_model->get_transaksi_by_riwayat($id_riwayat);
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tabungan/riwayat', $data);
        $this->load->view('templates/footer');
    }



}