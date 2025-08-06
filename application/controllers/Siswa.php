<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

     public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Siswa_model');
        $this->load->model('Riwayat_model'); 
    }

    public function index() {
        $data['title'] = 'Manajemen Siswa';
        $data['siswa'] = $this->Siswa_model->get_all_siswa_with_riwayat();
        $data['siswa'] = $this->Siswa_model->get_siswa_with_tabungan();
    
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa/index', $data);
        $this->load->view('templates/footer');

       
    }

    public function tambah() {
        $data['title'] = 'Tambah Siswa Baru';
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();

        $this->form_validation->set_rules('nis', 'NIS', 'required|trim|is_unique[siswa.nis]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'trim');
        $this->form_validation->set_rules('nama_orang_tua', 'Nama Orang Tua', 'required|trim');
        $this->form_validation->set_rules('kontak_orang_tua', 'Kontak Orang Tua', 'required|trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('siswa/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data_siswa = array(
                'nis'             => $this->input->post('nis'),
                'nama_lengkap'    => $this->input->post('nama_lengkap'),
                'kelas'           => $this->input->post('kelas'),
                'nama_orang_tua'  => $this->input->post('nama_orang_tua'),
                'kontak_orang_tua' => $this->input->post('kontak_orang_tua'),
                'tanggal_daftar'  => date('Y-m-d'),
                'status_siswa'    => 'aktif'
            );

            $insert_id = $this->Siswa_model->insert_siswa($data_siswa);

            if ($insert_id) {
                // Otomatis buat rekening tabungan untuk siswa baru
                $data_riwayat = array(
                    'id_siswa'         => $insert_id,
                    'saldo_akhir'      => 0.00,
                    'tanggal_pembuatan' => date('Y-m-d H:i:s'),
                    'status_riwayat'  => 'aktif'
                );
                $this->Riwayat_model->insert_riwayat($data_riwayat); // Asumsi model Rekening_model ada

                $this->session->set_flashdata('success', 'Siswa baru berhasil ditambahkan dan rekening tabungan dibuat!');
                redirect('siswa');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan siswa.');
                redirect('siswa/tambah');
            }
        }
    }

    public function edit($id = NULL) {
    if ($id === NULL) {
        redirect('siswa');
    }

    $data['title'] = 'Edit Data Siswa';
    $data['user'] = $this->db->get_where('users',['email' => $this->session->userdata('email')])->row_array();
    $data['siswa'] = $this->Siswa_model->get_siswa_by_id($id);

    if (!$data['siswa']) {
        $this->session->set_flashdata('error', 'Data siswa tidak ditemukan.');
        redirect('siswa');
    }

    $this->form_validation->set_rules('nis', 'NIS', 'required|trim');
    $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
    $this->form_validation->set_rules('kelas', 'Kelas', 'trim');
    $this->form_validation->set_rules('nama_orang_tua', 'Nama Orang Tua', 'required|trim');
    $this->form_validation->set_rules('kontak_orang_tua', 'Kontak Orang Tua', 'required|trim|numeric');
    $this->form_validation->set_rules('status_siswa', 'Status Siswa', 'required|trim|in_list[aktif,lulus,pindah]');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa/edit', $data);
        $this->load->view('templates/footer');
    } else {
        $data_update = array(
            'nis' => $this->input->post('nis'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'kelas' => $this->input->post('kelas'),
            'nama_orang_tua' => $this->input->post('nama_orang_tua'),
            'kontak_orang_tua' => $this->input->post('kontak_orang_tua'),
            'status_siswa' => $this->input->post('status_siswa')
        );

        // Update data siswa
        $update_siswa = $this->Siswa_model->update_siswa($id, $data_update);
        
        // Update status riwayat tabungan
        $update_riwayat = $this->Siswa_model->update_status_riwayat($id, $this->input->post('status_siswa'));

        if ($update_siswa && $update_riwayat) {
            $this->session->set_flashdata('success', 'Data siswa & riwayat berhasil diperbarui!');
        } elseif ($update_siswa) {
            $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui! (Riwayat tidak ditemukan)');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data siswa.');
        }
        
        redirect('siswa');
    }
}

    

    public function hapus($id = NULL) {
        if ($id === NULL) {
            redirect('siswa');
        }
        if ($this->Siswa_model->delete_siswa($id)) {
            $this->session->set_flashdata('success', 'Data siswa berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data siswa. Mungkin ada transaksi terkait.');
        }
        redirect('siswa');
    }

    public function import() {
        $data['title'] = 'Import Data Siswa';
        $data['user'] = $this->db->get_where('users',['email'=>
        $this->session->userdata('email')]) -> row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa/import', $data);
        $this->load->view('templates/footer');
    }

   public function proses_import() {
    // Load library upload
    $this->load->library('upload');
    
    // Konfigurasi upload
    $config['upload_path'] = FCPATH.'uploads/temp/';
    $config['allowed_types'] = 'xlsx|xls';
    $config['max_size'] = 2048;
    $config['encrypt_name'] = true;
    
    $this->upload->initialize($config);
    
    if (!$this->upload->do_upload('file_excel')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
        redirect('siswa/import');
    }
    
    $file_data = $this->upload->data();
    $file_path = $file_data['full_path'];
    
    try {
        require_once FCPATH.'vendor/autoload.php';
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        // Lewati header (baris pertama)
        array_shift($rows);
        
        $imported_count = 0;
        
        foreach ($rows as $row) {
            if (empty($row[1])) continue; // Skip jika NIS kosong
            
            // Konversi status siswa
            $status_excel = strtolower(trim($row[6] ?? ''));
            $status_db = 'aktif'; // Default
            
            if (in_array($status_excel, ['lulus', 'pindah'])) {
                $status_db = $status_excel;
            } elseif ($status_excel != 'aktif') {
                $status_db = 'pindah'; // Fallback untuk status tidak valid
            }
            
            // Data siswa
            $data_siswa = [
                'nis' => $row[1],
                'nama_lengkap' => $row[2] ?? '',
                'kelas' => $row[3] ?? '',
                'nama_orang_tua' => $row[4] ?? '',
                'kontak_orang_tua' => preg_replace('/[^0-9]/', '', $row[5] ?? ''),
                'status_siswa' => $status_db,
                'tanggal_daftar' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Cek duplikat NIS
            $exists = $this->db->get_where('siswa', ['nis' => $data_siswa['nis']])->row();
            
            if ($exists) {
                $this->db->where('id', $exists->id);
                $this->db->update('siswa', $data_siswa);
                $siswa_id = $exists->id;
            } else {
                $this->db->insert('siswa', $data_siswa);
                $siswa_id = $this->db->insert_id();
            }
            
            // Buat/mutakhirkan riwayat tabungan
            $this->init_riwayat_tabungan($siswa_id);
            
            $imported_count++;
        }
        
        $this->session->set_flashdata('success', 'Berhasil mengimport '.$imported_count.' data siswa');
        
    } catch (Exception $e) {
        $this->session->set_flashdata('error', 'Error: '.$e->getMessage());
    } finally {
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    redirect('siswa');
}

// Fungsi untuk inisialisasi riwayat tabungan
private function init_riwayat_tabungan($siswa_id) {
    $exists = $this->db->get_where('riwayat_tabungan', ['id_siswa' => $siswa_id])->row();
    
    if ($exists) {
        // Update status jika perlu
        $this->db->where('id_riwayat', $exists->id_riwayat);
        $this->db->update('riwayat_tabungan', [
            'status_riwayat' => 'aktif',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    } else {
        // Buat riwayat baru
        $this->db->insert('riwayat_tabungan', [
            'id_siswa' => $siswa_id,
            'saldo_akhir' => 0.00,
            'tanggal_pembuatan' => date('Y-m-d H:i:s'),
            'status_riwayat' => 'aktif'
        ]);
    }
}

public function export() {
    // Pastikan tidak ada output sebelumnya
    if (ob_get_length()) ob_end_clean();
    
    // Load PhpSpreadsheet
    require_once FCPATH.'vendor/autoload.php';
    
    // Ambil data dari database
    $query = $this->db->get('siswa');
    if ($query->num_rows() == 0) {
        $this->session->set_flashdata('error', 'Tidak ada data siswa untuk di-export');
        redirect('siswa');
    }
    $data = $query->result_array();

    try {
        // Buat spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set judul kolom (header)
        $headers = [
            'No', 
            'NIS', 
            'Nama Lengkap', 
            'Kelas', 
            'Nama Orang Tua', 
            'Kontak Orang Tua', 
            'Status'
        ];
        $sheet->fromArray($headers, NULL, 'A1');
        
        // Isi data
        $row = 2;
        foreach ($data as $item) {
            // Format status
            $status = ($item['status'] == 'active') ? 'Aktif' : 'Nonaktif';
            
            $sheet->fromArray([
                $row-1,                     // No
                $item['nis'],               // NIS
                $item['nama_lengkap'],      // Nama
                $item['kelas'],             // Kelas
                $item['nama_orang_tua'],    // Orang Tua
                $item['kontak_orang_tua'],  // Kontak
                $status                     // Status
            ], NULL, 'A'.$row);
            
            $row++;
        }
        
        // Set header HTTP
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data_siswa_'.date('Ymd_His').'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        // Hapus semua output sebelum menulis Excel
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Tulis file Excel
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
        
    } catch (Exception $e) {
        // Log error
        log_message('error', 'Export Excel Error: '.$e->getMessage());
        $this->session->set_flashdata('error', 'Gagal export data: '.$e->getMessage());
        redirect('siswa');
    }
}
}