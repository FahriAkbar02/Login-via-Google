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
                    <h2>Edit Soal Tugas </h2>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                <div class="">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
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
                                                        action="<?= site_url('assignments/update_assignments/' . $assignment->id) ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <?= csrf_field() ?>
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Judul</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" value="<?= $assignment->title ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="announcementText"
                                                                class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" id="announcementText"
                                                                name="description"
                                                                rows="3"><?= $assignment->description ?></textarea>

                                                            </textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="due_date" class="form-label">Tanggal
                                                                Berakhir</label>
                                                            <input type="date" class="form-control" id="due_date"
                                                                name="due_date" value="<?= $assignment->due_date ?>"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="current_file" class="form-label">File yang Akan
                                                                Diubah</label>
                                                            <p><?= $assignment->file_path ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="file_path" class="form-label">File Baru</label>
                                                            <input type="file" class="form-control" id="file_path"
                                                                name="file_path">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="google_drive_link" class="form-label">Link
                                                                Google Drive</label>
                                                            <input type="text" class="form-control"
                                                                id="google_drive_link" name="google_drive_link"
                                                                value="<?= $assignment->google_drive_link ?>">
                                                        </div>
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