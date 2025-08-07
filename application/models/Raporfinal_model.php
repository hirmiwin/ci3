<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Raporfinal_model extends CI_Model {
    
    public function get_siswa_detail($siswa_id) {
        $this->db->select('siswa.*, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.kelas_id');
        $this->db->where('siswa.id', $siswa_id);
        return $this->db->get()->row_array();
    }

    public function get_nilai_final($siswa_id) {
        $tahun_ajaran = $this->session->userdata('tahun_ajaran');
        $semester = $this->session->userdata('semester');

        // Get mid scores (PT and MT)
        $this->db->select('id, siswa_id, pelajaran_id, CAST(nilai_pt AS DECIMAL(5,2)) as nilai_pt, CAST(nilai_mt AS DECIMAL(5,2)) as nilai_mt');
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_ajaran', $tahun_ajaran);
        $this->db->where('semester', $semester);
        $mid_scores = $this->db->get('nilaimid')->result_array();
        
        // Get final scores (HW, EX, FT)
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_ajaran', $tahun_ajaran);
        $this->db->where('semester', $semester);
        $final_scores = $this->db->get('nilaifinal')->result_array();
        
        return array(
            'mid' => $mid_scores,
            'final' => $final_scores
        );
    }

    public function get_all_pelajaran() {
        return $this->db->get('pelajaran')->result_array();
    }

    public function get_rata_kelas($kelas_id, $pelajaran_id) {
        $this->db->select_avg('nilai_pt');
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('pelajaran_id', $pelajaran_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        return $this->db->get('nilaimid')->row_array();
    }

    public function get_wali_kelas($kelas_id) {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->join('kelas', 'kelas.wali_kelas = users.id');
        $this->db->where('kelas.id', $kelas_id);
        return $this->db->get()->row_array();
    }

    public function get_deskripsi_nilai($siswa_id) {
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('tahun_ajaran', $this->session->userdata('tahun_ajaran'));
        $this->db->where('semester', $this->session->userdata('semester'));
        return $this->db->get('nilaideskripsifinal')->row_array();
    }

    public function get_rata_kelas_detail($kelas_id, $pelajaran_id) {
        $tahun_ajaran = $this->session->userdata('tahun_ajaran');
        $semester = $this->session->userdata('semester');

        // Get class PT and MT averages
        $this->db->select('AVG(CAST(nilai_pt AS DECIMAL(5,2))) as nilai_pt, AVG(CAST(nilai_mt AS DECIMAL(5,2))) as nilai_mt');
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('pelajaran_id', $pelajaran_id);
        $this->db->where('tahun_ajaran', $tahun_ajaran);
        $this->db->where('semester', $semester);
        $mid_avg = $this->db->get('nilaimid')->row_array();

        // Get class HW average
        $this->db->select('AVG(CAST(nilai AS DECIMAL(5,2))) as nilai_hw');
        $this->db->from('nilaifinal nf');
        $this->db->join('siswa s', 's.id = nf.siswa_id');
        $this->db->where('s.kelas_id', $kelas_id);
        $this->db->where('nf.pelajaran_id', $pelajaran_id);
        $this->db->where('nf.jenisnilai', 'hw');
        $this->db->where('nf.tahun_ajaran', $tahun_ajaran);
        $this->db->where('nf.semester', $semester);
        $hw_avg = $this->db->get()->row_array();

        // Get class EX average
        $this->db->select('AVG(CAST(nilai AS DECIMAL(5,2))) as nilai_ex');
        $this->db->from('nilaifinal nf');
        $this->db->join('siswa s', 's.id = nf.siswa_id');
        $this->db->where('s.kelas_id', $kelas_id);
        $this->db->where('nf.pelajaran_id', $pelajaran_id);
        $this->db->where('nf.jenisnilai', 'ex');
        $this->db->where('nf.tahun_ajaran', $tahun_ajaran);
        $this->db->where('nf.semester', $semester);
        $ex_avg = $this->db->get()->row_array();

        // Get class FT average
        $this->db->select('AVG(CASE
               WHEN (nf.nilai * (1 + 0.07)) > 100 THEN 100
               ELSE (nf.nilai * (1 + 0.07))
           END) AS rata_rata_nilai_plus_7_persen');
        $this->db->from('nilaifinal nf');
        $this->db->join('siswa s', 's.id = nf.siswa_id');
        $this->db->where('s.kelas_id', $kelas_id);
        $this->db->where('nf.pelajaran_id', $pelajaran_id);
        $this->db->where('nf.jenisnilai', 'ft');
        $this->db->where('nf.tahun_ajaran', $tahun_ajaran);
        $this->db->where('nf.semester', $semester);
        $ft_avg = $this->db->get()->row_array();

        // Calculate averages
        $avg_pt = floatval($mid_avg['nilai_pt']) ?? 0;
        $avg_mt = floatval($mid_avg['nilai_mt']) ?? 0;
        $avg_hw = floatval($hw_avg['nilai_hw']) ?? 0;
        $avg_ex = floatval($ex_avg['nilai_ex']) ?? 0;
        $avg_ft = floatval($ft_avg['rata_rata_nilai_plus_7_persen']) ?? 0;

        // Apply 7% bonus to FT average and cap at 100
        $avg_ft_with_bonus = min($avg_ft + ($avg_ft * 0.07), 100);

        // Calculate final class average using the weighted formula
        $class_average = ($avg_pt * 0.10) +    // PT: 10%
                        ($avg_mt * 0.15) +      // MT: 15%
                        ($avg_hw * 0.20) +      // HW: 20%
                        ($avg_ex * 0.25) +      // EX: 25%
                        ($avg_ft_with_bonus * 0.30);  // FT: 30% (after +7% bonus)

        return array(
            'nilai_pt' => round($avg_pt, 2),
            'nilai_mt' => round($avg_mt, 2),
            'nilai_hw' => round($avg_hw, 2),
            'nilai_ex' => round($avg_ex, 2),
            'nilai_ft' => round($avg_ft, 2),
            'nilai_ft_with_bonus' => round($avg_ft_with_bonus, 2),
            'class_average' => round($class_average, 2)
        );
    }
}
