<?php
class Siswa_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $this->db->select('siswa.*, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kelas_id = kelas.id', 'left');
        // $this->db->order_by('siswa.nama', 'ASC');  // Added order by clause
        $query = $this->db->get();
        return $query->result_array();  // Changed from result()
    }

    public function insert($data)
    {
        // Menyimpan data siswa ke database
        return $this->db->insert('siswa', $data);
    }

    public function insert_siswa($data)
    {
        $this->db->insert('siswa', $data);
        return $this->db->insert_id();
    }

    public function insert_siswa_kelas($data)
    {
        return $this->db->insert('siswa_kelas', $data);
    }

    public function get_by_id($id)
    {
        // Mengambil data siswa berdasarkan id
        $query = $this->db->query('SELECT siswa.*, kelas.nama_kelas FROM siswa JOIN kelas ON siswa.kelas_id = kelas.id WHERE siswa.id = ?', array($id));
        return $query->row_array();
    }

    public function update($id, $data)
    {
        // Mengupdate data siswa di database
        $this->db->where('id', $id);
        return $this->db->update('siswa', $data);
    }

    public function delete($id)
    {
        // Menghapus data siswa berdasarkan id
        $this->db->where('id', $id);
        return $this->db->delete('siswa');
    }

    public function count_by_kelas($kelas_id)
    {
        $this->db->where('kelas_id', $kelas_id);
        return $this->db->count_all_results('siswa');
    }

    public function get_siswa_by_kelas($kelas_id)
    {
        $this->db->where('kelas_id', $kelas_id);
        $query = $this->db->get('siswa');
        return $query->result_array();
    }

    public function get_all_siswa()
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $query = $this->db->get();
        return $query->result_array();  // Changed from result()
    }

    public function get_siswa_by_id($siswa_id)
    {
        $this->db->where('id', $siswa_id);
        $query = $this->db->get('siswa');

        if ($query->num_rows() > 0) {
            return $query->row_array();  // Changed from row()
        } else {
            return null;
        }
    }

    public function get_siswa($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('siswa');
        return $query->row_array();
    }

    public function get_siswa_by_tahun_ajaran($tahun_ajaran_id)
    {
        $this->db->select('siswa.*, siswa_kelas.tahun_ajaran_id');
        $this->db->from('siswa');
        $this->db->join('siswa_kelas', 'siswa.id = siswa_kelas.siswa_id', 'left');
        $this->db->where('siswa_kelas.tahun_ajaran_id', $tahun_ajaran_id);
        $this->db->group_by('siswa.id');
        return $this->db->get()->result();
    }
}
