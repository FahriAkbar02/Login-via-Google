<?= $this->extend('auth/temp-login/index'); ?>

<?= $this->section('page-content'); ?>
<div class="bg-light py-3 py-md-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-5">
                                <h3>Register</h3>
                            </div>
                        </div>
                    </div>
                    <form action="<?= base_url('user/register') ?>" method="post">
                        <!-- Mengarahkan formulir ke route yang sesuai -->
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-12">
                                <label for="username" class="form-label">Username <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Enter your username" required>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="name@example.com" required>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-lg btn-primary" type="submit">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <hr class="mt-5 mb-4 border-secondary-subtle">
                            <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                <a href="<?= base_url('user/login') ?>"
                                    class="link-secondary text-decoration-none">Already have an account? Log in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (session()->has('success')) : ?>
<div class="alert alert-success" role="alert">
    <?= session()->get('success') ?>
</div>
<?php elseif (session()->has('error')) : ?>
<div class="alert alert-danger" role="alert">
    <?= session()->get('error') ?>
</div>
<?php endif; ?>
<?= $this->endSection('page-content'); ?>