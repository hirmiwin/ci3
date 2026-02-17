<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_nilai()
    {
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        return $this->db->get('nilaimid')->result_array();
    }

    public function get_nilai_by_id($id)
    {
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        $query = $this->db->get_where('nilaimid', array('id' => $id));
        return $query->row_array();
    }

    public function get_nilai_by_kelas($kelas_id)
    {
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        $query = $this->db->get('nilaimid');
        return $query->result_array();
    }

    public function get_nilai_by_kelas_and_pelajaran($kelas_id, $pelajaran_id, $siswa_id = null)
    {
        $this->db->select('nilaimid.id, siswa.id as siswa_id, siswa.nama as nama_siswa, nilaimid.nilai_pt, nilaimid.nilai_mt');
        $this->db->from('siswa');
        $this->db->join('nilaimid', 'siswa.id = nilaimid.siswa_id AND nilaimid.pelajaran_id = ' . (int)$pelajaran_id, 'left');
        $this->db->where('siswa.kelas_id', $kelas_id);
        $this->db->where('nilaimid.tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('nilaimid.semester', $this->session->userdata('semester'));
        $this->db->order_by('siswa.nama', 'ASC');
        if ($siswa_id) {
            $this->db->where('siswa.id', $siswa_id);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function get_nilai_mid_by_siswa($siswa_id)
    {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        return $this->db->get('nilaimid')->result_array();
    }

    public function insert_nilai($data)
    {
        $data['tahun_ajaran'] = $this->session->userdata('tahun_ajaran');
        $data['semester'] = $this->session->userdata('semester');
        return $this->db->insert('nilaimid', $data);
    }

    public function update_nilai($id, $data)
    {
        $this->db->where('id', $id);
        $data['tahun_ajaran'] = $this->session->userdata('tahun_ajaran');
        $data['semester'] = $this->session->userdata('semester');
        return $this->db->update('nilaimid', $data);
    }

    public function delete_nilai($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('nilaimid');
    }
}
