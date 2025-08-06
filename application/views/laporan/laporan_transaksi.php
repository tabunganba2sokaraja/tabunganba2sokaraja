<div class="col-md-10" style="padding-top:10px;">
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <hr>

    <a href="<?php echo site_url('laporan'); ?>" class="btn btn-info mb-3">Kembali ke Laporan Utama</a>

    <h4>Filter Tanggal</h4>
    <?php echo form_open('laporan/transaksi', array('method' => 'post', 'class' => 'form-inline mb-3')); ?>
        <div class="form-group mr-2">
            <label for="start_date" class="sr-only">Dari Tanggal</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="form-group mr-2">
            <label for="end_date" class="sr-only">Sampai Tanggal</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    <?php echo form_close(); ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Saldo Sebelum</th>
                    <th>Saldo Sesudah</th>
                    <th>Keterangan</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksi)): ?>
                    <?php $no = 1; foreach ($transaksi as $t): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($t->tanggal_transaksi)); ?></td>
                            <td><?php echo htmlspecialchars($t->nama_siswa, ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($t->nis, ENT_QUOTES, 'UTF-8'); ?>)</td>
                            <td><span class="badge <?php echo ($t->jenis_transaksi == 'setor' ? 'badge-primary' : 'badge-warning'); ?>"><?php echo htmlspecialchars(ucfirst($t->jenis_transaksi), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td class="text-right">Rp <?php echo number_format($t->jumlah, 2, ',', '.'); ?></td>
                            <td class="text-right">Rp <?php echo number_format($t->saldo_sebelum, 2, ',', '.'); ?></td>
                            <td class="text-right">Rp <?php echo number_format($t->saldo_sesudah, 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($t->keterangan, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($t->nama_admin, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada transaksi dalam rentang tanggal ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <button class="btn btn-primary" onclick="window.print()">Cetak Laporan</button>
</div>