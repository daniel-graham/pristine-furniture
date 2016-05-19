<div class="modal fade" id="pasModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel panel-success title">
                <div class="panel-heading modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="panel-title modal-title">Change Password</h3>
                </div>

                <div class="panel-body modal-body">
                    <form ng-submit="changePassword(user)">
                        <input type="email" ng-model="user.email" placeholder="Email" class="form-control" required>
                        <br>
                        <input type="password" ng-model="user.oldPass" placeholder="Current Password" class="form-control" required>
                        <br>
                        <input type="password" ng-model="user.newPass" placeholder="New Password" class="form-control" required>
                        <br>
                        <input type="submit" value="Update" class="btn btn-warning">
                    </form>
                </div>
                <div class="modal-footer">
<!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>
            </div>
        </div>
    </div>
</div>