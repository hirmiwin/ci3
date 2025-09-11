<h3>Daftar Wali Kelas Tahun Ajaran: <?php echo $tahun_ajaran_nama; ?></h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kelas</th>
            <th>Unit</th>
            <th>Nama Wali Kelas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($wali_kelas as $wk): ?>
        <tr>
            <td><?php echo $wk->nama_kelas; ?></td>
            <td><?php echo $wk->nama_unit; ?></td>
            <td><?php echo $wk->nama_guru; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
