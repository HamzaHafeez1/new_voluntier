<div class="modal fade" id="myModalSingVolRegistration" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <label class="label-text">User Name:</label>
                            <div class="wrapper_input">
                                <input id="v_user_name" type="text" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label class="label-text ">First Name:</label>
                                    <div class="wrapper_input">
                                        <input id="first_name" type="text" value="" placeholder="">
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Last Name:</label>
                                        <div class="wrapper_input">
                                            <input id="last_name" type="text" value="" placeholder="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label class="label-text">Gender:</label>


                                    <div class="row">
                                        <div class="col-12 col-md-6">

                                            <div class="wrapper-checkbox"><label>
                                                    <input type="radio" name="gender" checked>
                                                    <i class="gender"></i>
                                                    <span  class="label-checkbox-text gender">Male</span>
                                                </label></div>

                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="wrapper-checkbox"><label>
                                                    <input type="radio"  name="gender">
                                                    <i  class="gender"></i>
                                                    <span class="label-checkbox-text gender">Female</span>
                                                </label></div>

                                        </div>
                                    </div>
                                    <input class="gender-radio" type="hidden" value="male">


                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Zip Code:</label>
                                        <div class="wrapper_input">
                                            <input id="v_zipcode" type="text" value="" placeholder="">
                                            <p class="p_invalid" id="v_invalid_zipcode_alert">Invalid Zip Code. Please enter again</p>
                                            <p class="p_invalid" id="v_location_zipcode_alert">We can't get location from this zip code!</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="form-group">

                            <label class="label-text">Birthdate:</label>
                            <div class="wrapper_input fa-icons">
                                <input class="birth_day" id="birth_day" type="text" value="" placeholder="">
                                <span class="focus-border"></span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                            <p class="p_invalid" id="v_invalid_age">Age should be greater then or equal to 13</p>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label class="label-text">Email:</label>
                                    <div class="wrapper_input">
                                        <input id="v_email" type="text" value="" placeholder="">
                                        <p class="p_invalid" id="v_invalid_email_alert">Invalid Email Address</p>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Contact Number:</label>
                                        <div class="wrapper_input">
                                            <input id="v_contact_num" type="text" value="" placeholder="">
                                            <p class="p_invalid" id="v_invalid_contact_number">Invalid Contact Number</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label class="label-text">Password:</label>
                                    <div class="wrapper_input">
                                        <input id="v_password" type="password" value="" placeholder="">
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Confirm Password:</label>
                                        <div class="wrapper_input">
                                            <input id="v_confirm" type="password" value="" placeholder="">
                                            <p class="p_invalid" id="v_invalid_password">Please enter more than 6 letters</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <div class="form-group">

                            <div class="wrapper-checkbox"><label>
                                    <input  type="checkbox" id="verify_aga">
                                    <i class="years-old-check"></i>
                                    <span class="label-checkbox-text years-old-check">I am older than 13 years old</span>
                                    <input class="years-old-check-value" type="hidden" value="0">
                                </label>
                                <p class="p_invalid" id="verify_age_alert" style="display: none;">Please verify your age</p>
                            </div>

                            <div class="wrapper-checkbox"><label  data-check="0">
                                    <input id="v_accept_terms" type="checkbox">
                                    <i class="terms-conditions-vol"></i>
                                    <span  class="label-checkbox-text terms-conditions-vol">I accept the <a data-type="vol" class="termsAndConditions" href="#">Terms and Conditions</a></span>
                                    <input  class="terms-conditions-vol-value" type="hidden" value="0">
                                </label>
                                <p class="p_invalid" id="v_terms_alert" style="display:none;">You need accept our terms and conditions to register</p>
                            </div>

                        </div>




                    </div>
                    @include('components.non-auth.modal_footer_from_registration_form')
                </div>

            </div>
        </div>
    </div>
</div>