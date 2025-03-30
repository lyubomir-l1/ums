
<div class="row justify-content-center">
    <div class="col-md-6">
    <h1 class="text-center">Please Register Here</h1>
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Register</h2>
                
                <?php if(validation_errors()) echo '<div class="alert alert-danger">' . validation_errors() . '</div>'; ?>
                
                <form action="<?php echo site_url('register/register_user'); ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm password:</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?php echo site_url('login') ?>" class="btn btn-outline-secondary w-100">Go To Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
