<!-- semester_view.php -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Semester</h1>
    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalTambahSemester">Tambah Semester</button>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nama Semester</th>
              <th>Tahun Ajaran</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($semester as $s): ?>
            <tr>
              <td><?php echo $s->nama_semester; ?></td>
              <td><?php echo $s->nama_tahun; ?></td>
              <td><?php echo $s->status; ?></td>
              <td>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditSemester<?php echo $s->id; ?>">Edit</button>
                <a href="<?php echo site_url('semester/delete/'.$s->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
              </td>
            </tr>
            <!-- Modal Edit Semester -->
            <div class="modal fade" id="modalEditSemester<?php echo $s->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditSemesterLabel<?php echo $s->id; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?php echo site_url('semester/edit/'.$s->id); ?>" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEditSemesterLabel<?php echo $s->id; ?>">Edit Semester</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Nama Semester</label>
                        <input type="text" name="nama_semester" class="form-control" value="<?php echo $s->nama_semester; ?>" required>
                      </div>
                      <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control" required>
                          <option value="">- Pilih Tahun Ajaran -</option>
                          <?php foreach ($tahunajaran as $t): ?>
                            <option value="<?php echo $t->id; ?>" <?php echo ($s->tahun_ajaran_id == $t->id) ? 'selected' : ''; ?>><?php echo $t->nama_tahun; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                          <option value="aktif" <?php echo ($s->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                          <option value="nonaktif" <?php echo ($s->status == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
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
            <!-- End Modal Edit Semester -->
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<!-- Modal Tambah Semester -->
<div class="modal fade" id="modalTambahSemester" tabindex="-1" role="dialog" aria-labelledby="modalTambahSemesterLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo site_url('semester/tambah'); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahSemesterLabel">Tambah Semester</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Semester</label>
            <input type="text" name="nama_semester" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Tahun Ajaran</label>
            <select name="tahun_ajaran_id" class="form-control" required>
              <option value="">- Pilih Tahun Ajaran -</option>
              <?php foreach ($tahunajaran as $t): ?>
              <option value="<?php echo $t->id; ?>"><?php echo $t->nama_tahun; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
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
