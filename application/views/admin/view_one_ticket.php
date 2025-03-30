<div class="container mt-5">
    <h2 class="text-center mb-4">Ticket: <?php echo $ticket_info['title']; ?>!</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Ticket ID</th>
                        <th>Creator ID</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Refered User ID</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $ticket_info['id']; ?></td>
                        <td><?php echo $ticket_info['creator_id']; ?></td>
                        <td><?php echo $ticket_info['description']; ?></td>
                        <td><?php echo $ticket_info['status']; ?></td>
                        <td><?php echo $ticket_info['refered_user_id']; ?></td>
                        <td><?php echo $ticket_info['created_at']; ?></td>
                        <td>
                            <a href="<?php echo site_url('admin/add_comment/' . $ticket_info['id']); ?>" 
                                            class="btn btn-primary btn-sm">Add Comment</a>

                            <?php 
                            $user_permission = $this->session->userdata('permission_level'); 
                            if ($user_permission == 1 || $user_permission == 2) { ?>
                                <a href="<?php echo site_url('admin/change_ticket_status/' . $ticket_info['id']); ?>" 
                                    class="btn btn-primary btn-sm">Change Status</a>
                            <?php } ?>

                            <?php if ($user_permission == 1) { ?>
                                <a href="<?php echo site_url('admin/change_ticket_title/' . $ticket_info['id']); ?>" 
                                    class="btn btn-secondary btn-sm">Edit Title</a>
                                <a href="<?php echo site_url('admin/change_ticket_description/' . $ticket_info['id']); ?>" 
                                    class="btn btn-secondary btn-sm mt-1">Edit Description</a>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card-body">
                <h3 class="text-center mb-3">Comments</h3>
                <div class="table-responsive">
                        <?php if (!empty($comments)){ ?>
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Creator</th>
                                    <th>Comment</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <?php foreach ($comments as $comment){ ?>
                                    <tr>
                                        <td><?php echo $comment['creator_username']; ?></td>
                                        <td><?php echo $comment['comment']; ?></td>
                                        <td><?php echo $comment['created_at']; ?></td>
                                        <td>
                                    <?php 
                                    $user_id = $this->session->userdata('user_id');
                                    $permission = $this->session->userdata('permission_level');
                                        if($user_id == $comment['comment_creator_id'] || $permission < 3){ ?>
                                            <a href="<?php echo site_url('admin/edit_comment/' . $comment['id']); ?>"><button class="btn btn-primary px-4 mt-3">Edit comment</button></a>
                                        <?php } ?>
                                        <?php if($user_id == $comment['comment_creator_id'] || $permission < 2){ ?>
                                            <a href="<?php echo site_url('admin/delete_comment/' . $comment['id']); ?>"><button class="btn btn-danger px-4 mt-3">Delete comment</button></a>
                                        </td>
                                    </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    
                            </tbody>
                        </table>
                        <?php }else{ ?>
                        <p>No comments found.</p>
                        <?php } ?>
                        <br>
                    </div>
                </div>
        </div>

        <div class="text-center mt-3">
            <a href="<?php echo site_url('admin/view_tickets'); ?>" class="btn btn-primary">
                Back to Tickets
            </a>
        </div>