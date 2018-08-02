<div class="modal fade" id="myModalForgotPassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix">
            <div>

                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Forgot Password?</h2>
                            <h3 class="h3">We will e-mail you a link to replace your password</h3>
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="label-text lab-email">Email:</label>
                            <div class="wrapper_input input-email">
                                <input id="get_password_email" type="text" placeholder="" value="">
                                <p class="p_invalid" id="forgot_password_invalid_email">Invalid Email Address. Email Address does not exist.</p>
                            </div>
                            <div class="col-md-12 reg-content forgot_password_success" style="display: none">
                                <p>We sent your Link via email. Please check your email!</p>
                            </div>
                            <div class="text-error"></div>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <div class="wrapper-link">
                            <a id="forgot_password" href="#"><span>Submit</span></a>
                            <a style="display: none" id="forgot_password_close" href="#"><span>Close</span></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>