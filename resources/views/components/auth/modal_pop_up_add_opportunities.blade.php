<div class="modal fade" id="add_opportunity"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix">
            <div>


                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Join to Opportunity</h2>
                            <h3 class="h3">You can join to Opportunity to add hours here!</h3>
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="label-text">Organization:</label>
                            <div class="wrapper_select">
                                <select class="custom-dropdown" id="org_name">
                                    <option>Select an Organization</option>
                                    @foreach($org_name as $o_name)
                                        <option value="{{$o_name->id}}">{{$o_name->org_name}}</option>
                                    @endforeach
                                </select>
                                <p class="p_invalid" id="invalid_org_name_alert" style="display: none">Please select Organization.</p>
                            </div>
                        </div>




                        <div class="form-group opp_div" style="display: none">
                            <label class="label-text">Opportunity:</label>
                                <div class="wrapper_select">
                                    <select class="select_opportunity form-control custom-dropdown" id="opp_name" style="height: 34px;">
                                        <option></option>
                                    </select>
                                    <p class="p_invalid" id="opportunity_exist_alert" style="display: none">You have joined to Opportunity already!</p>
                                    <p class="p_invalid" id="invalid_opp_name_alert" style="display: none">Please select Opportunity.</p>
                                    <div class="form-group div_opp_does" >
                                        <div class="wrapper-checkbox org_not_exist"><label>
                                                <input id="opp_not_exist" type="checkbox">
                                                <i></i>
                                                <span class="label-checkbox-text">Opportunity does not exist</span>
                                            </label>
                                        </div>
                                    </div>
                            </div>
                        </div>



                        <div class="form-group org_does_exist">
                            <div class="wrapper-checkbox org_not_exist"><label>
                                    <input id="checkbox_div" type="checkbox">
                                    <i></i>
                                    <span class="label-checkbox-text">Organization does not exist</span>
                                </label></div>
                        </div>










                        <div id="opp_wrapper_div" class="opp_private_div" style="display:none;">
                            <div class="form-group opp_private_div_l">
                                <label class="label-text">Private Opportunity Name:</label>
                                <input type="text" name="private_opp_name" id="private_opp_name" class="form-control" placeholder="Enter Private Opportunity Name Here"  autocomplete="off"/>
                                <p class="p_invalid" id="invalid_private_name_alert" style="display: none">Please enter Private Opportunity Name to add hours.</p>
                            </div>
                            {{--<div class="form-group" id="opp_date_div">--}}
                                {{--<label class="label-text">Opportunity End Date: </label>--}}
                                {{--<div class="input-group date wrapper_input fa-icons">--}}
                                    {{--<input  type="text" value="" placeholder="">--}}
                                    {{--<span class="input-group-addon wrapper_input">--}}
                                        {{--<i class="fa fa-calendar"></i>--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <p class="p_invalid" id="opportunity_exist_alert" style="display: none">You have joined to Opportunity already!</p>


                        </div>









                        <div id="wrapper_div" style="display:none;">

                            <div class="form-group org_email_div">
                                <label class="label-text">Organization Email:</label>
                                <div class="wrapper_input">
                                    <input  name="org_emails" id="org_emails" value="" placeholder="Enter Email Address to Share Your Profile">
                                    <p class="p_invalid" id="invalid_org_email_alert" style="display: none">Please enter Organization Email.</p>
                                </div>
                            </div>

                            <div class="form-group org_private_div">
                                <label class="label-text">Private Opportunity Name:</label>
                                <div class="wrapper_input">
                                    <input name="private_opp_name" id="private_org_name" value="" placeholder="Enter Private Opportunity Name Here">
                                </div>
                            </div>


                            <p class="p_invalid" id="opportunity_exist_alert" style="display: none">You have joined to Opportunity already!</p>
                        </div>

                        <div class="form-group"  id="opp_date_div">
                            <label class="label-text">Opportunity End Date:</label>
                            <div class="wrapper_input fa-icons">
                                <input id="end_date" type="text" value="" placeholder="">
                                <span class="focus-border"></span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">


                        <div class="wrapper_row_link">
                            <div class="row">
                                <div class="col-12">

                                    <div class="wrapper-link two-link">
                                        <a href="#" class="white close_button"><span>Close</span></a>
                                        <a id="btn_add_opp"  href="#"><span>Add Opportunity</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>





                    </div>
                </div>

            </div>
        </div>
    </div>
</div>