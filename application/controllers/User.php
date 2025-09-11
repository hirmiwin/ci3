<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary models, libraries, etc.
        $this->load->model('user_model');
        $this->load->library('session');
        $this->check_access();

        // Set semester aktif ke session jika belum ada
        if (!$this->session->userdata('semester_id')) {
            $semester = $this->user_model->get_active_semester();
            if ($semester) {
                $this->session->set_userdata('semester_id', $semester->id);
                $this->session->set_userdata('semester_nama', $semester->nama_semester);
                // Ambil tahun ajaran dari semester
                $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['id' => $semester->tahun_ajaran_id])->row();
                if ($tahun_ajaran) {
                    $this->session->set_userdata('tahun_ajaran_id', $tahun_ajaran->id);
                    $this->session->set_userdata('tahun_ajaran_nama', $tahun_ajaran->nama_tahun);
                }
            }
        }
    }

    private function check_access()
    {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        // Check if user is admin
        if ($this->session->userdata('role') !== 'admin') {
            show_error('You do not have permission to access this page.', 403);
        }
    }

    public function index()
    {
        // Load a view or perform some action
        $data['users'] = $this->user_model->get_all_users();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('user/user_view', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {

        // Handle form submission and create a new user
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('user/tambah_user_view');
            $this->load->view('template/footer');
        } else {
            $this->user_model->create_user();
            redirect('user');
        }
    }

    public function simpan()
    {
        // Handle form submission and create a new user
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('user/tambah_user_view');
            $this->load->view('template/footer');
        } else {
            $this->user_model->create_user();
            redirect('user');
        }
    }

    public function edit($id)
    {
        // Handle form submission and update an existing user
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['user'] = $this->user_model->get_user($id);

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('user/edit_user_view', $data);
            $this->load->view('template/footer');
        } else {
            $this->user_model->update_user($id);
            redirect('user');
        }
    }

    public function delete($id)
    {
        // Delete a user
        $this->user_model->delete_user($id);
        redirect('user');
    }

    public function wali_kelas_aktif()
    {
        // Ambil tahun ajaran aktif
        $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
        $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : null;

        // Ambil data wali kelas dari rombongan_kelas sesuai tahun ajaran aktif
        $this->db->select('rk.*, k.nama_kelas, u.nama_unit, w.guru_id, us.nama as nama_guru');
        $this->db->from('rombongan_kelas rk');
        $this->db->join('kelas k', 'rk.kelas_id = k.id', 'left');
        $this->db->join('units u', 'k.unit = u.id', 'left');
        $this->db->join('wali_kelas w', 'rk.wali_kelas_id = w.id', 'left');
        $this->db->join('users us', 'w.guru_id = us.id', 'left');
        $this->db->where('rk.tahun_ajaran_id', $tahun_ajaran_id);
        $wali_kelas = $this->db->get()->result();

        $data['wali_kelas'] = $wali_kelas;
        $data['tahun_ajaran_nama'] = $tahun_ajaran ? $tahun_ajaran->nama_tahun : '-';

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('user/wali_kelas_view', $data);
        $this->load->view('template/footer');
    }
}
