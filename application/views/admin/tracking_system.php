<div class="container mt-5 d-flex">
    
    <div class="user-list" style="width: 30%;">
        <h3>User List</h3>
        <input type="text" id="search" placeholder="Search for User">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody id="userList">
                    <?php foreach ($users as $user) { ?>
                    <tr class="selected_User">
                        <td class="single_User" data-id="<?= $user['id']; ?>"><?php echo $user['username']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
    
        <div class="actions" style="width: 70%;">
            <h3>Actions</h3>
            <p class="loading" style="display: none; color: red;">Loading...</p>
            <ol id="actionList"></ol>
        </div>
</div>

    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-primary me-2">Back</a>
        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary">Dashboard</a>
    </div>

<script>
    $(document).ready(function(){
        $('#search').on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $("#userList tr").filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            })
        })

        $(".single_User").on("click", function () {
            if ($(this).hasClass("ajax_loading")) return;
            let userId = $(this).data("id");
            $(".single_User").addClass("ajax_loading");

            $(".single_User").removeClass("selected");
            $(this).addClass("selected");

            $(".loading").show();
            $("#actionList").empty();

            setTimeout(function () {

                $.ajax({
                    url: "<?= site_url('tracker/display_user_actions/'); ?>" + userId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $(".loading").hide();
                        $(".single_User").removeClass("ajax_loading");
                        if (data.length === 0) {
                            $("#actionList").html("<li>No actions from this user.</li>");
                        } else {
                            // $.each(data, function (index, action) {
                            //     $("#actionList")
                            //     .append("<li>" + action.id + " , " + action.action_type + " , " + action.old_value + " , " + action.new_value + " , " + action.created_at + "</li>");
                            // });
                            let items = $.map(data, function(action) {
                                return `<li>${action.id}, ${action.action_type}, ${action.old_value}, ${action.new_value}, ${action.created_at}</li>`;
                            });
                            $("#actionList").append(items);
                        }
                    }
                });
            }, 500);
        });

    })
</script>
<style>
    .selected {
        background-color: lightblue !important;
    }
    td {
        cursor: pointer;
    }
</style>