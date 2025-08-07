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
}
?>
