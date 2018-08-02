@if($profile_info['is_volunteer'] === 0)
    <form id="update_account_oug">
        {{csrf_field()}}
    <div class="main-text">

        <p class="title">Account Info</p>


        <label class="label-text">Organization Name:</label>
        <div class="wrapper_input">
            <input name="org_name" id="org_name" type="text" value="{{Auth::user()->org_name}}" placeholder="">
        </div>

        <div class="row">
            <div class="col-12 col-md-6">

                <label class="label-text">Organization ID:</label>
                <div class="wrapper_input">
                    <input type="text" name="user_id" id="user_id" value="{{Auth::user()->user_name}}" placeholder="">
                </div>

            </div>
            <div class="col-12 col-md-6">

                <label class="label-text">Organization Type:</label>
                <div class="wrapper_input">
                    <select name="org_type" class="form-control" id="org_type">
                        @foreach($org_type_names as $org_name)
                            <option <?php if($org_name->id == Auth::user()->org_type){ ?> selected
                                    <?php }?> value="{{$org_name->id}}">{{$org_name->organization_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-md-6">

                <label class="label-text">Email:</label>
                <div class="wrapper_input">
                    <input name="email" id="email" type="text" value="{{Auth::user()->email}}" placeholder="">
                </div>

            </div>
            <div class="col-12 col-md-6">

                <label class="label-text">Website URL:</label>
                <div class="wrapper_input">
                    <input name="website" id="website" type="text" value="{{Auth::user()->website}}" placeholder="">
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">

                <label class="label-text">Founded Day:</label>
                <div class="wrapper_input fa-icons">
                    <input name="birth_day" id="birth_day" type="text" value="{{Auth::user()->birth_date}}"
                           placeholder="">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </div>

            </div>
            <div class="col-12 col-md-6">

                <label class="label-text">Address:</label>
                <div class="wrapper_input">
                    <input name="address" id="address" type="text" value="{{Auth::user()->location}}" placeholder="">
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">

                <label class="label-text">Zip Code:</label>
                <div class="wrapper_input">
                    <input name="zipcode" id="zipcode" type="text" value="{{Auth::user()->zipcode}}" placeholder="">
                </div>

            </div>
            <div class="col-12 col-md-6">

                <label class="label-text">Contact Number:</label>
                <div class="wrapper_input">
                    <input name="contact_num" id="contact_num" type="text" value="{{Auth::user()->contact_number}}"
                           placeholder="">
                </div>

            </div>
        </div>

        <label class="label-text">Facebook URL:</label>
        <div class="wrapper_input">
            <input name="facebook_url" id="facebook_url" type="text" value="{{Auth::user()->facebook_url}}"
                   placeholder="">
        </div>
        <label class="label-text">Twitter URL:</label>
        <div class="wrapper_input">
            <input name="twitter_url" id="twitter_url" type="text" value="{{Auth::user()->twitter_url}}" placeholder="">
        </div>
        <label class="label-text">LinkedIn URL:</label>
        <div class="wrapper_input">
            <input name="linkedin_url" id="linkedin_url" type="text" value="{{Auth::user()->linkedin_url}}"
                   placeholder="">
        </div>


        <div class="row">
            <div class="col-12 col-md-6">

                <label class="label-text">New Password:</label>
                <div class="wrapper_input">
                    <input name="new_password" id="new_password" type="password" value="" placeholder="">
                </div>

            </div>
            <div class="col-12 col-md-6">

                <label class="label-text">Confirm Password:</label>
                <div class="wrapper_input">
                    <input name="confirm_password" id="confirm_password" type="password" value="" placeholder="">
                </div>

            </div>
        </div>


        <label class="label-text">Summary:</label>
        <div id="editor">

               {!! Auth::user()->brif !!}

        </div>

        <input id="orgSum" name="org_summary" value='' type="hidden">

        <div class="wrapper-link"><a id="submit-update-account" href="#"><span>Save Change</span></a></div>


    </div>
    </form>
@elseif($profile_info['is_volunteer'] === 1)
    <form id="update_account" method="post" action="">
    <div class="row">
        <div class="col-12 order-0 col-md-8 order-md-0">
            <div class="main-text">

                <p class="title">My Account Information</p>

                <div class="row">
                    <div class="col-12 col-md-6 ">
                        <label class="label-text">First Name:</label>
                        <div class="wrapper_input">
                            <input disabled name="user_id" id="first_name" type="text" value="{{Auth::user()->first_name}}" placeholder="">
                        </div>

                    </div>
                    <div class="col-12 col-md-6 ">
                        <label class="label-text">Last Name:</label>
                        <div class="wrapper_input">
                            <input disabled name="user_id" id="last_name" type="text" value="{{Auth::user()->last_name}}" placeholder="">
                        </div>

                
                        @if(Auth::user()->approval != 'PENDING')
                    
                        <div  class="wrapper-link">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                <span><b>Request for change name</b></span>
                            </button>
                        </div>
                        @endif

                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-6">

                        <label class="label-text">User Name:</label>
                        <div class="wrapper_input">
                            <input name="user_id" id="user_id" type="text" value="{{Auth::user()->user_name}}"
                                   placeholder="">
                        </div>

                    </div>
                    <div class="col-12 col-md-6">

                        <label class="label-text">Email:</label>
                        <div class="wrapper_input">
                            <input name="email" id="email" type="text" value="{{Auth::user()->email}}" placeholder="">
                        </div>


                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">

                        <label class="label-text">Birthdate:</label>
                        <div class="wrapper_input fa-icons">
                            <input name="birth_day" id="birth_day" type="text" value="{{Auth::user()->birth_date}}"
                                   placeholder="">
                            <span class="focus-border"></span>
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>

                    </div>
                    <div class="col-12 col-md-6">

                        <label class="label-text">Gender:</label>
                        <div class="row">
                            <?php if(Auth::user()->gender == 'male') {?>

                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input value="male" type="radio" name="gender" checked>
                                        <i></i>
                                        <span class="label-checkbox-text">Male</span>
                                    </label></div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input value="female" type="radio" name="gender">
                                        <i></i>
                                        <span class="label-checkbox-text">Female</span>
                                    </label></div>

                            </div>

                            <?php }else{?>

                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input value="male" type="radio" name="gender">
                                        <i></i>
                                        <span class="label-checkbox-text">Male</span>
                                    </label></div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input value="female" type="radio" name="gender" checked>
                                        <i></i>
                                        <span class="label-checkbox-text">Female</span>
                                    </label></div>

                            </div>

                            <?php }?>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-6">

                        <label class="label-text">Show Address:</label>
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input type="radio"
                                               <?php echo (Auth::user()->show_address == 'Y') ? 'checked' : '';?> value="Y"
                                               id="optionsRadios1" name="show_address">
                                        <i></i>
                                        <span class="label-checkbox-text">Yes</span>
                                    </label></div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input type="radio"
                                               <?php echo (Auth::user()->show_address == 'N') ? 'checked' : '';?> value="N"
                                               id="optionsRadios2" name="show_address">
                                        <i></i>
                                        <span class="label-checkbox-text">No</span>
                                    </label></div>

                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-6">

                        <label class="label-text">Show Birthdate:</label>
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input type="radio"
                                               <?php echo (Auth::user()->show_age == 'Y') ? 'checked' : '';?> value="Y"
                                               id="optionsRadios3" name="show_age">
                                        <i></i>
                                        <span class="label-checkbox-text">Show Age</span>
                                    </label></div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="wrapper-checkbox"><label>
                                        <input type="radio"
                                               <?php echo (Auth::user()->show_age == 'N') ? 'checked' : '';?> value="N"
                                               id="optionsRadios4" name="show_age">
                                        <i></i>
                                        <span class="label-checkbox-text">Show Birthdate</span>
                                    </label></div>

                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-6">

                        <label class="label-text">Zip Code:</label>
                        <div class="wrapper_input">
                            <input name="zipcode" id="zipcode" type="text" value="{{Auth::user()->zipcode}}"
                                   placeholder="">
                        </div>

                    </div>
                    <div class="col-12 col-md-6">

                        <label class="label-text">Contact Number:</label>
                        <div class="wrapper_input">
                            <input name="contact_num" id="contact_num" type="text"
                                   value="{{Auth::user()->contact_number}}" placeholder="">
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="label-text">New Password:</label>
                        <div class="wrapper_input">
                            <input name="new_password" id="new_password" type="password" value="" placeholder="">
                        </div>

                    </div>
                    <div class="col-12 col-md-6">
                        <label class="label-text">Confirm Password:</label>
                        <div class="wrapper_input">
                            <input type="password" name="confirm_password" id="confirm_password" value="" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- -->
        </div>

    

        <input name="my_summary" class="my_summary_acount" type="hidden">
        <div class="col-12 order-1 col-md-12 order-md-2">

            <div class="main-text">

                <label class="label-text">Summary:</label>

                <textarea id="editor"  >
                    {{Auth::user()->brif}}
                </textarea>
                <span class="alert alert-success in alert-dismissable resultupdatemsg" style="display: none;">Your account is successfully updated!</span>
                <div  class="wrapper-link"><a id="btn_save" href="#"><span>Save Change</span></a></div>

            </div>

        </div>
    </div>
    </form>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Change name request</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form method="post" action="{{url('/store')}}" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="label-text">First Name:</label>
                                <div class="wrapper_input">
                                    <input  name="first_name1" id="first_name1" type="text" value="{{Auth::user()->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="label-text">Last Name:</label>
                                <div class="wrapper_input">
                                    <input name="last_name1" id="last_name1" type="text" value="{{Auth::user()->last_name}}" required>
                                </div>
                            </div>
                        </div>
                        <label for="proof">Proof of Identity:</label>
                        <div class="wrapper_input">
                            <input type="file" name="image" id="image" required>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <small>Please upload a copy of your valid ID or driver license in PNG or JPEG</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="float:right;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="float:right;">Close</button><br>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endif