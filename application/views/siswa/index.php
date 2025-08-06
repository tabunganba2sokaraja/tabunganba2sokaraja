
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

     <div class="mb-3">
    <a href="<?php echo site_url('siswa/tambah'); ?>" class="btn btn-primary">Tambah Siswa Baru</a>
    <a href="<?= base_url('siswa/import') ?>" class="btn btn-success">
        <i class="fas fa-file-import"></i> Import Excel
    </a>
    <a href="<?= base_url('siswa/export') ?>" class="btn btn-info">
        <i class="fas fa-file-export"></i> Export Excel
    </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Nama Orang Tua</th>
                    <th scope="col">Kontak Orang Tua</th>
                    <th scope="col">Saldo Akhir</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($siswa)): ?>
                    <?php $no = 1; foreach ($siswa as $s): ?>
                        <tr>
                            <th scope="row"><?php echo $no++; ?></th>
                            <td><?php echo htmlspecialchars($s->nis, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->kelas, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->nama_orang_tua, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($s->kontak_orang_tua, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-right">Rp <?php echo number_format($s->saldo_akhir, 2, ',', '.'); ?></td>
                            <td><span class="badge <?php echo ($s->status_siswa == 'aktif' ? 'badge-success' : 'badge-warning'); ?>"><?php echo htmlspecialchars(ucfirst($s->status_siswa), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td>
                                <a href="<?php echo site_url('siswa/edit/' . $s->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?php echo site_url('siswa/hapus/' . $s->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini? Rekening dan transaksi terkait juga akan terpengaruh!');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data siswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    
</div>
</div>

</div>
<!-- /.container-fluid -->
