<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilaifinal_model extends CI_Model
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
}
