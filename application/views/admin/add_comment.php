
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mt-5">
            <div class="card-body">
            <h2 class="text-center mb-4">Add Comment Here</h2>
                <form action="<?php echo site_url('admin/add_comment/' . $ticket_id); ?>" method="post">
                <div class="mb-3">
                    <input type="hidden" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>">    
                    <input type="hidden" id="comment_creator_id" name="comment_creator_id" value="<?php echo $comment_creator_id; ?>">    
                    <label for="comment" class="form-label">Comment:</label><br>
                    <textarea name="comment" id="comment" class="form-control"></textarea><br>
                    <button type="submit" class="btn btn-primary px-4 mt-3">Add comment</button>
                </div>
                </form>
                <br>
                <a href="<?php echo site_url('admin/view_tickets'); ?>"><button>Go back</button></a>
            </div>
        </div>
    </div>
</div>
