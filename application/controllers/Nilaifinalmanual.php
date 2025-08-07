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
        $this->load->model('Raporfinal_model');
    }

    public function index()
    {
        $data['kelas'] = $this->Nilaifinalmanual_model->get_kelas();
        $data['pelajaran'] = $this->Nilaifinalmanual_model->get_pelajaran();
        $data['is_admin'] = ($this->session->userdata('role') === 'admin');

        // Example: get siswa for a selected kelas (e.g., first kelas)
        $kelas_id = $this->input->get('kelas_id');
        if ($kelas_id) {
            $data['siswa_list'] = $this->Nilaifinalmanual_model->get_siswa_by_kelas($kelas_id);
            $data['nilai_manual'] = $this->Nilaifinalmanual_model->get_nilai_manual_by_kelas($kelas_id);
        } else {
            $data['siswa_list'] = [];
            $data['nilai_manual'] = [];
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('nilaifinalmanual_view', $data);
        $this->load->view('template/footer');
    }

    public function input_nilai()
    {
        $kelas_id = $this->input->get('kelas_id');
        $data['kelas'] = $this->Nilaifinalmanual_model->get_kelas();
        $data['pelajaran'] = $this->Nilaifinalmanual_model->get_pelajaran();
        $data['is_admin'] = ($this->session->userdata('role') === 'admin');
        $data['selected_kelas'] = $kelas_id;

        if ($kelas_id) {
            $data['siswa_list'] = $this->Nilaifinalmanual_model->get_siswa_by_kelas($kelas_id);
            $data['nilai_manual'] = $this->Nilaifinalmanual_model->get_nilai_manual_by_kelas($kelas_id);
        } else {
            $data['siswa_list'] = [];
            $data['nilai_manual'] = [];
        }

        // Jika form disubmit
        if ($this->input->method() === 'post') {
            $nilai_manual = $this->input->post('nilai_manual');
            $this->Nilaifinalmanual_model->save_nilai_manual($kelas_id, $nilai_manual);
            $this->session->set_flashdata('success', 'Nilai manual berhasil disimpan.');
            redirect('nilaifinalmanual/input_nilai?kelas_id=' . $kelas_id);
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('nilaifinalmanual_input_view', $data);
        $this->load->view('template/footer');
    }
}
