
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Edit Ticket Description</h2>
                <form method="post">
                <div class="mb-3">
                    <label for="new_ticket_description" class="form-label">New Description:</label>
                    <input type="text" name="new_ticket_description" class="form-control" value="<?php echo $ticket_description; ?>" required>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-4 mt-3">Save</button>
                    </div>
                </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
