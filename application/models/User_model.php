<?php
class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mengecek apakah username dan password valid
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Mengecek password (gunakan password_hash dan password_verify untuk keamanan)
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false; // Jika username atau password salah
    }

    // Fungsi untuk mendapatkan semua pengguna
    public function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    // Fungsi untuk mendapatkan pengguna berdasarkan ID
    public function get_user($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row();
    }

    // Fungsi untuk membuat pengguna baru
    public function create_user()
    {
        $data = array(
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'role' => $this->input->post('role'),
            // Tambahkan field lain sesuai kebutuhan
        );
        return $this->db->insert('users', $data);
    }

    // Fungsi untuk memperbarui pengguna
    public function update_user($id)
    {
        $data = array(
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'role' => $this->input->post('role'),
            // Tambahkan field lain sesuai kebutuhan
        );
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // Fungsi untuk menghapus pengguna
    public function delete_user($id)
    {
        return $this->db->delete('users', array('id' => $id));
    }

    public function get_all()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    // Fungsi untuk mendapatkan semester aktif
    public function get_active_semester()
    {
        $query = $this->db->get_where('semester', array('status' => 'aktif'));
        return $query->row();
    }
}
