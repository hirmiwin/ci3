<?php
class Kelas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($tahun_ajaran_id = null)
    {
        if ($tahun_ajaran_id === null) {
            // Ambil tahun ajaran aktif jika tidak diberikan
            $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['tahun' => date('Y') . '/' . (date('Y')+1)])->row();
            $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : 1;
        }
        $this->db->select('kelas.*, users.nama as nama_wali_kelas');
        $this->db->from('kelas');
        $this->db->join('wali_kelas', 'wali_kelas.kelas_id = kelas.id AND wali_kelas.tahun_ajaran_id = ' . (int)$tahun_ajaran_id, 'left');
        $this->db->join('users', 'wali_kelas.guru_id = users.id', 'left');
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        // Menyimpan data kelas ke database
        return $this->db->insert('kelas', $data);
    }

    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('kelas');
        return $query->row();
    }

    public function update($id, $data)
    {
        // Mengupdate data kelas di database
        $this->db->where('id', $id);
        return $this->db->update('kelas', $data);
    }

    public function delete($id)
    {
        // Menghapus data kelas berdasarkan id
        $this->db->where('id', $id);
        return $this->db->delete('kelas');
    }

    public function get_kelas_by_wali_kelas($wali_kelas_id, $tahun_ajaran_id = null)
    {
        if ($tahun_ajaran_id === null) {
            $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['tahun' => date('Y') . '/' . (date('Y')+1)])->row();
            $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : 1;
        }
        $this->db->select('kelas.*, users.nama as nama_wali_kelas');
        $this->db->from('kelas');
        $this->db->join('wali_kelas', 'wali_kelas.kelas_id = kelas.id AND wali_kelas.tahun_ajaran_id = ' . (int)$tahun_ajaran_id, 'left');
        $this->db->join('users', 'wali_kelas.guru_id = users.id', 'left');
        $this->db->where('wali_kelas.guru_id', $wali_kelas_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_kelas()
    {
        $this->db->select('k.*, u.nama_unit');
        $this->db->from('kelas k');
        $this->db->join('units u', 'k.unit = u.id', 'left');
        $this->db->order_by('k.nama_kelas', 'ASC');
        return $this->db->get()->result();
    }

    public function get_wali_kelas_by_kelas_id($kelas_id, $tahun_ajaran_id = null)
    {
        if ($tahun_ajaran_id === null) {
            $tahun_ajaran = $this->db->get_where('tahun_ajaran', ['tahun' => date('Y') . '/' . (date('Y')+1)])->row();
            $tahun_ajaran_id = $tahun_ajaran ? $tahun_ajaran->id : 1;
        }
        $this->db->select('users.nama as nama_wali_kelas');
        $this->db->from('wali_kelas');
        $this->db->join('users', 'wali_kelas.guru_id = users.id', 'left');
        $this->db->where('wali_kelas.kelas_id', $kelas_id);
        $this->db->where('wali_kelas.tahun_ajaran_id', $tahun_ajaran_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function get_kelas_by_user($user_id, $role)
    {
        if ($role == 'admin') {
            return $this->db->get('kelas')->result_array();
        } else {
            return $this->db->where('wali_kelas', $user_id)
                           ->get('kelas')
                           ->result_array();
        }
    }

    public function insert_kelas($data)
    {
        return $this->db->insert('kelas', $data);
    }

    public function get_kelas($id)
    {
        return $this->db->get_where('kelas', ['id' => $id])->row();
    }

    public function update_kelas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kelas', $data);
    }

    public function delete_kelas($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('kelas');
    }
}
