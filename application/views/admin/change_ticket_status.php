
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mt-5">
            <div class="card-body">
                <h2 class="text-center mb-4">Change Status</h2>
                <form method="post">
                <div class="mb-3">
                    <label for="new_ticket_status" class="form-label">Ticket Status:</label>
                    <select name="new_ticket_status" id="new_ticket_status" class="form-select">
                        <option value="high_priority">High Priority</option>
                        <option value="medium_priority">Medium Priority</option>
                        <option value="low_priority" selected="selected">Low Priority</option>
                    </select><br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-4 mt-3">Save</button>
                    </div>
                </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
