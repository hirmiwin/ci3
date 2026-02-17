<?php
class Tahunajaran_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mendapatkan semua tahun ajaran
    public function get_all_tahunajaran()
    {
        $query = $this->db->get('tahun_ajaran');
        return $query->result();
    }

    // Fungsi untuk mendapatkan tahun ajaran berdasarkan tahun string
    public function get_by_year($year)
    {
        return $this->db->get_where('tahun_ajaran', ['nama_tahun' => $year])->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('tahun_ajaran', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('tahun_ajaran', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tahun_ajaran', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tahun_ajaran');
    }
}
?>
