<div class="container mt-5">
    <h1 class="text-center mb-4">Welcome <?php echo htmlspecialchars($username); ?>!</h1>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-info text-center"><?php echo $message; ?></div>
    <?php } ?>

    <?php if (!empty($user_info)) { ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Failed Attempts</th>
                        <th>Last Password Reset</th>
                        <th>IP Address</th>
                        <th>Browser Details</th>
                        <th>Login Status</th>
                        <th>Login Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_info as $user) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['failed_attempts']; ?></td>
                        <td><?php echo $user['last_password_reset']; ?></td>
                        <td><?php echo $user['ip_address']; ?></td>
                        <td><?php echo $user['browser_details']; ?></td>
                        <td><?php echo $user['status']; ?></td>
                        <td><?php echo $user['login_time']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="text-center text-muted">No user data found.</p>
    <?php } ?>

    <div class="text-center mt-2 mb-4" >
        <?php if ($this->session->userdata('permission_level') <= 3) { ?>
            <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-primary me-2">Manage Users</a>
            <a href="<?php echo site_url('admin/view_tickets'); ?>" class="btn btn-primary me-2">View Tickets</a>
        <?php } ?>

        <?php if ($this->session->userdata('permission_level') <= 2) { ?>
            <a href="<?php echo site_url('admin/create_ticket'); ?>" class="btn btn-success mt-2">Create Ticket</a>
        <?php } ?>

        <a href="<?php echo site_url('change_password/change_password'); ?>" class="btn btn-primary me-2">Change Password</a>
        <a href="<?php echo site_url('logout/logout'); ?>" class="btn btn-secondary">Logout</a>
        
    </div>