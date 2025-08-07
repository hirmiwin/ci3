<!-- filepath: c:\laragon\www\raporsd\application\views\nilaifinalmanual_input_view.php -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nilai Manual English</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Nilai Manual English</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Input Nilai Manual English</h3>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                            <?php endif; ?>
                            <form method="get" action="<?= site_url('nilaifinalmanual/input_nilai') ?>">
                                <div class="form-group">
                                    <label for="kelas_id">Pilih Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $k): ?>
                                            <option value="<?= $k['id'] ?>" <?= isset($selected_kelas) && $selected_kelas == $k['id'] ? 'selected' : '' ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>
                            <?php if (!empty($siswa_list)): ?>
                            <form method="post" action="">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Nilai Manual English</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siswa_list as $i => $siswa): ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td><?= htmlspecialchars($siswa['nama']) ?></td>
                                            <td>
                                                <input type="number" class="form-control" name="nilai_manual[<?= $siswa['id'] ?>]" value="<?= isset($nilai_manual[$siswa['id']]) ? htmlspecialchars($nilai_manual[$siswa['id']]['nilai']) : '' ?>" max="100" min="0" required>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Nilai Manual English</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                            <?php elseif (isset($selected_kelas) && $selected_kelas): ?>
                                <div class="alert alert-info">Tidak ada siswa di kelas ini.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
