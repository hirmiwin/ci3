<?php
defined('BASEPATH') or exit('No direct script access allowed');

class nilaifinalmanual extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->helper('url');
        $this->load->model('Nilaifinalmanual_model');
        $this->load->model('Raporfinal_model'); // Add this line
    }

    public function index()
    {
        $data['kelas'] = $this->nilaifinalmanual_model->get_kelas();
        $data['pelajaran'] = $this->nilaifinalmanual_model->get_pelajaran();
        $data['is_admin'] = ($this->session->userdata('role') === 'admin');

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('nilaifinalmanual_view', $data);
        $this->load->view('template/footer');
    }
}
