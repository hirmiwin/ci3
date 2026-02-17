<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Kelas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Kelas</li>
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
                            <h3 class="card-title">Data Kelas</h3>
                            <a href="#" class="btn btn-success float-right" data-toggle="modal" data-target="#modalTambahKelas">Tambah Kelas</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <h4>Daftar Kelas Tahun Ajaran: <?php echo $tahun_ajaran_nama; ?></h4>
                            <!-- Tabel kelas -->
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Kelas</th>
                                        <th>Unit</th>
                                        <th>Wali Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kelas as $k): ?>
                                    <tr>
                                        <td><?php echo $k->nama_kelas; ?></td>
                                        <td><?php echo $k->nama_unit; ?></td>
                                        <td><?php echo isset($wali_kelas_map[$k->id]) ? $wali_kelas_map[$k->id] : '-'; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalWaliKelas<?php echo $k->id; ?>">Set/Update Wali Kelas</a>
                                            <a href="<?php echo site_url('kelas/edit/'.$k->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="<?php echo site_url('kelas/delete/'.$k->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kelas?')">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Modal Set/Update Wali Kelas untuk setiap kelas -->
                                    <div class="modal fade" id="modalWaliKelas<?php echo $k->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalWaliKelasLabel<?php echo $k->id; ?>" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <form action="<?php echo site_url('kelas/tambah_wali/'.$k->id); ?>" method="post">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="modalWaliKelasLabel<?php echo $k->id; ?>">Set/Update Wali Kelas</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="form-group">
                                                <label>Pilih Guru</label>
                                                <select name="guru_id" class="form-control" required>
                                                  <option value="">- Pilih Guru -</option>
                                                  <?php if (isset($gurus) && is_array($gurus)): ?>
                                                    <?php foreach ($gurus as $g): ?>
                                                      <option value="<?php echo $g->id; ?>"><?php echo $g->nama; ?></option>
                                                    <?php endforeach; ?>
                                                  <?php endif; ?>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                              <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- End Modal -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Edit Modal -->
<?php foreach ($kelas as $row): ?>
    <?php
    // Ambil tahun ajaran aktif dari session
    $tahun_ajaran_id = $this->session->userdata('tahun_ajaran_id');
    $wali_kelas_row = $this->db->get_where('wali_kelas', [
        'kelas_id' => $row->id,
        'tahun_ajaran_id' => $tahun_ajaran_id
    ])->row();
    $selected_wali_kelas = $wali_kelas_row ? $wali_kelas_row->guru_id : '';
    ?>
    <div class="modal fade" id="modal-edit-<?php echo $row->id; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kelas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo site_url('kelas/update'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                        <div class="form-group">
                            <label for="nama">Unit</label>
                            <select class="form-control" id="nama" name="unit" required>
                                <?php foreach ($units as $unit): ?>
                                    <option value="<?php echo $unit->id; ?>" <?php echo $row->unit == $unit->id ? 'selected' : ''; ?>>
                                        <?php echo $unit->nama_unit; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nis">Nama Kelas</label>
                            <input type="text" class="form-control" id="nis" name="nama_kelas" value="<?php echo $row->nama_kelas; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nisn">Wali Kelas</label>
                            <select class="form-control" id="nisn" name="wali_kelas" required>
                                <?php foreach ($users as $user): ?>
                                    <?php if ($user->role == 'guru'): ?>
                                        <option value="<?php echo $user->id; ?>" <?php echo $selected_wali_kelas == $user->id ? 'selected' : ''; ?>>
                                            <?php echo $user->nama; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php endforeach; ?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kelas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo site_url('kelas/simpan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Unit</label>
                        <select class="form-control" name="unit" required>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?php echo $unit->id; ?>"><?php echo $unit->nama_unit; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" class="form-control" name="nama_kelas" required>
                    </div>
                    <div class="form-group">
                        <label>Wali Kelas</label>
                        <select class="form-control" name="wali_kelas" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user->id; ?>"><?php echo $user->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" role="dialog" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo site_url('kelas/tambah'); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahKelasLabel">Tambah Kelas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Unit</label>
            <select name="unit" class="form-control" required>
              <option value="">- Pilih Unit -</option>
              <?php foreach ($units as $u): ?>
              <option value="<?php echo $u->id; ?>"><?php echo $u->nama_unit; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.modal -->

<!-- Modal Edit Kelas -->
<?php if (!empty($edit_modal) && !empty($kelas_edit)): ?>
<div class="modal fade show" id="modalEditKelas" tabindex="-1" role="dialog" style="display:block;" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo site_url('kelas/edit/'.$kelas_edit->id); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Edit Kelas</h5>
          <a href="<?php echo site_url('kelas'); ?>" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" value="<?php echo $kelas_edit->nama_kelas; ?>" required>
          </div>
          <div class="form-group">
            <label>Unit</label>
            <select name="unit" class="form-control" required>
              <option value="">- Pilih Unit -</option>
              <?php foreach ($units as $u): ?>
              <option value="<?php echo $u->id; ?>" <?php echo ($kelas_edit->unit == $u->id) ? 'selected' : ''; ?>>
                <?php echo $u->nama_unit; ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <a href="<?php echo site_url('kelas'); ?>" class="btn btn-default">Tutup</a>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#modalEditKelas').modal('show');
  });
</script>
<?php endif; ?>