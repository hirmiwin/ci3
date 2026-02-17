<!-- Modal Form Tambah/Edit Kelas -->
<div class="modal fade show" style="display:block;" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo isset($kelas) ? 'Edit' : 'Tambah'; ?> Kelas</h4>
        <a href="<?php echo site_url('kelas'); ?>" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" value="<?php echo isset($kelas) ? $kelas->nama_kelas : ''; ?>" required>
          </div>
          <div class="form-group">
            <label>Unit</label>
            <select name="unit" class="form-control" required>
              <option value="">- Pilih Unit -</option>
              <?php foreach ($units as $u): ?>
              <option value="<?php echo $u->id; ?>" <?php echo (isset($kelas) && $kelas->unit == $u->id) ? 'selected' : ''; ?>>
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
<!-- End Modal -->
