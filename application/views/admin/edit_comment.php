<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Edit Comment</h2>
                    <form method="post">
                    <div class="mb-3">
                        <label for="new_comment" class="form-label">Edit This Comment:</label>
                        <input type="text" name="new_comment" value="<?php echo $comment['comment'] ?>" class="form-control">
                        <button type="submit" class="btn btn-primary px-4 mt-3">Save</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
