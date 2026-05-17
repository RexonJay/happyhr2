<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header">
                    <h4>Change Password</h4>
                </div>

                <div class="card-body">

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>

                            </ul>

                        </div>
                    <?php endif; ?>

                    <form method="post"
                          action="<?= site_url('accountcontroller/updatepassword') ?>">

                        <?= csrf_field(); ?>

                        <div class="mb-3">

                            <label>Current Password</label>

                            <input type="password"
                                   name="current_password"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>New Password</label>

                            <input type="password"
                                   name="new_password"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>Confirm Password</label>

                            <input type="password"
                                   name="confirm_password"
                                   class="form-control"
                                   required>

                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100">

                            Change Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>