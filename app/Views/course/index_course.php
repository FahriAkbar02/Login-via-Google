<?= $this->extend('all-temp/index'); ?>

<?= $this->section('page-content'); ?>
<style>
.card {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    transition: all 0.2s ease-in-out;
    box-sizing: border-box;
    margin-top: 10px;
    margin-bottom: 10px;
    margin: 0px 10px 0px 10px;
    background-color: #FFF;
}

.card:hover {
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
}

.card>.card-inner {
    padding: 10px;
}

.card .header h2,
h3 {
    margin-bottom: 0px;
    margin-top: 0px;
}

.p {
    font-size: 7px;
}

.card .header {
    margin-bottom: 5px;
}

.card img {
    width: 100%;
}
</style>
<div class="container-fluid">
    <section class="wrapper">
        <div class="card-body">
            <div class="container">
                <?php if (session()->has('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->get('success') ?>
                </div>
                <?php elseif (session()->has('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->get('error') ?>
                </div>
                <?php endif; ?>
                <div class="row">
                    <?php if (!empty($userCourses)) : ?>
                    <?php foreach ($userCourses as $course) : ?>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <div class="card mb-3">
                            <a href="<?= base_url('/course/detail_course/' . $course['id']) ?>">
                                <div class="row no-gutters">
                                    <div class="image">
                                        <img src="https://gstatic.com/classroom/themes/img_read.jpg" class="card-img"
                                            alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h4><?= $course['name'] ?></h4>
                                            </div>
                                            <div class="card-text">
                                                <p><i class="fa fa-clock mr-1"></i> <?= $course['schedule'] ?>,
                                                    <?= $course['room'] ?></p>
                                            </div>
                                            <div class="avatar avatar-online">
                                                <img src="<?= $userData->profile ?>" alt="Profile Picture"
                                                    class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                            <p class="card-text" style="margin-left: 5px;">
                                                <?= $userData->username ?>
                                            </p>
                                            <?php if ($course['user_id'] == $userData->id) : ?>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown" style="margin-top: 10px;">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton<?= $course['id'] ?>" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $course['id'] ?>">
                                    <a class="dropdown-item"
                                        href="<?= base_url('/course/edit_course/' . $course['id']) ?>">Edit</a>

                                    <a class="dropdown-item" href="#"
                                        onclick=" return confirmDeleteCour('<?= $course['id']; ?>')"> Hapus</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div class="col-12">
                        Belum membuat Kelas !!
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($joinedCourses)) : ?>
                    <?php foreach ($joinedCourses as $course) : ?>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <div class="card mb-3">
                            <a href="<?= base_url('/course/detail_course/' . $course['id']) ?>">
                                <div class="row no-gutters">
                                    <div class="image">
                                        <img src="https://gstatic.com/classroom/themes/img_read.jpg" class="card-img"
                                            alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h4><?= $course['name'] ?></h4>
                                            </div>
                                            <div class="card-text">
                                                <p><i class="fa fa-clock mr-1"></i><?= $course['schedule'] ?>,
                                                    <?= $course['room'] ?></p>
                                            </div>
                                            <p class="card-text"><?= $course['username'] ?></p>
                                            <div class="avatar avatar-online" style="margin-left: 30px;">
                                                <img src="<?= $course['profile'] ?>" alt="Profile Picture"
                                                    class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div class="col-12">
                        Belum Bergabung dalam Kelas !!
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
function confirmDeleteCour(id) {
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
            // Lakukan penghapusan jika dikonfirmasi
            window.location.href =
                "<?= base_url('/course/delete_course/'); ?>" +
                id;
        } else if (result.dismiss === Swal
            .DismissReason
            .cancel) {}
    });
}
</script>
<?= $this->endSection('page-content'); ?>