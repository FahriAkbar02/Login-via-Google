<?= $this->extend('all-temp/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="card-body">
            <h1>Assignment List</h1>
            <div class="row mt-4">
                <div class="col-md-8 offset-md-2">
                    <div class="list-group">
                        <!-- Tampilkan daftar tugas -->
                        <?php if (!empty($assignments)) : ?>
                            <?php foreach ($assignments as $assignment) : ?>
                                <div class="list-group-item">
                                    <h5 class="mb-1">
                                        <a href="<?= base_url('/submissions/create_submissions/' . $assignment['id']); ?>">
                                            <?= $assignment['title']; ?>
                                        </a>
                                    </h5>
                                    <p>Course: <?= $assignment['course_name']; ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="alert alert-info" role="alert">
                                No assignments found.
                            </div>
                        <?php endif; ?>
                        <!-- Akhir daftar tugas -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('page-content'); ?>