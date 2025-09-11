<!-- tahunajaran_form.php -->
<div class="modal show" style="display:block; background:rgba(0,0,0,0.2);" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo isset($tahunajaran) ? 'Edit' : 'Tambah'; ?> Tahun Ajaran</h5>
          <a href="<?php echo site_url('tahunajaran'); ?>" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Tahun</label>
            <input type="text" name="nama_tahun" class="form-control" value="<?php echo isset($tahunajaran) ? $tahunajaran->nama_tahun : ''; ?>" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="aktif" <?php echo (isset($tahunajaran) && $tahunajaran->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
              <option value="nonaktif" <?php echo (isset($tahunajaran) && $tahunajaran->status == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <a href="<?php echo site_url('tahunajaran'); ?>" class="btn btn-default">Tutup</a>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
