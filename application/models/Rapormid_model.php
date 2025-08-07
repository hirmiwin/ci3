<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapormid_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function ambilnilai($siswa_id)
    {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        return $this->db->get('nilaimid')->result_array();
    }

    public function ratakelas($kelas_id, $pelajaran_id)
    {
        $this->db->select_avg('nilai_pt');
        $this->db->select_avg('nilai_mt');
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('pelajaran_id', $pelajaran_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        $query = $this->db->get('nilaimid');
        return $query->row_array();
    }

    public function ambilDeskripsi($siswa_id)
    {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        return $this->db->get('nilaideskripsimid')->row_array();
    }

    public function getWaliKelas($kelas_id)
    {
        $this->db->where('id', $kelas_id);
        $this->db->select('wali_kelas');
        $query = $this->db->get('kelas');
        $kelas = $query->row_array();

        if ($kelas && $kelas['wali_kelas']) {
            $user_id = $kelas['wali_kelas'];

            $this->db->where('id', $user_id);
            $this->db->select('nama');
            $user_query = $this->db->get('users');
            return $user_query->row_array();
        }

        return null; // Or handle the case where wali_kelas is empty or not found
    }
}
