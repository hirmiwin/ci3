<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Report</title>
    <!-- <link rel="stylesheet" href="<?php echo base_url() ?>aset/print_rapormid.css"> -->

    <style>
        @font-face {
            font-family: dauphin;
            src: url(<?php echo base_url() ?>aset/dist/dauphin.ttf)
        }

        @font-face {
            font-family: Monotype Corsiva;
            src: url(<?php echo base_url() ?>aset/dist/arial.ttf)
        }


        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .bp {
            font-family: 'dauphin';
            font-weight: bold;
            font-size: 25px;
        }

        .ds {
            font-family: 'Monotype Corsiva';
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-bordered {
            border: 1px solid #000;
        }

        .mt-3 {
            margin-top: 1.5em;
        }

        .mt-5 {
            margin-top: 3em;
        }

        .table-secondary {
            background-color: #e2e3e5;
        }

        .text-center {
            text-align: center;
        }

        body {
            /* background-image: url('<?php echo base_url() ?>aset/dist/img/raporback.png'); */
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: 70%;
            background-blend-mode: lighten;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="<?php echo base_url() ?>aset/dist/img/logo-ais.png" width="100px" alt="Logo Ananda Islamic School">
        <br>
        <span class="bp">SDS Ananda Islamic School</span>
        <br>
        <p style="font-size: 10px; margin-top: 5px;"><strong>FINAL TEST RESULT<br>2024/2025</strong></p>
    </div>
    <table style="width: 100%; margin-bottom: 20px; border: none;">
        <tr>
            <td style="width: 15%; text-align: left; border: none; padding: 2px;"><strong>Student Name</strong></td>
            <td style="width: 1%; text-align: left; border: none; padding: 2px;">: </td>
            <td style="width: 54%; text-align: left; border: none; padding: 2px;"><?php echo isset($siswa['nama']) ? $siswa['nama'] : 'Data Kosong'; ?></td>
            <td style="width: 10%; text-align: left; border: none; padding: 2px;"><strong>Class</strong></td>
            <td style="width: 1%; text-align: left; border: none; padding: 2px;">: </td>
            <td style="width: 19%; text-align: left; border: none; padding: 2px;">Primary <?php echo isset($siswa['nama_kelas']) ? $siswa['nama_kelas'] : 'Data Kosong'; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; border: none; padding: 2px;"><strong>NIS / NISN</strong></td>
            <td style="width: 1%; text-align: left; border: none; padding: 2px;">: </td>
            <td style="width: 54%; text-align: left; border: none; padding: 2px;"><?php echo isset($siswa['nis']) ? $siswa['nis'] : 'Data Kosong'; ?> / <?php echo isset($siswa['nisn']) ? $siswa['nisn'] : 'Data Kosong'; ?></td>
            <td style="width: 10%; text-align: left; border: none; padding: 2px;"><strong>Semester</strong></td>
            <td style="width: 1%; text-align: left; border: none; padding: 2px;">: </td>
            <td style="width: 19%; text-align: left; border: none; padding: 2px;">2</td>
        </tr>
    </table>

    <table class="table table-bordered" style="margin-top: 20px;">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Subject</th>
                <th style="width: 100px;">Score</th>
                <th style="width: 100px;">Class Average</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-secondary">
                <td colspan="4" style="font-weight: bold;">International Studies</td>
            </tr>
            <tr>
                <!-- Math -->
                <td>1</td>
                <td style="text-align: left;"><?php echo isset($pelajaran[0]['nama_pelajaran']) ? $pelajaran[0]['nama_pelajaran'] : 'N/A'; ?></td>
                <td><?php
                    $pt_score = 0;
                    $mt_score = 0;
                    $hw_score = 0;
                    $ex_score = 0;
                    $ft_score = 0;
                    
                    // Get PT and MT scores
                    foreach ($nilai_mid['mid'] as $nilaimid) {
                        if ($nilaimid['pelajaran_id'] == 3) {
                            $pt_score = $nilaimid['nilai_pt'];
                            $mt_score = $nilaimid['nilai_mt'];
                            break;
                        }
                    }
                    
                    // Get HW, EX and FT scores
                    $hw_total = 0;
                    $hw_count = 0;
                    $ex_total = 0;
                    $ex_count = 0;
                    foreach ($nilai_mid['final'] as $nilaifinal) {
                        if ($nilaifinal['pelajaran_id'] == 3) {
                            if ($nilaifinal['jenisnilai'] == 'hw') {
                                $hw_total += $nilaifinal['nilai'];
                                $hw_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ex') {
                                $ex_total += $nilaifinal['nilai'];
                                $ex_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                        }
                    }
                    
                    $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                    $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                    
                    // Calculate FT score with 7% bonus and cap at 100
                    $ft_with_bonus = $ft_score + ($ft_score * 0.07);
                    $ft_with_bonus = min($ft_with_bonus, 100);
                    
                    // Debug output
                    // echo "PT Score: " . number_format($pt_score, 2) . "<br>";
                    // echo "MT Score: " . number_format($mt_score, 2) . "<br>";
                    // echo "HW Score: " . number_format($hw_score, 2) . "<br>";
                    // echo "EX Score: " . number_format($ex_score, 2) . "<br>";
                    // echo "FT Score: " . number_format($ft_score, 2) . "<br>";
                    // echo "FT Score after +7: " . number_format($ft_with_bonus, 2) . "<br>";
                    
                    // Calculate final score using capped FT score
                    $final_score = ($pt_score * 0.10) +    // PT: 10%
                                 ($mt_score * 0.15) +      // MT: 15%
                                 ($hw_score * 0.20) +      // HW: 20%
                                 ($ex_score * 0.25) +      // EX: 25%
                                 ($ft_with_bonus * 0.30);  // FT: +7% then 30%
                    
                    echo number_format($final_score, 2);
                    ?></td>
                <td><?php
                    // Math class average
                    $ratakelas_math = $raporfinal_model->get_rata_kelas_detail($siswa['kelas_id'], 3); 
                    $average = ($ratakelas_math['nilai_pt'] + $ratakelas_math['nilai_mt'] + $ratakelas_math['nilai_hw'] + $ratakelas_math['nilai_ex'] + $ratakelas_math['nilai_ft']) / 5;
                    echo number_format($average, 2);
                ?></td>
            </tr>
            <tr>
                <!-- English -->
                <td>2</td>
                <td style="text-align: left;"><?php echo isset($pelajaran[1]['nama_pelajaran']) ? $pelajaran[1]['nama_pelajaran'] : 'N/A'; ?></td>
                <td><?php
                    $pt_score = $mt_score = $hw_score = $ex_score = $ft_score = 0;
                    
                    // Get PT and MT scores
                    foreach ($nilai_mid['mid'] as $nilaimid) {
                        if ($nilaimid['pelajaran_id'] == 4) {
                            $pt_score = $nilaimid['nilai_pt'];
                            $mt_score = $nilaimid['nilai_mt'];
                            break;
                        }
                    }
                    
                    // Get HW, EX and FT scores
                    $hw_total = $hw_count = $ex_total = $ex_count = 0;
                    foreach ($nilai_mid['final'] as $nilaifinal) {
                        if ($nilaifinal['pelajaran_id'] == 4) {
                            if ($nilaifinal['jenisnilai'] == 'hw') {
                                $hw_total += $nilaifinal['nilai'];
                                $hw_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ex') {
                                $ex_total += $nilaifinal['nilai'];
                                $ex_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                        }
                    }
                    
                    $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                    $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                    $ft_with_bonus = min($ft_score + ($ft_score * 0.07), 100);
                    
                    $final_score = ($pt_score * 0.10) + ($mt_score * 0.15) + 
                                 ($hw_score * 0.20) + ($ex_score * 0.25) + 
                                 ($ft_with_bonus * 0.30);
                    
                    echo number_format($final_score, 2);
                    ?></td>
                <td><?php
                    // English class average
                    $ratakelas_english = $raporfinal_model->get_rata_kelas_detail($siswa['kelas_id'], 4); 
                    $average = ($ratakelas_english['nilai_pt'] + $ratakelas_english['nilai_mt'] + $ratakelas_english['nilai_hw'] + $ratakelas_english['nilai_ex'] + $ratakelas_english['nilai_ft']) / 5;
                    echo number_format($average, 2);
                ?></td>
            </tr>
            <tr>
                <!-- Science -->
                <td>3</td>
                <td style="text-align: left;"><?php echo isset($pelajaran[2]['nama_pelajaran']) ? $pelajaran[2]['nama_pelajaran'] : 'N/A'; ?></td>
                <td><?php
                    $pt_score = $mt_score = $hw_score = $ex_score = $ft_score = 0;
                    
                    // Get PT and MT scores
                    foreach ($nilai_mid['mid'] as $nilaimid) {
                        if ($nilaimid['pelajaran_id'] == 5) {
                            $pt_score = $nilaimid['nilai_pt'];
                            $mt_score = $nilaimid['nilai_mt'];
                            break;
                        }
                    }
                    
                    // Get HW, EX and FT scores
                    $hw_total = $hw_count = $ex_total = $ex_count = 0;
                    foreach ($nilai_mid['final'] as $nilaifinal) {
                        if ($nilaifinal['pelajaran_id'] == 5) {
                            if ($nilaifinal['jenisnilai'] == 'hw') {
                                $hw_total += $nilaifinal['nilai'];
                                $hw_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ex') {
                                $ex_total += $nilaifinal['nilai'];
                                $ex_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                        }
                    }
                    
                    $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                    $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                    $ft_with_bonus = min($ft_score + ($ft_score * 0.07), 100);
                    
                    $final_score = ($pt_score * 0.10) + ($mt_score * 0.15) + 
                                 ($hw_score * 0.20) + ($ex_score * 0.25) + 
                                 ($ft_with_bonus * 0.30);
                    
                    echo number_format($final_score, 2);
                    ?></td>
                <td><?php
                    // Science class average
                    $ratakelas_science = $raporfinal_model->get_rata_kelas_detail($siswa['kelas_id'], 5); 
                    $average = ($ratakelas_science['nilai_pt'] + $ratakelas_science['nilai_mt'] + $ratakelas_science['nilai_hw'] + $ratakelas_science['nilai_ex'] + $ratakelas_science['nilai_ft']) / 5;
                    echo number_format($average, 2);
                ?></td>
            </tr>
            <tr>
                <!-- ICT -->
                <td>4</td>
                <td style="text-align: left;"><?php echo isset($pelajaran[3]['nama_pelajaran']) ? $pelajaran[3]['nama_pelajaran'] : 'N/A'; ?></td>
                <td><?php
                    $pt_score = $mt_score = $hw_score = $ex_score = $ft_score = 0;
                    
                    // Get PT and MT scores
                    foreach ($nilai_mid['mid'] as $nilaimid) {
                        if ($nilaimid['pelajaran_id'] == 6) {
                            $pt_score = $nilaimid['nilai_pt'];
                            $mt_score = $nilaimid['nilai_mt'];
                            break;
                        }
                    }
                    
                    // Get HW, EX and FT scores
                    $hw_total = $hw_count = $ex_total = $ex_count = 0;
                    foreach ($nilai_mid['final'] as $nilaifinal) {
                        if ($nilaifinal['pelajaran_id'] == 6) {
                            if ($nilaifinal['jenisnilai'] == 'hw') {
                                $hw_total += $nilaifinal['nilai'];
                                $hw_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ex') {
                                $ex_total += $nilaifinal['nilai'];
                                $ex_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                        }
                    }
                    
                    $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                    $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                    $ft_with_bonus = min($ft_score + ($ft_score * 0.07), 100);
                    
                    $final_score = ($pt_score * 0.10) + ($mt_score * 0.15) + 
                                 ($hw_score * 0.20) + ($ex_score * 0.25) + 
                                 ($ft_with_bonus * 0.30);
                    
                    echo number_format($final_score, 2);
                    ?></td>
                <td><?php
                    // ICT class average
                    $ratakelas_ict = $raporfinal_model->get_rata_kelas_detail($siswa['kelas_id'], 6); 
                    $average = ($ratakelas_ict['nilai_pt'] + $ratakelas_ict['nilai_mt'] + $ratakelas_ict['nilai_hw'] + $ratakelas_ict['nilai_ex'] + $ratakelas_ict['nilai_ft']) / 5;
                    echo number_format($average, 2);
                ?></td>
            </tr>
            <tr class="table-secondary">
                <td colspan="4" style="font-weight: bold;">Islamic Studies</td>
            </tr>
            <tr>
                <!-- Tahfidz -->
                <td>5</td>
                <td style="text-align: left;"><?php echo isset($pelajaran[5]['nama_pelajaran']) ? $pelajaran[5]['nama_pelajaran'] : 'N/A'; ?></td>
                <td><?php
                    $pt_score = $mt_score = $hw_score = $ex_score = $ft_score = 0;
                    
                    // Get PT and MT scores
                    foreach ($nilai_mid['mid'] as $nilaimid) {
                        if ($nilaimid['pelajaran_id'] == 10) {
                            $pt_score = $nilaimid['nilai_pt'];
                            $mt_score = $nilaimid['nilai_mt'];
                            break;
                        }
                    }
                    
                    // Get HW, EX and FT scores
                    $hw_total = $hw_count = $ex_total = $ex_count = 0;
                    foreach ($nilai_mid['final'] as $nilaifinal) {
                        if ($nilaifinal['pelajaran_id'] == 10) {
                            if ($nilaifinal['jenisnilai'] == 'hw') {
                                $hw_total += $nilaifinal['nilai'];
                                $hw_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ex') {
                                $ex_total += $nilaifinal['nilai'];
                                $ex_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                        }
                    }
                    
                    $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                    $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                    $ft_with_bonus = min($ft_score + ($ft_score * 0.07), 100);
                    
                    $final_score = ($pt_score * 0.10) + ($mt_score * 0.15) + 
                                 ($hw_score * 0.20) + ($ex_score * 0.25) + 
                                 ($ft_with_bonus * 0.30);
                    
                    echo number_format($final_score, 2);
                    ?></td>
                <td><?php
                    // Tahfidz class average
                    $ratakelas_tahfidz = $raporfinal_model->get_rata_kelas_detail($siswa['kelas_id'], 10); 
                    $average = ($ratakelas_tahfidz['nilai_pt'] + $ratakelas_tahfidz['nilai_mt'] + $ratakelas_tahfidz['nilai_hw'] + $ratakelas_tahfidz['nilai_ex'] + $ratakelas_tahfidz['nilai_ft']) / 5;
                    echo number_format($average, 2);
                ?></td>
            </tr>
            <tr>
                <!-- Arabic -->
                <td>6</td>
                <td style="text-align: left;"><?php echo isset($pelajaran[4]['nama_pelajaran']) ? $pelajaran[4]['nama_pelajaran'] : 'N/A'; ?></td>
                <td><?php
                    $pt_score = $mt_score = $hw_score = $ex_score = $ft_score = 0;
                    
                    // Get PT and MT scores
                    foreach ($nilai_mid['mid'] as $nilaimid) {
                        if ($nilaimid['pelajaran_id'] == 8) {
                            $pt_score = $nilaimid['nilai_pt'];
                            $mt_score = $nilaimid['nilai_mt'];
                            break;
                        }
                    }
                    
                    // Get HW, EX and FT scores
                    $hw_total = $hw_count = $ex_total = $ex_count = 0;
                    foreach ($nilai_mid['final'] as $nilaifinal) {
                        if ($nilaifinal['pelajaran_id'] == 8) {
                            if ($nilaifinal['jenisnilai'] == 'hw') {
                                $hw_total += $nilaifinal['nilai'];
                                $hw_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ex') {
                                $ex_total += $nilaifinal['nilai'];
                                $ex_count++;
                            }
                            if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                        }
                    }
                    
                    $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                    $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                    $ft_with_bonus = min($ft_score + ($ft_score * 0.07), 100);
                    
                    $final_score = ($pt_score * 0.10) + ($mt_score * 0.15) + 
                                 ($hw_score * 0.20) + ($ex_score * 0.25) + 
                                 ($ft_with_bonus * 0.30);
                    
                    echo number_format($final_score, 2);
                    ?></td>
                <td><?php
                    // Arabic class average
                    $ratakelas_arabic = $raporfinal_model->get_rata_kelas_detail($siswa['kelas_id'], 8); 
                    $average = ($ratakelas_arabic['nilai_pt'] + $ratakelas_arabic['nilai_mt'] + $ratakelas_arabic['nilai_hw'] + $ratakelas_arabic['nilai_ex'] + $ratakelas_arabic['nilai_ft']) / 5;
                    echo number_format($average, 2);
                ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2"><strong><?php
                    $total_score = 0;
                    foreach ($pelajaran as $index => $subject) {
                        $subject_id = $subject['id'];
                        $pt_score = $mt_score = $hw_score = $ex_score = $ft_score = 0;

                        // Get PT and MT scores
                        foreach ($nilai_mid['mid'] as $nilaimid) {
                            if ($nilaimid['pelajaran_id'] == $subject_id) {
                                $pt_score = $nilaimid['nilai_pt'];
                                $mt_score = $nilaimid['nilai_mt'];
                                break;
                            }
                        }

                        // Get HW, EX and FT scores
                        $hw_total = $hw_count = $ex_total = $ex_count = 0;
                        foreach ($nilai_mid['final'] as $nilaifinal) {
                            if ($nilaifinal['pelajaran_id'] == $subject_id) {
                                if ($nilaifinal['jenisnilai'] == 'hw') {
                                    $hw_total += $nilaifinal['nilai'];
                                    $hw_count++;
                                }
                                if ($nilaifinal['jenisnilai'] == 'ex') {
                                    $ex_total += $nilaifinal['nilai'];
                                    $ex_count++;
                                }
                                if ($nilaifinal['jenisnilai'] == 'ft') $ft_score = $nilaifinal['nilai'];
                            }
                        }

                        $hw_score = $hw_count > 0 ? $hw_total / $hw_count : 0;
                        $ex_score = $ex_count > 0 ? $ex_total / $ex_count : 0;
                        $ft_with_bonus = min($ft_score + ($ft_score * 0.07), 100);

                        $final_score = ($pt_score * 0.10) + ($mt_score * 0.15) +
                                     ($hw_score * 0.20) + ($ex_score * 0.25) +
                                     ($ft_with_bonus * 0.30);

                        $total_score += $final_score;
                    }
                    echo number_format($total_score, 2);
                ?></strong></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Average</strong></td>
                <td colspan="2"><strong><?php
                    $average_score = count($pelajaran) > 0 ? $total_score / count($pelajaran) : 0;
                    echo number_format($average_score, 2);
                ?></strong></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered" style="margin-top: 20px;">
        <thead>
            <tr class="table-secondary">
                <td style="font-weight: bold; text-align: center;">Description</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="ds" style="text-align: center; padding: 8px !important; line-height: 1.5; margin-bottom: 10px;">
                    <?php echo isset($deskripsi_nilai['deskripsi']) ? nl2br($deskripsi_nilai['deskripsi']) : 'No description available'; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <p style=" text-align: center; margin-top: 30px;">Jakarta, June 14<sup>th</sup>, 2025</p>

    <table style="width: 100%; margin-top: 20px; border: none;">
        <tr style="text-align: center;">
            <td style="width: 33.33%; border: none;">Parent's Signature</td>
            <td style="width: 33.33%; border: none;">Principal's Signature</td>
            <td style="width: 33.33%; border: none;">Teacher's Signature</td>
        </tr>
        <tr>
            <td style="padding: 40px; border: none;">&nbsp;</td>
            <td style="padding: 40px; border: none;">&nbsp;</td>
            <td style="padding: 40px; border: none;">&nbsp;</td>
        </tr>
        <tr style="text-align: center;">
            <td style="font-weight: bold; text-decoration: underline; border: none;">___________________</td>
            <td style="font-weight: bold; text-decoration: underline; border: none;">Siti Nisrina, S.Pd</td>
            <td style="font-weight: bold; text-decoration: underline; border: none;">
                <?php
                echo isset($walikelas['nama']) ? $walikelas['nama'] : 'N/A';
                ?>
            </td>
        </tr>
    </table>
</body>

</html>