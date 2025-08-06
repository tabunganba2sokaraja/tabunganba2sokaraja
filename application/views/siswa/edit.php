<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <?php if(validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('siswa/edit/' . $siswa->id); ?>
        <div class="form-group">
            <label for="nis">NIS (Nomor Induk Siswa)</label>
            <input type="text" class="form-control" id="nis" name="nis" value="<?php echo set_value('nis', $siswa->nis); ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap Siswa</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo set_value('nama_lengkap', $siswa->nama_lengkap); ?>" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas (Opsional)</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo set_value('kelas', $siswa->kelas); ?>">
        </div>
        <div class="form-group">
            <label for="nama_orang_tua">Nama Orang Tua</label>
            <input type="text" class="form-control" id="nama_orang_tua" name="nama_orang_tua" value="<?php echo set_value('nama_orang_tua', $siswa->nama_orang_tua); ?>" required>
        </div>
        <div class="form-group">
            <label for="kontak_orang_tua">Kontak Orang Tua (No. Telepon/HP)</label>
            <input type="text" class="form-control" id="kontak_orang_tua" name="kontak_orang_tua" value="<?php echo set_value('kontak_orang_tua', $siswa->kontak_orang_tua); ?>" required>
        </div>
        <div class="form-group">
            <label for="status_siswa">Status Siswa</label>
            <select class="form-control" id="status_siswa" name="status_siswa" required>
                <option value="aktif" <?= ($siswa->status_siswa == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                <option value="lulus" <?= ($siswa->status_siswa == 'lulus') ? 'selected' : '' ?>>Lulus</option>
                <option value="pindah" <?= ($siswa->status_siswa == 'pindah') ? 'selected' : '' ?>>Pindah</option>
            </select>
        </div>
                <button type="submit" class="btn btn-success">Update Siswa</button>
                <a href="<?php echo site_url('siswa'); ?>" class="btn btn-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>