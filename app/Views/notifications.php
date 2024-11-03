<?= $this->extend('all-temp/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="card-body">
            <h1>Notification List</h1>
            <div class="row mt-4">
                <div class="col-md-8 offset-md-2">
                    <div class="list-group">
                        <!-- Tambahkan pemberitahuan di sini -->
                        <?php if (session()->has('notification')) : ?>
                        <div class="list-group-item">
                            <h5 class="mb-1"><?= session('notification'); ?></h5>
                            <!-- Tambahkan timestamp jika perlu -->
                        </div>
                        <?php endif; ?>
                        <!-- Akhir pemberitahuan -->

                        <!-- Menampilkan notifikasi sesuai dengan kursus yang diikuti -->
                        <?php if (!empty($notifications)) : ?>
                        <?php foreach ($notifications as $notification) : ?>
                        <div class="list-group-item">
                            <h5 class="mb-1">
                                <a
                                    href="<?= base_url('/submissions/create_submissions/' . $notification['assignment_id']); ?>">
                                    <?= $notification['message']; ?>
                                    "<?= $notification['assignment_title']; ?>"
                                </a>
                            </h5>
                            <small><?= date('F j, Y, g:i a', strtotime($notification['created_at'])); ?></small>
                            <p>Course: <?= $notification['course_name']; ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <div class="alert alert-info" role="alert">
                            No notifications found.
                        </div>
                        <?php endif; ?>
                        <!-- Akhir notifikasi -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection('page-content'); ?>