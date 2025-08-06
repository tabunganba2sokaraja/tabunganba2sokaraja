<div class="container mt-4">
    <h2>Import Data Siswa</h2>
    
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('siswa/proses_import') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <input type="file" name="file_excel" class="form-control-file" required accept=".xlsx,.xls">
                    <small class="text-muted">Format: .xlsx atau .xls (Max 2MB)</small>
                </div>
                <button button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Import Data
                </button>
                <a href="<?= base_url('siswa') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>