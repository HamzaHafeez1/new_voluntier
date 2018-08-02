<div class="modal fade" id="myModalOrgType" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <label class="label-text">Please Select Organization Type:</label>
                            <div class="wrapper_select">
                                <select name="org_type" id="org_type" class="custom-dropdown">
                                    @foreach($org_type_names as $org_name)
                                        <option value="{{$org_name->id}}">{{$org_name->organization_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-error">
                                This error occurs when the hard drive is (nearly) full. To fix this,
                                the user should close some programs (to free swap file usage) and
                                delete some files (normally temporary files, or other files after
                                they have been backed up), or get a bigger hard drive
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">

                        <div class="wrapper-link">
                            <a id="chooseTypeOrg" href="#"><span>Next</span></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
