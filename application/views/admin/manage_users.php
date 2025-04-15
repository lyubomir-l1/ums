<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Users</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td>
                        <?php 
                            $user_permission = $this->session->userdata('permission_level'); 
                            
                            if ($user_permission == 1 || $user_permission == 2){ ?>
                            <a href="<?php echo site_url('admin/change_password/' . $user['id']); ?>" class="btn btn-primary">Change Password</a>
                            <a href="<?php echo site_url('admin/change_email/' . $user['id']); ?>" class="btn btn-primary">Change Email</a>
                            <a href="<?php echo site_url('admin/ban_user/' . $user['id']); ?>" class="btn btn-danger">Ban User</a>
                        <?php } ?>

                        <?php if ($user_permission == 1){ ?>
                            <a href="<?php echo site_url('admin/remove_ban/' . $user['id']); ?>" class="btn btn-success">Remove Ban</a>
                            <a href="<?php echo site_url('admin/delete_user/' . $user['id']); ?>" class="btn btn-danger">Delete User</a>
                            <a href="<?php echo site_url('admin/change_user_permission_level/' . $user['id']); ?>" class="btn btn-secondary">Change Permission</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <?php if ($user_permission == 1){ ?>
        <a href="<?php echo site_url('tracker/display_users'); ?>" class="btn btn-primary">Tracking System</a>
        <?php } ?>
        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary">Back to Dashboard</a>
    </div>