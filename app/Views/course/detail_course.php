<?= $this->extend('all-temp/index'); ?>
<?= $this->section('page-content'); ?>
<style>
    .cb {
        padding: 0px;
    }

    .cb1 {
        padding: 0px;
        box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
        margin-bottom: 40px;
    }

    .image img,
    .icon {
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
                                        showMessage(); // Tampilkan pesan sukses
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
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item "><a class="nav-link active" href="#activity" data-toggle="tab">Tugas Kelas</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Orang</a>
                                            </li>
                                        </ul>
                                    </div>
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
                                                    <img src="https://gstatic.com/classroom/themes/img_read.jpg" class="card-img" alt="...">
                                                    <a href="<?= base_url('assignments/create_assignments/' . $course->id . '/' . $userData->id) ?>">
                                                        <div class="cb1 card-body">
                                                            <button type="button" class="btn btn-default btn-block">
                                                                <img class="w-px-40 h-auto rounded-circle" src="<?= $userData->profile ?>" alt="user image">
                                                                &nbsp;&nbsp;<span class="username">
                                                                    Umumkan sesuatu kepada kelas Anda
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </a>
                                                    <?php foreach ($assignments as $assignment) : ?>
                                                        <a href="<?= site_url('submissions/create_submissions/' . $assignment->id) ?>">
                                                            <div class="cb1 card-body">
                                                                <button type="button" class="btn btn-default btn-block">

                                                                    <img class="w-px-40 h-auto rounded-circle" src="  <?= $assignment->creator_profile ?>" alt="User profile picture">
                                                                    &nbsp;&nbsp;
                                                                    <span class="username">
                                                                        <?= $assignment->creator_username ?>
                                                                        Memposting : <?= $assignment->title ?><br>
                                                                        <span>
                                                                            <?= isset($assignment->created_at) ? date('l, j F Y', strtotime($assignment->created_at)) : 'Belum disubmit' ?>
                                                                        </span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="settings">
                                                <div class="container-xl">
                                                    <div class="table-responsive">
                                                        <div class="table-wrapper">
                                                            <table class="table table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Teman Sekelas</th>
                                                                        <th>Role</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($enrolledUsers)) : ?>
                                                                        <?php foreach ($enrolledUsers as $key => $user) : ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <img src="<?= $user->profile ?>" alt="Profile Picture" class="w-px-40 h-auto rounded-circle" />
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $user->username ?>
                                                                                </td>
                                                                                <td><?= $user->role ?></td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <td colspan="2">Belum ada teman kelas</td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
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