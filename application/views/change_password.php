<div class="row justify-content-center">
    <div class="col-md-6">
    <h1 class="text-center">Change Own Password!</h1>
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Change Pass Here</h2>
                <form action="<?php echo site_url('change_password/update_password'); ?>" method="post">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control"><br><br>

                    <label for="new_password" class="form-label">New password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control"><br><br>

                    <label for="confirm_password" class="form-label">Confirm password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"> <br><br>
                    <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary px-4 mt-3">Change</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

