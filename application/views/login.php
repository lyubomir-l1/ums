
<div class="row justify-content-center">
    <div class="col-md-6">
    <h1 class="text-center">Login and Enjoy</h1>
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Login</h2>

                <form action="<?php echo site_url('login/login_user'); ?>" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me">
                        <label for="remember_me" class="form-check-label">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?php echo site_url('reset_password/forgot_password'); ?>" class="text-decoration-none">Forgot Password?</a>
                    <p>If you are not registered. Please Register <a href="<?php echo site_url('register'); ?>">Here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function(){
        const passField = document.getElementById('password');
        const type = passField.getAttribute('type') === 'password' ? 'text' : 'password';
        passField.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Show' : 'Hide';
    });
</script>