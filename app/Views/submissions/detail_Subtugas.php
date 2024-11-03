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
                        <div class="row">
                            <div class="col-md-3">
                                <div class=" card-primary card-outline">
                                    <div class=" card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="<?= $userData->profile ?>" alt="User profile picture">
                                        </div>
                                        <h4 class="profile-username text-center"><?= $userData->username ?></h4>
                                        <p class="profile-username text-center"><span><?= $userData->role ?></span></p>
                                    </div>
                                </div>
                                <div class="card-primary">
                                    <div class="card-body">
                                        <div class="cb card-body text-center">
                                            <hr>
                                            <h4 class="">About Kelas</h4>
                                        </div>
                                        <hr>
                                        <strong><i class="fas fa-book mr-1"></i>&nbsp;&nbsp;Course</strong>
                                        <p class="text-muted"><?= $course->name ?></p>
                                        <strong><i class="fas fa-home mr-1"></i>&nbsp;&nbsp;Ruang</strong>
                                        <p class="text-muted"><?= $course->room ?></p>
                                        <strong><i class="fa fa-clock mr-1"></i>&nbsp;&nbsp;Waktu</strong>
                                        <p class="text-muted"><?= $course->schedule ?></p>
                                        <strong><i class="fas fa-pencil-alt mr-1"></i>&nbsp;&nbsp;Description</strong>
                                        <p class="text-muted">
                                            <span class="tag tag-danger"><?= $course->description ?></span>
                                        </p>
                                        <strong><i class="fas fa-share-alt mr-1"></i>&nbsp;&nbsp;Kode Kelas</strong>
                                        <div>
                                            <p id="va_number" class="text">
                                                <?= $course->tautan ?>

                                                <button id="copy_btn"><i class="fas fa-copy"></i></button>
                                                <!-- Pesan Sukses --><br>
                                                <span id="copy_message" class="hidden text-success">
                                                    Code Kelas Telah berhasil di salin!!
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    const button = document.getElementById("copy_btn");
                                    const message = document.getElementById("copy_message");
                                    const number = document.getElementById("va_number").innerText;

                                    button.addEventListener("click", () => {
                                        navigator.clipboard.writeText(number);
                                        showMessage();
                                    });

                                    function showMessage() {
                                        message.classList.remove("hidden");
                                        setTimeout(() => {
                                            message.classList.add("hidden");
                                        }, 1500);
                                    }
                                </script>
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
                                                    <!-- create.php -->

                                                    <form action="<?= site_url('assignments/store_assignment') ?>" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="course_id" value="<?= $courses->id ?>">
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title" name="title" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="due_date" class="form-label">Due Date</label>
                                                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="file" class="form-label">Upload File</label>
                                                            <input type="file" class="form-control" id="file" name="file">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="google_drive_link" class="form-label">Google
                                                                Drive Link</label>
                                                            <input type="text" class="form-control" id="google_drive_link" name="google_drive_link">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Create
                                                            Assignment</button>
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