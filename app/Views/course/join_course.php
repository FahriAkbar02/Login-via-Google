<?= $this->extend('all-temp/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container">
    <div class="row">
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('success') ?>
            </div>
        <?php elseif (session()->has('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->get('error') ?>
            </div>
        <?php endif; ?>

        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2> Join Course</h2>
                </div>
                <div class="card-body">
                    <form action="/course/join_course/" method="post">

                        <div class="form-group">
                            <label for="code">Masukan Course Code:</label>
                            <input type="text" class="form-control" id="tautan" name="tautan" placeholder="Enter code">
                        </div>
                        <button type="submit" class="btn btn-primary">Join</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('page-content'); ?>