<div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix">
            <div>


                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Sign Up</h2>
                            <h3 class="h3">Welcome to MyVolun<strong class="green">tier</strong>!</h3>
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="label-text">Email:</label>
                            <div class="wrapper_input">
                                <input  id="login_user" type="text" placeholder="" value="">
                            </div>
                            <div class="text-error"></div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Password:</label>
                            <div class="wrapper_input">
                                <input id="login_password" type="password" placeholder="" value="">
                                <p class="p_invalid" id="password_not_match">Invalid Username or password. Please enter again.</p>
                                <p class="p_invalid" id="confirm_not_match">Please confirm your account before login.</p>
                            </div>
                            <div class="text-error"></div>
                        </div>


                    </div>
                    <div class="modal-footer">

                        <div class="main-text">
                            <p class="text-right" id="forPass"><a href="#">Forgot Password</a></p>
                        </div>

                        <div class="wrapper-link two-link">
                            <a href="#" class="white registration_button_on_modal_form"><span>Sign UP</span></a>
                            <a id="btn_login_l" href="#"><span>Log in</span></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>