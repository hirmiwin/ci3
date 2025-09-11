<!-- tahunajaran_view.php -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>Data Tahun Ajaran</h1>
    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalTambahTahun">Tambah Tahun Ajaran</button>
  </section>
  <!-- Modal Tambah Tahun Ajaran -->
  <div class="modal fade" id="modalTambahTahun" tabindex="-1" role="dialog" aria-labelledby="modalTambahTahunLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?php echo site_url('tahunajaran/tambah'); ?>" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahTahunLabel">Tambah Tahun Ajaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Tahun</label>
              <input type="text" name="nama_tahun" class="form-control" required>
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
  <section class="content">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nama Tahun</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tahunajaran as $t): ?>
            <tr>
              <td><?php echo $t->nama_tahun; ?></td>
              <td><?php echo $t->status; ?></td>
              <td>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditTahun<?php echo $t->id; ?>">Edit</button>
                <a href="<?php echo site_url('tahunajaran/delete/'.$t->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
              </td>
            </tr>

            <!-- Modal Edit Tahun Ajaran -->
            <div class="modal fade" id="modalEditTahun<?php echo $t->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditTahunLabel<?php echo $t->id; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?php echo site_url('tahunajaran/edit/'.$t->id); ?>" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEditTahunLabel<?php echo $t->id; ?>">Edit Tahun Ajaran</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Nama Tahun</label>
                        <input type="text" name="nama_tahun" class="form-control" value="<?php echo $t->nama_tahun; ?>" required>
                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                          <option value="aktif" <?php echo ($t->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                          <option value="nonaktif" <?php echo ($t->status == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
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
            <!-- End Modal Edit Tahun Ajaran -->
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
