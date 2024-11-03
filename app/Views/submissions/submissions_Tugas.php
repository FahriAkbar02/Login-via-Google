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
        background-color: green;
    }
</style>
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="card-body">
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
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
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Tugas Kelas</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Jawaban</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="activity">
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
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="float-right">
                                                            <div class="text-muted">
                                                                <h4>Tugas</h4>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="float-left">
                                                                    <div class="d-flex align-items-center">
                                                                        <h3><?= $assignment->title ?></h3>
                                                                    </div>
                                                                    <span class="ml-3"><?= $userData->username ?></span>
                                                                </div>
                                                                <div class="float-right mt-lg-5">
                                                                    <span class="mt-2" ">
                                                                        Tenggat:
                                                                        <strong><?= isset($assignment->due_date) ? date('l, j F Y', strtotime($assignment->due_date)) : 'Belum disubmit' ?></strong>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <h4>Instruksi Tugas</h4>
                                                         <div class=" row">
                                                                        <div class="col-md-12">
                                                                            <p><?= $assignment->description ?></p>
                                                                            <p>File :<br>
                                                                                <?php if (isset($assignment->file_path) && $assignment->file_path) : ?>

                                                                                    <a href="<?= base_url($assignment->file_path) ?>" target="_blank">Open Document</a>
                                                                                <?php endif; ?>
                                                                                <br>
                                                                                <?php if (isset($assignment->google_drive_link) && $assignment->google_drive_link) : ?>
                                                                                    <a href="<?= $assignment->google_drive_link ?>" target="_blank">Open Link</a>
                                                                                <?php endif; ?>

                                                                                <?php if (!isset($assignment->file_path) && !isset($assignment->google_drive_link)) : ?>
                                                                            <p class="text-danger">File dan link tidak
                                                                                ada</p>
                                                                        <?php endif; ?>
                                                                        </p>
                                                                        </div>
                                                                </div>


                                                                <div class="mt-3">
                                                                    <a href="<?= base_url('/assignments/edit_assignments/' . $assignment->id) ?>" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-edit"></i> Edit
                                                                    </a>

                                                                    <a href="#" onclick=" return confirmDeleteAss('<?= $assignment->id; ?>')" class="btn btn-danger btn-sm ml-2"> <i class="fas fa-trash-alt"></i> Hapus</a>
                                                                    <script>
                                                                        function confirmDeleteAss(id) {
                                                                            const swalWithBootstrapButtons = Swal.mixin({
                                                                                customClass: {
                                                                                    confirmButton: "btn btn-success",
                                                                                    cancelButton: "btn btn-danger"
                                                                                },
                                                                                buttonsStyling: false
                                                                            });
                                                                            swalWithBootstrapButtons.fire({
                                                                                title: "Apa kamu yakin?",
                                                                                text: "Anda tidak akan dapat mengembalikan ini !",
                                                                                icon: "warning",
                                                                                showCancelButton: true,
                                                                                confirmButtonText: "Ya, hapus!",
                                                                                cancelButtonText: "Tidak, batal!",
                                                                                reverseButtons: true
                                                                            }).then((result) => {
                                                                                if (result.isConfirmed) {
                                                                                    window.location.href =
                                                                                        "<?= base_url('/assignments/delete_assignments/'); ?>" +
                                                                                        id;
                                                                                } else if (result.dismiss === Swal
                                                                                    .DismissReason
                                                                                    .cancel) {}
                                                                            });
                                                                        }
                                                                    </script>
                                                                </div>
                                                                <hr>

                                                                <div class="text-muted">
                                                                    <h4>Upload Jawaban di sini !!</h4>
                                                                </div>
                                                                <div class="card mt-3">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <form action="<?= site_url('submissions/store_assignments') ?>" method="post" enctype="multipart/form-data">
                                                                                <div class="mb-3">
                                                                                    <label for="file" class="form-label">Upload
                                                                                        File</label>
                                                                                    <input type="file" class="form-control" id="file_path" name="file_path" required>
                                                                                </div>
                                                                                <input type="hidden" name="assignment_id" value="<?= $assignment->id ?>">
                                                                                <input type="hidden" name="user_id" value="<?= $userId ?>">
                                                                                <button type="submit" class="btn btn-primary">Submit
                                                                                    Assignment</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="settings">
                                                <?php if ($userRole === 'guru') : ?>
                                                    <div class="user-block">
                                                        <h3>Daftar Jawaban User</h3>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Pengguna</th>
                                                                    <th>Submission Date</th>
                                                                    <th>File Jawaban</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($courseSubmissions as $submission) : ?>
                                                                    <tr>
                                                                        <td><?= isset($submission['username']) ? $submission['username'] : 'Pengguna belum mengumpulkan tugas' ?>
                                                                        </td>
                                                                        <td><?= isset($submission['submission_date']) ? date('l, j F Y', strtotime($submission['submission_date'])) : 'Belum disubmit' ?>
                                                                        </td>
                                                                        <td><?php if (isset($submission['file_path']) && $submission['file_path']) : ?>
                                                                                <a href="<?= base_url($submission['file_path']) ?>" target="_blank">Lihat Jawaban</a>
                                                                            <?php else : ?>
                                                                                Belum ada jawaban
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php elseif (!empty($courseSubmissions)) : ?>
                                                    <div class="user-block">
                                                        <h3>Daftar Jawaban Anda</h3>
                                                        <div class="table-responsive"></div>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Submission Date</th>
                                                                    <th>File Jawaban</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($courseSubmissions as $submission) : ?>
                                                                    <?php if ($userData->role === 'siswa' && $userData->id === $submission['user_id']) : ?>
                                                                        <tr>
                                                                            <td><?= isset($submission['submission_date']) ? date('l, j F Y', strtotime($submission['submission_date'])) : 'Belum disubmit' ?>
                                                                            </td>
                                                                            <td><?php if (isset($submission['file_path']) && $submission['file_path']) : ?>
                                                                                    <a href="<?= base_url($submission['file_path']) ?>" target="_blank">Lihat Jawaban</a>
                                                                                <?php else : ?>
                                                                                    Belum ada jawaban
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>

                                                                                <a href="#" onclick=" return confirmDeleteSub('<?= $submission['id']; ?>')" class="btn btn-danger btn-sm ml-2"> <i class="fas fa-trash-alt"></i> Hapus</a>
                                                                                <a href="<?= base_url('submissions/edit_submissions/' . $submission['id']) ?>/" class=" btn btn-primary btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <script>
                                                        function confirmDeleteSub(id) {
                                                            const swalWithBootstrapButtons = Swal.mixin({
                                                                customClass: {
                                                                    confirmButton: "btn btn-success",
                                                                    cancelButton: "btn btn-danger"
                                                                },
                                                                buttonsStyling: false
                                                            });
                                                            swalWithBootstrapButtons.fire({
                                                                title: "Apa kamu yakin?",
                                                                text: "Anda tidak akan dapat mengembalikan ini !",
                                                                icon: "warning",
                                                                showCancelButton: true,
                                                                confirmButtonText: "Ya, hapus!",
                                                                cancelButtonText: "Tidak, batal!",
                                                                reverseButtons: true
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    window.location.href =
                                                                        "<?= base_url('/submissions/delete_submissions/'); ?>" +
                                                                        id;
                                                                } else if (result.dismiss === Swal.DismissReason
                                                                    .cancel) {}
                                                            });
                                                        }
                                                    </script>
                                                <?php else : ?>
                                                    <p>Belum ada submission.</p>
                                                <?php endif; ?>
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