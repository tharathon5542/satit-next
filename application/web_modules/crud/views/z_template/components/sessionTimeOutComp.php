        <div id="idle-timeout-dialog" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Your session is expiring soon</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <i class="fa fa-warning font-red"></i> You session will be locked in
                            <span id="idle-timeout-counter"></span> seconds.
                        </p>
                        <p> Do you want to continue your session? </p>
                    </div>
                    <div class="modal-footer text-center">
                        <button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-success text-white" data-bs-dismiss="modal">Yes, Keep Working</button>
                    </div>
                </div>
            </div>
        </div>