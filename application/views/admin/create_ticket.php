<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h2 class="text-center mb-4">Ticket Form</h2>
                <form action="<?php echo site_url('admin/create_ticket'); ?>" method="post">
                <div class="mb-3">
                    <label for="ticket_title" class="form-label">Ticket Title:</label>
                    <input type="text" name="ticket_title" id="ticket_title" class="form-control" required> <br><br>
                    <label for="ticket_description" class="form-label">Ticket Description:</label>
                    <input type="text" name="ticket_description" id="ticket_description" class="form-control" required> <br><br>
                    <label for="ticket_status" class="form-label">Ticket Status:</label>
                    <select name="ticket_status" id="ticket_status" class="form-select">
                        <option value="high_priority">High Priority</option>
                        <option value="medium_priority">Medium Priority</option>
                        <option value="low_priority" selected="selected">Low Priority</option>
                    </select><br><br>
                    <label for="ticket_person" class="form-label">Responsible:</label>
                    <select name="ticket_person" id="ticket_person" class="form-select">
                    <?php if (!empty($users)){ ?>
                        <?php foreach($users as $user){?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                        <?php }?>
                    <?php }?>
                    </select><br><br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success px-4 mt-3">Create ticket</button>
                    </div>
                </div>
                </form>
                <br>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-4">
            <a href="<?php echo site_url('dashboard'); ?>"><button class="btn btn-primary px-4 mt-3">Back to Dashboard</button></a>
        </div>
    </div>
</div>
