<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">User Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <?php if ($this->session->userdata('permission_level') <= 3) { ?>
          <li class="nav-item">
            <a class="nav-link btn btn-primary me-2 text-white" href="<?php echo site_url('admin/users'); ?>">Manage Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-primary me-2 text-white" href="<?php echo site_url('admin/view_tickets'); ?>">View Tickets</a>
          </li>
        <?php } ?>

        <?php if ($this->session->userdata('permission_level') <= 2) { ?>
          <li class="nav-item">
            <a class="nav-link btn btn-success me-2 text-white" href="<?php echo site_url('admin/create_ticket'); ?>">Create Ticket</a>
          </li>
        <?php } ?>

        <li class="nav-item">
          <a class="nav-link btn btn-primary me-2 text-white" href="<?php echo site_url('change_password/change_password'); ?>">Change Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-secondary text-white" href="<?php echo site_url('logout/logout'); ?>">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>