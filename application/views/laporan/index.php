<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <div class="list-group">
        <a href="<?php echo site_url('laporan/siswa'); ?>" class="list-group-item list-group-item-action">Laporan Data Siswa</a>
        <a href="<?php echo site_url('laporan/transaksi'); ?>" class="list-group-item list-group-item-action">Laporan Riwayat Transaksi</a>
        </div>
</div>