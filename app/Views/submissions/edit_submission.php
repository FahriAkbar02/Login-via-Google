<!-- File: edit_assignment.php -->
<?= $this->extend('all-temp/index'); ?>

<?= $this->section('page-content'); ?>
<style>
.cb {
    padding: 0px;
}

.cb1 {
    padding: 0px;
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
}

.image img {
    width: 100%;
    margin-top: 0px;
    margin-bottom: 10px;
}

.hidden {
    display: none;
}
</style>
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="card-body">
                <section class="content">
                    <div class="container-fluid">
                        <h2>Edit Jawaban</h2>
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                <div class="">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                                <!-- Tampilkan pesan sukses atau error -->
                                                <?php if (session()->has('success')) : ?>
                                                <div class="alert alert-success" role="alert">
                                                    <?= session()->get('success') ?>
                                                </div>
                                                <?php elseif (session()->has('error')) : ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?= session()->get('error') ?>
                                                </div>
                                                <?php endif; ?>
                                                <div class="user-block">
                                                    <form
                                                        action="<?= site_url('submissions/update_submissions/' . $submission->id) ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <?= csrf_field() ?>
                                                        <div class="mb-3">
                                                            <label for="current_file" class="form-label">File yang Akan
                                                                Diubah</label>
                                                            <p><?= $submission->file_path ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="file_path" class="form-label">File Baru</label>
                                                            <input type="file" class="form-control" id="file_path"
                                                                name="file_path">
                                                        </div>
                                                        <input type="hidden" name="assignment_id"
                                                            value="<?= $submission->assignment_id ?>">
                                                        <input type="hidden" name="user_id"
                                                            value="<?= $submission->user_id ?>">
                                                        <input type="hidden" name="submission_date"
                                                            value="<?= $submission->submission_date ?>">
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('page-content'); ?>