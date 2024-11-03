<?= $this->extend('all-temp/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <section class="wrapper">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="container mt-4">
                        <h2>Edit Course</h2>
                        <?php if (session()->has('success')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->get('success') ?>
                            </div>
                        <?php elseif (session()->has('error')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->get('error') ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('course/update_course/' . $course->id) ?>" method="post">
                            <!-- CSRF Token -->
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $course->name ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"><?= $course->description ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="room" class="form-label">Ruang</label>
                                <textarea class="form-control" id="room" name="room"><?= $course->room ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="schedule" class="form-label">Schedule</label>
                                <textarea class="form-control" id="schedule" name="schedule"><?= $course->schedule ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>