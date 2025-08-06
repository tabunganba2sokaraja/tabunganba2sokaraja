<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <a href="<?php echo site_url('laporan'); ?>" class="btn btn-info mb-3">Kembali ke Laporan Utama</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Nama Orang Tua</th>
                    <th>Kontak Orang Tua</th>
                    <th>Saldo Akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($siswa)): ?>
                    <?php $no = 1; foreach ($siswa as $s): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($s->nis, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->kelas, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->nama_orang_tua, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->kontak_orang_tua, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-right">Rp <?php echo isset($data->saldo_akhir) ? $data->saldo_akhir : 0; ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($s->status_siswa), ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data siswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <button class="btn btn-primary" onclick="window.print()">Cetak Laporan</button>
</div>