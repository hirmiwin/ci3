<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        // Check if user is admin or guru
        if (!in_array($this->session->userdata('role'), ['admin', 'guru'])) {
            show_error('You do not have permission to access this page.', 403);
        }
        $this->load->model('siswa_model');
        $this->load->model('kelas_model');
        $this->load->database();
    }

    public function index()
    {
        // Ambil tahun ajaran aktif
        $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
        $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : null;

        // Ambil data siswa sesuai tahun ajaran aktif
        $data['siswa'] = $this->siswa_model->get_siswa_by_tahun_ajaran($tahun_ajaran_id);
        $data['tahun_ajaran_nama'] = $tahun_ajaran ? $tahun_ajaran->nama_tahun : '-';

        // Menampilkan halaman siswa dengan data
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('siswa_view', $data);
        $this->load->view('template/footer');
    }

    public function simpan()
    {
        // Menyimpan data siswa ke database
        $data = array(
            'nama' => $this->input->post('nama'),
            'nis' => $this->input->post('nis'),
            'nisn' => $this->input->post('nisn'),
            'kelas_id' => $this->input->post('kelas')
        );
        $this->siswa_model->insert($data);
        redirect('siswa');
    }

    public function update()
    {
        // Mengupdate data siswa di database
        $id = $this->input->post('id');
        $data = array(
            'nama' => $this->input->post('nama'),
            'nis' => $this->input->post('nis'),
            'nisn' => $this->input->post('nisn'),
            'kelas_id' => $this->input->post('kelas')
        );
        $this->siswa_model->update($id, $data);
        redirect('siswa');
    }

    public function hapus($id)
    {
        // Menghapus data siswa berdasarkan id
        $this->siswa_model->delete($id);
        redirect('siswa');
    }

    public function tambah()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nis', 'NIS', 'required');
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');

        // Ambil tahun ajaran aktif
        $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
        $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : null;

        // Ambil kelas dari tahun ajaran aktif (via rombongan_kelas)
        $this->db->select('k.id, k.nama_kelas');
        $this->db->from('rombongan_kelas rk');
        $this->db->join('kelas k', 'rk.kelas_id = k.id', 'left');
        $this->db->where('rk.tahun_ajaran_id', $tahun_ajaran_id);
        $kelas = $this->db->get()->result();

        $data['kelas_list'] = $kelas;

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('siswa_form', $data);
            $this->load->view('template/footer');
        } else {
            // Simpan data siswa
            $siswa_data = [
                'nama' => $this->input->post('nama'),
                'nis' => $this->input->post('nis'),
                'nisn' => $this->input->post('nisn')
            ];
            $this->Siswa_model->insert_siswa($siswa_data);

            // Ambil id siswa yang baru saja ditambahkan
            $siswa_id = $this->db->insert_id();

            // Simpan ke siswa_kelas (relasi ke kelas dan tahun ajaran)
            $this->Siswa_model->insert_siswa_kelas([
                'siswa_id' => $siswa_id,
                'kelas_id' => $this->input->post('kelas_id'),
                'tahun_ajaran_id' => $tahun_ajaran_id
            ]);

            redirect('siswa');
        }
    }
}
