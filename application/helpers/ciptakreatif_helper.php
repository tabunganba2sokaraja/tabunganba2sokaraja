<?php

function is_logged_in() {

    $ci =& get_instance();
    
    // Jika belum login
    if(!$ci->session->userdata('email')) {
        redirect('auth');
    }
    
    // Khusus admin, bypass pengecekan menu
    if($ci->session->userdata('role_id') == 1) {
        return true; // Langsung izinkan akses
    }
    
    // Untuk user biasa, lakukan pengecekan menu
    $menu = $ci->uri->segment(1);
    $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
    
    if(!$queryMenu) {
        return true; // Izinkan jika bukan menu terdaftar
    }
    
    $userAccess = $ci->db->get_where('user_access_menu', [
        'role_id' => $ci->session->userdata('role_id'),
        'menu_id' => $queryMenu['id']
    ]);

    if($userAccess->num_rows() < 1) {
        redirect('auth/blocked');
    }
}
