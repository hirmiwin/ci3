<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends CI_Controller
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
        $this->load->model('kelas_model');
        $this->load->model('user_model');
        $this->load->model('unit_model');
        $this->load->model('Kelas_model'); // Tambahkan ini agar model bisa diakses
        $this->load->database();
    }

    public function index()
    {
        // Ambil data kelas, urutkan berdasarkan nama_kelas
        $this->db->select('k.*, u.nama_unit');
        $this->db->from('kelas k');
        $this->db->join('units u', 'k.unit = u.id', 'left');
        $this->db->order_by('k.nama_kelas', 'ASC');
        $data['kelas'] = $this->db->get()->result();

        // Ambil tahun ajaran aktif
        $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
        $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : null;

        // Ambil data wali kelas sesuai tahun ajaran aktif, urutkan berdasarkan nama_kelas
        $this->db->select('w.kelas_id, u.nama as nama_guru, k.nama_kelas');
        $this->db->from('wali_kelas w');
        $this->db->join('users u', 'w.guru_id = u.id', 'left');
        $this->db->join('kelas k', 'w.kelas_id = k.id', 'left');
        $this->db->where('w.tahun_ajaran_id', $tahun_ajaran_id);
        $this->db->order_by('k.nama_kelas', 'ASC');
        $wali_kelas = $this->db->get()->result();

        // Buat array mapping kelas_id ke nama_guru
        $map_wali = [];
        foreach ($wali_kelas as $wk) {
            $map_wali[$wk->kelas_id] = $wk->nama_guru;
        }
        $data['wali_kelas_map'] = $map_wali;
        $data['tahun_ajaran_nama'] = $tahun_ajaran ? $tahun_ajaran->nama_tahun : '-';

        // Ambil data unit untuk modal tambah
        $data['units'] = $this->db->get('units')->result();

        // Ambil data guru untuk dropdown wali kelas
        $data['gurus'] = $this->db->get_where('users', ['role' => 'guru'])->result();

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kelas_view', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect('kelas'); // Modal tetap di halaman index
        } else {
            $this->Kelas_model->insert_kelas([
                'nama_kelas' => $this->input->post('nama_kelas'),
                'unit' => $this->input->post('unit')
            ]);
            redirect('kelas');
        }
    }

    public function edit($id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');

        $kelas = $this->Kelas_model->get_kelas($id);
        $units = $this->db->get('units')->result();

        if ($this->form_validation->run() === FALSE) {
            // Ambil data kelas untuk tabel
            $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
            $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : null;

            $this->db->select('k.*, u.nama_unit');
            $this->db->from('kelas k');
            $this->db->join('units u', 'k.unit = u.id', 'left');
            $this->db->order_by('k.nama_kelas', 'ASC');
            $kelas_list = $this->db->get()->result();

            $this->db->select('w.kelas_id, u.nama as nama_guru, k.nama_kelas');
            $this->db->from('wali_kelas w');
            $this->db->join('users u', 'w.guru_id = u.id', 'left');
            $this->db->join('kelas k', 'w.kelas_id = k.id', 'left');
            $this->db->where('w.tahun_ajaran_id', $tahun_ajaran_id);
            $this->db->order_by('k.nama_kelas', 'ASC');
            $wali_kelas = $this->db->get()->result();

            $map_wali = [];
            foreach ($wali_kelas as $wk) {
                $map_wali[$wk->kelas_id] = $wk->nama_guru;
            }

            $data = [
                'kelas' => $kelas_list,
                'wali_kelas_map' => $map_wali,
                'tahun_ajaran_nama' => $tahun_ajaran ? $tahun_ajaran->nama_tahun : '-',
                'units' => $units,
                'edit_modal' => true,
                'kelas_edit' => $kelas,
            ];

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('kelas_view', $data);
            $this->load->view('template/footer');
        } else {
            $this->Kelas_model->update_kelas($id, [
                'nama_kelas' => $this->input->post('nama_kelas'),
                'unit' => $this->input->post('unit')
            ]);
            redirect('kelas');
        }
    }

    public function delete($id)
    {
        $this->Kelas_model->delete_kelas($id);
        redirect('kelas');
    }

    public function hapus($id)
    {
        $this->load->model('Kelas_model');
        $this->load->model('Siswa_model');

        // Check if there are students in the class
        $jumlah_siswa = $this->Siswa_model->count_by_kelas($id);
        if ($jumlah_siswa > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus kelas yang memiliki siswa.');
            redirect('kelas');
        }

        // Proceed with deletion
        $this->Kelas_model->delete($id);
        $this->session->set_flashdata('success', 'Kelas berhasil dihapus.');
        redirect('kelas');
    }

    public function tambah_wali($kelas_id)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('guru_id', 'Guru', 'required');

        // Ambil tahun ajaran aktif
        $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
        $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : null;

        // Ambil data guru untuk dropdown
        $gurus = $this->db->get_where('users', ['role' => 'guru'])->result();

        if ($this->form_validation->run() === FALSE) {
            $data['kelas_id'] = $kelas_id;
            $data['gurus'] = $gurus;
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('kelas_wali_form', $data);
            $this->load->view('template/footer');
        } else {
            // Simpan wali kelas baru
            $this->db->insert('wali_kelas', [
                'kelas_id' => $kelas_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'guru_id' => $this->input->post('guru_id')
            ]);
            redirect('kelas');
        }
    }
}