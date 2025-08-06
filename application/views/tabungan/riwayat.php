<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <h3>Siswa: <?php echo htmlspecialchars($siswa->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></h3>
    <p>NIS: <?php echo htmlspecialchars($siswa->nis, ENT_QUOTES, 'UTF-8'); ?></p>
    <p>Saldo Saat Ini: <strong>Rp <?php echo number_format($riwayat->saldo_akhir, 2, ',', '.'); ?></strong></p>

    <a href="<?php echo site_url('tabungan'); ?>" class="btn btn-info mb-3">Kembali ke Manajemen Tabungan</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah Tarik</th>
                    <th>Saldo Sebelum</th>
                    <th>Saldo Sesudah</th>
                    <th>Keterangan</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksi_list)): ?>
                    <?php $no = 1; foreach ($transaksi_list as $t): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($t->tanggal_transaksi)); ?></td>
                            <td><span class="badge <?php echo ($t->jenis_transaksi == 'setor' ? 'badge-primary' : 'badge-warning'); ?>"><?php echo htmlspecialchars(ucfirst($t->jenis_transaksi), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td class="text-right">Rp <?php echo number_format($t->jumlah, 2, ',', '.'); ?></td>
                            <td class="text-right">Rp <?php echo number_format($t->saldo_sebelum, 2, ',', '.'); ?></td>
                            <td class="text-right">Rp <?php echo number_format($t->saldo_sesudah, 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($t->keterangan, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($t->dicatat_oleh ? $t->dicatat_oleh : 'users', ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Belum ada riwayat transaksi untuk rekening ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>