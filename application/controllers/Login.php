<?php
class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memuat model User_model
        $this->load->model('User_model');
        $this->load->model('Tahunajaran_model');
    }

    // Halaman login
    public function index()
    {
        // Jika sudah login, redirect ke halaman dashboard (misalnya)
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['tahun_ajaran'] = $this->Tahunajaran_model->get_all_tahunajaran();
        $this->load->view('login_view', $data);
    }

    // Proses login
    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $semester = $this->input->post('semester');

        $user = $this->User_model->login($username, $password);

        if ($user) {
            // Ambil tahun ajaran id berdasarkan tahun ajaran string
            $tahun_ajaran_record = $this->Tahunajaran_model->get_by_year($tahun_ajaran);
            $tahun_ajaran_id = $tahun_ajaran_record ? $tahun_ajaran_record->id : null;

            // Set session data jika login berhasil
            $session_data = array(
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'role' => $user->role,
                'logged_in' => true,
                'tahun_ajaran' => $tahun_ajaran,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'semester' => $semester
            );
            $this->session->set_userdata($session_data);
            redirect('dashboard'); // Redirect ke halaman dashboard
        } else {
            // Jika login gagal
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('login');
        }
    }

    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
