<div class="container mt-5">
    <h2 class="text-center mb-4">View Comments</h2>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-3">Tickets</h3>

                <div class="table-responsive">
                    <?php if (!empty($comments)){ ?>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Comment ID</th>
                                <th>Ticket ID</th>
                                <th>Ticket Title</th>
                                <th>Creator</th>
                                <th>Creator ID</th>
                                <th>Comment</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php foreach ($comments as $comment){ ?>
                                <tr>
                                    <td><?php echo $comment['id']; ?></td>
                                    <td><?php echo $comment['ticket_id']; ?></td>
                                    <td><?php echo $comment['ticket_title']; ?></td>
                                    <td><?php echo $comment['creator_username']; ?></td>
                                    <td><?php echo $comment['comment_creator_id']; ?></td>
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

                <!-- Back Button -->
                <div class="text-center mt-3">
                    <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary">Back to Dashboard</a>
                    <a href="<?php echo site_url('admin/view_tickets'); ?>" class="btn btn-primary">Back to Tickets</a>
                </div>
            </div>
        </div>
    </div>
</div>

