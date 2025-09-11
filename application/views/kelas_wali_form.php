<!-- Modal Set/Update Wali Kelas -->
<div class="modal fade show" style="display:block;" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h4 class="modal-title">Set/Update Wali Kelas</h4>
          <a href="<?php echo site_url('kelas'); ?>" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Pilih Guru</label>
            <select name="guru_id" class="form-control" required>
              <option value="">- Pilih Guru -</option>
              <?php foreach ($gurus as $g): ?>
              <option value="<?php echo $g->id; ?>"><?php echo $g->nama; ?></option>
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
