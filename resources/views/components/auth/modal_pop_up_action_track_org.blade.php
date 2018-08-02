<div class="modal fade" id="myModalTrackedHours" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix">
            <div>


                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Process Tracked Hours</h2>
                            <h3 class="h3">Please approve hours, your volunteers logged!</h3>
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body">

                        <div class="form-group">


                            <div class="tracked_hours_box">

                                <table>
                                    <tr>
                                        <td><div class="avatar v-logo"></div></td>
                                        <td><div class="main-text"><p class="text-center"><i class="fa fa-long-arrow-right"></i></p></div></td>
                                        <td><div id="o-logo-modal" class="avatar o-logo"></div></td>
                                    </tr>
                                    </tr>
                                    <td><div class="main-text"><p class="v-name">Jacob Daviesp</p></div></td>
                                    <td><div class="main-text"><p class="red "><strong class="w-mins">30 mins</strong></p></div></td>
                                    <td><div class="main-text"><p class="o-name">Orphans Group</p></div></td>
                                </table>

                            </div>

                        </div>
                        <div class="form-group private-opp">
                            <p style="float: left; margin-top: 8px;">This is private opportunity volunteer has created to add hours: &nbsp;</p>
                            <a style="float: right" href="" class="wrapper-link opp-public ">Make Public</a>
                        </div>
                        <div class="form-group">

                            <div class="main-text">
                                <p class="mb-0"><strong>Worked Period:</strong></p>
                                <p class="worked-time">2018-02-16  08:30 to 09:00</p>

                                <p class="mb-0"><strong>Submitted Time:</strong></p>
                                <p class="submitted-time">2018-02-16 14:51:38</p>

                                <p class="mb-0"><strong>Comments From Volunteer</strong></p>
                                <p class="track-comment"></p>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="wrapper-checkbox"><label>
                                    <input id="checkbox_div" type="checkbox">
                                    <i></i>
                                    <span class="label-checkbox-text" id="allow_review">Give Review to Volunteer</span>
                                </label></div>
                        </div>

                        <div id="wrapper_div" style="display:none;">

                            <div class="form-group">
                                <label class="label-text">Review:</label>
                                <input id="input-rating" type="text" class="kv-fa rating-loading" value="4" data-size="xs" title="">
                            </div>

                            <div class="form-group">
                                <label class="label-text">Comments:</label>
                                <div class="wrapper_input">
                                    <textarea class="review-comment" placeholder=""></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <input type="hidden" id="track_id">
                    <div class="modal-footer">


                        <div class="wrapper_row_link">
                            <div class="row">
                                <div class="col-12">

                                    <div class="wrapper-link two-link">
                                        <a href="#" id="btn_decline" class="red"><span>Decline</span></a>
                                        <a href="#" id="btn_approve"><span>Approve</span></a>
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