<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th class="text-right">Saldo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($siswa)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($siswa as $s): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($s->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($s->nis, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-right">Rp <?= number_format($s->saldo_akhir ?? 0, 2, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge <?= 
                                            ($s->status_riwayat == 'aktif') ? 'badge-success' : 
                                            (($s->status_riwayat == 'diblokir') ? 'badge-warning' : 'badge-secondary'); 
                                        ?>">
                                            <?= ucfirst($s->status_riwayat ?? 'ditutup'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if(!empty($s->id_riwayat)): ?>
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('tabungan/setor/' . $s->id_riwayat); ?>" class="btn btn-sm btn-success" title="Setor">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a href="<?= site_url('tabungan/tarik/' . $s->id_riwayat); ?>" class="btn btn-sm btn-danger" title="Tarik">
                                                    <i class="fas fa-minus-circle"></i>
                                                </a>
                                                <a href="<?= site_url('tabungan/riwayat_transaksi/' . $s->id_riwayat); ?>" class="btn btn-sm btn-info" title="Riwayat">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">No Account</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-info-circle fa-2x text-gray-400 mb-3"></i>
                                    <p>Belum ada data siswa dengan tabungan.</p>
                                    <a href="<?= site_url('siswa/import'); ?>" class="btn btn-primary">
                                        <i class="fas fa-file-import"></i> Import Data Siswa
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->