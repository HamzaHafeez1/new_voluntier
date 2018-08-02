<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix modal-share-px">
            <div>


                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Share your MyVolun<strong class="green">tier</strong> Profile</h2>
                            <!--<h3 class="h3">You can share your profile via email!</h3>-->
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body hide-email-comment">

                        <div class="form-group">
                            <label class="label-text">Emails:</label>
                            <div class="wrapper_input wrap_input_email">
                                <textarea id="share_emails" placeholder="Add email addresses, please separate emails by a comma"></textarea>
                            </div>
                            <div class="text-error" style="display: none">
                                Invalid Email Address
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Comments:</label>
                            <div class="wrapper_input ">
                                <textarea id="comments" placeholder="You can enter comments here"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="modal-body" style="display:block;">



                        <div class="success-first" style="display: none">
                            <h3>You shared your profile successfully!</h3>
                        </div>

                        <div class="wrapper-link top-50">
                            <a id="share_profile" href="#"><span>Share</span></a>
                            <a style="display: none" id="close_share_profile_hide" href="#"><span>Close</span></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>