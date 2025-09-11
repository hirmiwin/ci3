<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Semester extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semester_model');
        $this->load->model('Tahunajaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['semester'] = $this->Semester_model->get_all();
        $data['tahunajaran'] = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->result();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('semester_view', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_semester', 'Nama Semester', 'required');
        $this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['tahunajaran'] = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->result();
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('semester_form', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama_semester' => $this->input->post('nama_semester'),
                'tahun_ajaran_id' => $this->input->post('tahun_ajaran_id'),
                'status' => $this->input->post('status')
            ];
            $this->Semester_model->insert($data);
            redirect('semester');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_semester', 'Nama Semester', 'required');
        $this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'required');
        $data['semester'] = $this->Semester_model->get_by_id($id);
        $data['tahunajaran'] = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->result();
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('semester_form', $data);
            $this->load->view('template/footer');
        } else {
            $update = [
                'nama_semester' => $this->input->post('nama_semester'),
                'tahun_ajaran_id' => $this->input->post('tahun_ajaran_id'),
                'status' => $this->input->post('status')
            ];
            $this->Semester_model->update($id, $update);
            redirect('semester');
        }
    }

    public function delete($id)
    {
        $this->Semester_model->delete($id);
        redirect('semester');
    }
}
