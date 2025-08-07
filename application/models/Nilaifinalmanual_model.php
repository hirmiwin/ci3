<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilaifinalmanual_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kelas()
    {
        if ($this->session->userdata('role') === 'admin') {
            return $this->db->get('kelas')->result_array();
        }

        return $this->db->select('k.*')
            ->from('pembelajaran pb')
            ->join('kelas k', 'k.id = pb.kelas_id')
            ->where('pb.user_id', $this->session->userdata('id'))
            ->group_by('k.id')
            ->get()
            ->result_array();
    }

    public function get_pelajaran()
    {
        if ($this->session->userdata('role') === 'admin') {
            return $this->db->get('pelajaran')->result_array();
        }

        return $this->db->select('p.*')
            ->from('pembelajaran pb')
            ->join('pelajaran p', 'p.id = pb.pelajaran_id')
            ->where('pb.user_id', $this->session->userdata('id'))
            ->group_by('p.id')
            ->get()
            ->result_array();
    }

    public function get_siswa_by_kelas($kelas_id)
    {
        return $this->db->where('kelas_id', $kelas_id)
            ->order_by('nama', 'asc')
            ->get('siswa')
            ->result_array();
    }

    public function get_nilai_by_kelas($kelas_id, $pelajaran_id)
    {
        $this->db->select('s.id as siswa_id, s.nama as nama_siswa, nf.*')
            ->from('siswa s')
            ->join('nilaifinal nf', 's.id = nf.siswa_id', 'left')
            ->where('s.kelas_id', $kelas_id);
        return $this->db->get()->result_array();
    }

    public function get_nilai_by_filters($kelas_id, $pelajaran_id, $jenisnilai)
    {
        return $this->db->select('s.id as siswa_id, s.nama, GROUP_CONCAT(nf.nilai) as nilai_list')
            ->from('siswa s')
            ->join('nilaifinal nf', 's.id = nf.siswa_id AND nf.jenisnilai = "' . $jenisnilai . '" AND nf.pelajaran_id = ' . $pelajaran_id, 'left')
            ->where('s.kelas_id', $kelas_id)
            ->group_by('s.id, s.nama')
            ->get()
            ->result_array();
    }

    public function save_nilai()
    {
        $nilai_data = [];
        $siswa_ids = $this->input->post('siswa_id');
        $jenisnilai = $this->input->post('jenisnilai');
        $pelajaran_id = $this->input->post('pelajaran_id');
        $nilai_arrays = $this->input->post('nilai');

        // Validate if we have all required data
        if (!$siswa_ids || !$jenisnilai || !$nilai_arrays || !$pelajaran_id) {
            return false;
        }

        // First, delete existing values for these students and jenis nilai
        $this->db->where('jenisnilai', $jenisnilai)
            ->where('pelajaran_id', $pelajaran_id)
            ->where_in('siswa_id', $siswa_ids)
            ->delete('nilaifinal');

        // Then insert new values
        foreach ($siswa_ids as $index => $siswa_id) {
            $nilai_siswa = isset($nilai_arrays[$siswa_id]) ? $nilai_arrays[$siswa_id] : [];

            foreach ($nilai_siswa as $nilai) {
                $nilai_data[] = [
                    'siswa_id' => $siswa_id,
                    'jenisnilai' => $jenisnilai,
                    'pelajaran_id' => $pelajaran_id,
                    'nilai' => $nilai
                ];
            }
        }

        // Insert all new values
        if (!empty($nilai_data)) {
            return $this->db->insert_batch('nilaifinal', $nilai_data);
        }

        return false;
    }

    public function get_nilai_manual_by_kelas($kelas_id)
    {
        $result = $this->db->select('siswa_id, nilai')
            ->from('nilaifinalmanual')
            ->join('siswa', 'siswa.id = nilaifinalmanual.siswa_id')
            ->where('siswa.kelas_id', $kelas_id)
            ->get()
            ->result_array();
        $nilai = [];
        foreach ($result as $row) {
            $nilai[$row['siswa_id']] = $row;
        }
        return $nilai;
    }

    public function save_nilai_manual($kelas_id, $nilai_manual)
    {
        if (!$kelas_id || !is_array($nilai_manual)) {
            return false;
        }

        // Ambil semua siswa_id di kelas ini
        $siswa_list = $this->get_siswa_by_kelas($kelas_id);
        $siswa_ids = array_column($siswa_list, 'id');

        // Hapus data lama
        if (!empty($siswa_ids)) {
            $this->db->where_in('siswa_id', $siswa_ids)->delete('nilaifinalmanual');
        }

        // Insert data baru
        $insert_data = [];
        foreach ($nilai_manual as $siswa_id => $nilai) {
            if ($nilai !== '' && $nilai !== null) {
                $insert_data[] = [
                    'siswa_id' => $siswa_id,
                    'nilai' => $nilai
                ];
            }
        }
        if (!empty($insert_data)) {
            $this->db->insert_batch('nilaifinalmanual', $insert_data);
        }
        return true;
    }
}
