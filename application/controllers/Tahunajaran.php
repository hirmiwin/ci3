<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahunajaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tahunajaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['tahunajaran'] = $this->Tahunajaran_model->get_all_tahunajaran();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('tahunajaran_view', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_tahun', 'Nama Tahun', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('tahunajaran_form');
            $this->load->view('template/footer');
        } else {
            $status = $this->input->post('status');
            if ($status !== 'aktif') {
                $status = 'nonaktif';
            }
            $data = [
                'nama_tahun' => $this->input->post('nama_tahun'),
                'status' => $status
            ];
            $this->Tahunajaran_model->insert($data);
            redirect('tahunajaran');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_tahun', 'Nama Tahun', 'required');
        $data['tahunajaran'] = $this->Tahunajaran_model->get_by_id($id);
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('tahunajaran_form', $data);
            $this->load->view('template/footer');
        } else {
            $update = [
                'nama_tahun' => $this->input->post('nama_tahun'),
                'status' => $this->input->post('status')
            ];
            if ($update['status'] == 'aktif') {
                // Nonaktifkan semua tahun ajaran lain
                $this->db->update('tahun_ajaran', ['status' => 'nonaktif']);
            }
            $this->Tahunajaran_model->update($id, $update);
            redirect('tahunajaran');
        }
    }

    public function delete($id)
    {
        $this->Tahunajaran_model->delete($id);
        redirect('tahunajaran');
    }
}
