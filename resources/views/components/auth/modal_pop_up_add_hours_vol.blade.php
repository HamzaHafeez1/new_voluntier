<div class="modal fade" id="add_hours" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix">
            <div class="track-add-hour">
                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Add Hours</h2>
                            <h3 class="h3">Please select opportunity and add hours!</h3>
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body">

                        <div class="form-group  opp_select_div">
                            <label class="label-text">Opportunity:</label>
                            <div class="wrapper_select">
                                <select class="custom-dropdown add_select_opportunity" id="opp_id">
                                    <option>Select an opportunity</option>
                                    @foreach($oppr as $op)
                                        <option value="{{$op->id}}">{{$op->title}}</option>
                                    @endforeach
                                </select>
                                <p class="p_invalid" id="empty_opportunity_alert" style="display: none">Please Select Opportunity!</p>
                            </div>
                        </div>

                        <div style="display: none" class="form-group private_opp_div_add_hours">
                            <label class="label-text">Private Opportunity:</label>
                            <div class="wrapper_input">
                                <input  id="private_opp_name_hours" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="main-text"><p><strong>Opportunity does not exist?</strong> You can Join to new opportunity <a id="add_on_addtime" href="#">here</a>.</p></div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <label class="label-text">From:</label>
                                    <select class="custom-dropdown" id="start_time">
                                        <?php
                                        $start = "00:00";
                                        $end = "23:30";
                                        $tStart = strtotime($start);
                                        $tEnd = strtotime($end);
                                        $tNow = $tStart;

                                        while($tNow <= $tEnd){
                                        $time = date("g:ia",$tNow);
                                        $val = date("H:i",$tNow)
                                        ?>
                                        <option value="{{$val}}">{{$time}}</option>
                                        <?php    $tNow = strtotime('+30 minutes',$tNow);
                                        }?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-5">

                                    <div class="margin-top">
                                        <label class="label-text">To:</label>
                                        <select class="custom-dropdown" id="end_time">
                                            <?php
                                            $start = "00:00";
                                            $end = "23:30";
                                            $tStart = strtotime($start);
                                            $tEnd = strtotime($end);
                                            $tNow = $tStart;

                                            while($tNow <= $tEnd){
                                            $time = date("g:ia",$tNow);
                                            $val = date("H:i",$tNow)
                                            ?>
                                            <option value="{{$val}}">{{$time}}</option>
                                            <?php    $tNow = strtotime('+30 minutes',$tNow);
                                            }?>
                                        </select>
                                    </div>


                                </div>
                                <div class="col-12 col-lg-2 align-self-center">

                                    <div class="margin-top">
                                        <div class="form-group main-text"><p id="hours_mins" class="mt-15">(60mins)</p></div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Comments:</label>
                            <div class="wrapper_input">
                                <textarea name="adding_hours_comments" id="adding_hours_comments" placeholder=""></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="wrapper_row_link">
                            <div class="row">
                                <div class="col-12">

                                    <div class="wrapper-link two-link">
                                        <a style="display: none" href="#" id="btn_remove_hours"><span>Remove</span></a>
                                        <a href="#" class="white close_button"><span>Close</span></a>
                                        <a id="btn_add_hours" href="#"><span>Save</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="selected_date">
                <input type="hidden" id="is_edit" value="0">
                <input type="hidden" id="track_id" value="0">
                <input type="hidden" id="is_from_addhour" value="0">
                <input type="hidden" id="is_no_org" value="0">
                <input type="hidden" id="is_link_exist" value="0">
            </div>
        </div>
    </div>
</div>