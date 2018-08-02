<div class="modal fade" id="myModalSingOrgRegistration" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <input name="o_user_name" id="o_user_name" class="form-control name-panel" type="text" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text org_name_label">Organization Name:</label>
                            <div class="wrapper_input">
                                <input name="org_name" id="org_name" class="form-control name-panel" type="text" value="" placeholder="">
                            </div>
                        </div>



                        <div class="form-group school_type" style="display: none">
                        <label class="label-text school_type_label">School Type:</label>
                        <div class="wrapper_select">
                            <select id="school_type" name="school_type">
                                @foreach($school_type as $s)
                                    <option value="{{$s->id}}">{{$s->school_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>


                        <div class="form-group ein_div" style="display: none">
                            <label class="label-text">EIN: </label>
                            <div class="wrapper_input">
                                <input type="text" name="org_ein" id="org_ein" class="form-control name-panel">
                            </div>
                        </div>





                        <div class="form-group org_type_div" style="display: none">
                            <label class="label-text">Organization Type:</label>
                            <div class="wrapper_input">
                                <input name="non_org_type" id="non_org_type" class="form-control name-panel" type="text" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label class="label-text">Date Founded:</label>
                                    <div class="wrapper_input fa-icons">
                                        <input name="found_day" id="found_day" class="form-control" type="text" value="" placeholder="">
                                        <span class="focus-border input-group-addon"></span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Zip Code:</label>
                                        <div class="wrapper_input">
                                            <input name="o_zipcode" id="o_zipcode" class="form-control name-panel" type="text" value="" placeholder="">
                                            <p class="p_invalid" id="o_invalid_zipcode_alert">Invalid Zip code. Please enter again</p>
                                            <p class="p_invalid" id="o_location_zipcode_alert">We can't get location from this zip code!</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label class="label-text">Email:</label>
                                    <div class="wrapper_input">
                                        <input name="o_email" id="o_email" class="form-control name-panel" type="text" value="" placeholder="">
                                        <p class="p_invalid" id="o_invalid_email_alert">Invalid Email Address.</p>
                                        <p class="p_invalid" id="o_existing_email_alert">Existing Email Address</p>
                                    </div>


                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Contact Number:</label>
                                        <div class="wrapper_input">
                                            <input name="o_contact_num" id="o_contact_num" class="form-control name-panel" type="text" value="" placeholder="">
                                            <p class="p_invalid" id="o_invalid_contact_number">Invalid Contact Number</p>
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
                                        <input name="o_password" id="o_password" class="form-control name-panel" type="password" value="" placeholder="">
                                        <p class="p_invalid" id="o_invalid_password">Enter more than 6 letters</p>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">

                                    <div class="margin-top">
                                        <label class="label-text">Confirm Password:</label>
                                        <div class="wrapper_input">
                                            <input name="o_confirm" id="o_confirm" class="form-control name-panel" type="password" value="" placeholder="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="wrapper-checkbox "><label>
                                    <input id="o_accept_terms" type="checkbox">
                                    <i class="terms-conditions-org"></i>
                                    <span class="label-checkbox-text terms-conditions-org">I accept the <a data-type="org" class="termsAndConditions" href="#">Terms and Conditions</a></span>
                                    <input class="terms-conditions-org-value" type="hidden" value="0">
                                </label></div>

                        </div>




                    </div>
                    @include('components.non-auth.modal_footer_from_registration_form')
                </div>

            </div>
        </div>
    </div>
</div>