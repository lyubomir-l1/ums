
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Delete Ticket</h2>
                <p class="text-center">Sure u want to delete the ticket?</p>
                    <form method="post">
                    <div class="mb-3">
                        <input type="hidden" name="confirm" value="1">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 mt-3">YES, Delete</button>
                        </div>
                    </div>
                    </form>
                    <div class="d-flex justify-content-center" >
                        <a href="<?php echo site_url('admin/view_tickets'); ?>">
                            <button class="btn btn-primary px-4 mt-3" >No, Go back</button>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</div>
