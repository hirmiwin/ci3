<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelajaran_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function get_tahun_ajaran_aktif_id()
    {
        $query = $this->db->get_where('tahun_ajaran', ['status' => 'aktif']);
        $row = $query->row();
        return $row ? $row->id : null;
    }

    public function get_all()
    {
        $tahun_ajaran_id = $this->get_tahun_ajaran_aktif_id();
        $this->db->select('a.*, b.nama_pelajaran as nama_pelajaran, c.nama_kelas as nama_kelas, d.nama as nama_user, e.nama_unit as nama_unit');
        $this->db->from('pembelajaran a');
        $this->db->join('pelajaran b', 'b.id = a.pelajaran_id', 'inner');
        $this->db->join('kelas c', 'c.id = a.kelas_id', 'inner');
        $this->db->join('users d', 'd.id = a.user_id', 'inner');
        $this->db->join('units e', 'e.id = a.unit_id', 'inner');
        $this->db->where('a.tahun_ajaran_id', $tahun_ajaran_id);
        return $this->db->get()->result_array();
    }

    public function insert($data)
    {
        $data['tahun_ajaran_id'] = $this->get_tahun_ajaran_aktif_id();
        // Menyimpan data kelas ke database
        return $this->db->insert('pembelajaran', $data);
    }

    public function get_by_id($id)
    {
        $this->db->select('a.*, b.nama_pelajaran as nama_pelajaran, c.nama_kelas as nama_kelas, d.nama as nama_user, e.nama_unit as nama_unit');
        $this->db->from('pembelajaran a');
        $this->db->join('pelajaran b', 'b.id = a.pelajaran_id', 'inner');
        $this->db->join('kelas c', 'c.id = a.kelas_id', 'inner');
        $this->db->join('users d', 'd.id = a.user_id', 'inner');
        $this->db->join('units e', 'e.id = a.unit_id', 'inner');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    public function update($id, $data)
    {
        $data['tahun_ajaran_id'] = $this->get_tahun_ajaran_aktif_id();
        // Mengupdate data kelas di database
        $this->db->where('id', $id);
        return $this->db->update('pembelajaran', $data);
    }

    public function delete($id)
    {
        // Menghapus data kelas berdasarkan id
        $this->db->where('id', $id);
        return $this->db->delete('pembelajaran');
    }

    public function get_by_id_mengajar()
    {
        $this->db->select('kelas_id, pelajaran_id');
        $this->db->from('pembelajaran');
        $this->db->where('user_id', $this->session->userdata('id'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_pelajaran_by_kelas($kelas_id)
    {
        $this->db->select('b.id, b.nama_pelajaran');
        $this->db->from('pembelajaran a');
        $this->db->join('pelajaran b', 'b.id = a.pelajaran_id', 'inner');
        $this->db->where('a.kelas_id', $kelas_id);
        $this->db->where('a.user_id', $this->session->userdata('id'));
        $this->db->group_by('b.id');
        return $this->db->get()->result();
    }

    public function get_pembelajaran_by_user($user_id)
    {
        $this->db->select('pembelajaran.*, kelas.nama_kelas, pelajaran.nama_pelajaran');
        $this->db->from('pembelajaran');
        $this->db->join('kelas', 'kelas.id = pembelajaran.kelas_id', 'inner');
        $this->db->join('pelajaran', 'pelajaran.id = pembelajaran.pelajaran_id', 'inner');
        $this->db->where('pembelajaran.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pembelajaran_by_user_id($user_id)
    {
        $this->db->select('kelas.id as kelas_id, kelas.nama_kelas, pelajaran.nama_pelajaran');
        $this->db->from('pembelajaran');
        $this->db->join('kelas', 'pembelajaran.kelas_id = kelas.id');
        $this->db->join('pelajaran', 'pembelajaran.pelajaran_id = pelajaran.id');
        $this->db->where('pembelajaran.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_pembelajaran()
    {
        $this->db->select('kelas.id as kelas_id, kelas.nama_kelas, pelajaran.nama_pelajaran');
        $this->db->from('pembelajaran');
        $this->db->join('kelas', 'pembelajaran.kelas_id = kelas.id');
        $this->db->join('pelajaran', 'pembelajaran.pelajaran_id = pelajaran.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_kelas_by_guru($guru_id)
    {
        $this->db->select('kelas.id, kelas.nama_kelas');
        $this->db->from('pembelajaran');
        $this->db->join('kelas', 'pembelajaran.kelas_id = kelas.id');
        $this->db->where('pembelajaran.user_id', $guru_id);
        $this->db->group_by('kelas.id');
        $query = $this->db->get();
        log_message('debug', 'get_kelas_by_guru query: ' . $this->db->last_query());
        return $query->result_array();
    }

    public function get_pelajaran_by_guru($guru_id)
    {
        $this->db->select('pelajaran.id, pelajaran.nama_pelajaran');
        $this->db->from('pembelajaran');
        $this->db->join('pelajaran', 'pembelajaran.pelajaran_id = pelajaran.id');
        $this->db->where('pembelajaran.user_id', $guru_id);
        $this->db->group_by('pelajaran.id');
        $query = $this->db->get();
        log_message('debug', 'get_pelajaran_by_guru query: ' . $this->db->last_query());
        return $query->result_array();
    }

    public function get_kelas_by_ids($kelas_ids)
    {
        if (empty($kelas_ids)) {
            return array();
        }
        $this->db->select('id, nama_kelas');
        $this->db->from('kelas');
        $this->db->where_in('id', $kelas_ids);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_pelajaran_by_ids($pelajaran_ids)
    {
        if (empty($pelajaran_ids)) {
            return array();
        }
        $this->db->select('id, nama_pelajaran');
        $this->db->from('pelajaran');
        $this->db->where_in('id', $pelajaran_ids);
        $query = $this->db->get();
        return $query->result_array();
    }
}
