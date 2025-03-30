<div class="container mt-5">
    <h1 class="text-center mb-4">
        Welcome <?php echo htmlspecialchars($username); ?>!
    </h1>
    <h2 class="text-center mb-4">Ticket System</h2>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-3">Tickets</h3>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Creator</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Responsible</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($tickets) {foreach ($tickets as $ticket) { ?>
                                <tr>
                                    <td><?php echo $ticket['id']; ?></td>
                                    <td><?php echo $ticket['creator_username']; ?></td>
                                    <td><a href="<?php echo site_url('admin/view_one_ticket/' . $ticket['id']); ?>"><?php echo $ticket['title']; ?></a></td>
                                    <td><?php echo $ticket['description']; ?></td>
                                    <td><?php echo $ticket['status']; ?></td>
                                    <td><?php echo $ticket['refered_username']; ?></td>
                                    <td><?php echo $ticket['created_at']; ?></td>
                                    <td>
                                        <!-- <a href="<?php echo site_url('admin/view_comments/' . $ticket['id']); ?>" 
                                            class="btn btn-primary btn-sm">View Comments</a>
                                        <a href="<?php echo site_url('admin/add_comment/' . $ticket['id']); ?>" 
                                            class="btn btn-primary btn-sm">Add Comment</a> -->

                                        <?php 
                                        $user_permission = $this->session->userdata('permission_level'); ?>

                                        <?php if ($user_permission == 1) { ?>
                                            <a href="<?php echo site_url('admin/delete_ticket/' . $ticket['id']); ?>" 
                                                class="btn btn-danger btn-sm mt-1">Delete</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } } else { ?>
                                <p>No Tickets Found!</p>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Back Button -->
                <div class="text-center mt-3">
                    <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
