<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <h3>Siswa: <?php echo htmlspecialchars($siswa->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></h3>
    <p>NIS: <?php echo htmlspecialchars($siswa->nis, ENT_QUOTES, 'UTF-8'); ?></p>
 
    <p>Saldo Saat Ini: <strong>Rp <?php echo number_format($riwayat->saldo_akhir, 2, ',', '.'); ?></strong></p>

    <?php if(validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('tabungan/setor/' . $riwayat->id_riwayat); ?>
        <div class="form-group">
            <label for="jumlah_setor">Jumlah Setor</label>
            <input type="number" class="form-control" id="jumlah_setor" name="jumlah_setor" value="<?php echo set_value('jumlah_setor'); ?>" min="1" step="any" required>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan"><?php echo set_value('keterangan'); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Proses Setor</button>
        <a href="<?php echo site_url('tabungan'); ?>" class="btn btn-secondary">Batal</a>
    <?php echo form_close(); ?>
</div>