<?php
class Semester_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $this->db->select('semester.*, tahun_ajaran.nama_tahun');
        $this->db->from('semester');
        $this->db->join('tahun_ajaran', 'semester.tahun_ajaran_id = tahun_ajaran.id', 'left');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('semester', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('semester', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('semester', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('semester');
    }
}
