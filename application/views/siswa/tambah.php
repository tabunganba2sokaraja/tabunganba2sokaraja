<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <?php if(validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('siswa/tambah'); ?>
        <div class="form-group">
            <label for="nis">NIS (Nomor Induk Siswa)</label>
            <input type="text" class="form-control" id="nis" name="nis" value="<?php echo set_value('nis'); ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap Siswa</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo set_value('nama_lengkap'); ?>" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas (Opsional)</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo set_value('kelas'); ?>">
        </div>
        <div class="form-group">
            <label for="nama_orang_tua">Nama Orang Tua</label>
            <input type="text" class="form-control" id="nama_orang_tua" name="nama_orang_tua" value="<?php echo set_value('nama_orang_tua'); ?>" required>
        </div>
        <div class="form-group">
            <label for="kontak_orang_tua">Kontak Orang Tua (No. Telepon/HP)</label>
            <input type="text" class="form-control" id="kontak_orang_tua" name="kontak_orang_tua" value="<?php echo set_value('kontak_orang_tua'); ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Siswa</button>
        <a href="<?php echo site_url('siswa'); ?>" class="btn btn-secondary">Batal</a>
    <?php echo form_close(); ?>
</div>