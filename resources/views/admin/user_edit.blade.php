@if($usermodel->user_role == "organization")

<form id="frmUsers" name="frmUsers" class="form-horizontal" method="post" novalidate="" action="{{url('admin/editPost')}}" enctype="multipart/form-data">

    <div class="row">



        <div class="col-sm-6">

            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Organization ID</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" value="{{$usermodel->user_name}}">

                </div>

            </div>

            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Organization Name</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="org_name" name="org_name" placeholder="Organization Name" value="{{$usermodel->org_name}}">

                </div>

            </div>



            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Organization Type</label>

                <div class="col-sm-9">

                    <select class="form-control" id="org_type" name="org_type">

                     @if(!empty($organizationType))  

                     @foreach($organizationType as $name =>$id)

                     <option value="{{$id}}" @if(isset($usermodel->org_type) && ($id == $usermodel->org_type ) ) selected @endif >{{$name}}</option>

                     @endforeach

                     @endif

                 </select>

                 <input type="text" @if($usermodel->org_type!=2) style="display:none; margin-top: 10px;" @endif  class="form-control" id="nonprofit_org_type" name="nonprofit_org_type" placeholder="Non profit org type" value="{{$usermodel->nonprofit_org_type}}">

             </div>

            </div>



            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">EIN</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="ein" name="ein" placeholder="EIN" value="{{$usermodel->ein}}">

                </div>

            </div>

            



         <div class="form-group">

            <label for="inputEmail3" class="col-sm-3 control-label">School Type</label>

            <div class="col-sm-9">

                <select class="form-control" id="school_type" name="school_type">

                    @if(!empty($School_type))

                    @foreach($School_type as $name => $id)

                    <option value="{{$id}}"  @if(isset($usermodel->school_type) && ($id == $usermodel->school_type ) ) selected @endif >{{$name}}</option>

                    @endforeach

                    @endif

                </select>

            </div>

        </div>



        <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>

                <div class="col-sm-9">

                    <label class="form-control" style="border: none;">{{$usermodel->email}}</label>

                </div>

            </div>



        <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Date Founded</label>

                 <div class="col-sm-9">

                    <input type="text" class="form-control birth_date" id="birth_date" name="birth_date" placeholder="YYYY-MM-DD" value="{{$usermodel->birth_date}}">

                 </div>

            </div>



        <div class="form-group">

            <label for="inputEmail3" class="col-sm-3 control-label">Contact number</label>

            <div class="col-sm-9">

                <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact" value="{{$usermodel->contact_number}}">

            </div>

        </div>

        <div class="form-group">

            <label for="inputEmail3" class="col-sm-3 control-label">Address</label>

            <div class="col-sm-9">

                <input type="text" class="form-control" id="contact_number" name="location" placeholder="Address" value="{{$usermodel->location}}">

            </div>

        </div>

        <div class="form-group">

            <label for="inputEmail3" class="col-sm-3 control-label">Zipcode</label>

            <div class="col-sm-9">

                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="zipcode" value="{{$usermodel->zipcode}}">

            </div>

        </div>



        

        <!-- <div class="form-group">

            <div class="col-sm-12 col-sm-offset-3">

                <label class="btn btn-primary">Browse                   

                    <input type="file" id="logo_img" name="logo_img" style="display: none;">                   

                </label>

            </div>

        </div> -->

</div>





<div class="col-sm-6 text-left">

    <div class="form-group">

        <label for="inputEmail3" class="col-sm-12 control-label">Account Type:  {{$usermodel->user_role}}</label> 

            @if(!empty($usermodel->logo_img))

                <!-- <img src="{{public_path('/img/user/thumbnail/'.$usermodel->logo_img)}}">     -->

            @endif              

    </div>

    <div class="form-group">

        <label for="inputEmail3" class="col-sm-3 control-label">Website url</label>

        <div class="col-sm-9">

            <input type="text" class="form-control" id="contact_number" name="website" placeholder="Website url" value="{{$usermodel->website}}">

        </div>

    </div>

    <div class="form-group">

        <label for="inputEmail3" class="col-sm-3 control-label">Facebook URL</label>

        <div class="col-sm-9">

            <input type="text" class="form-control" id="contact_number" name="facebook_url" placeholder="Facebook URL" value="{{$usermodel->facebook_url}}">

        </div>

    </div>

    <div class="form-group">

        <label for="inputEmail3" class="col-sm-3 control-label">Twitter URL</label>

        <div class="col-sm-9">

            <input type="text" class="form-control" id="contact_number" name="twitter_url" placeholder="Twitter URL" value="{{$usermodel->twitter_url}}">

        </div>

    </div>

    <div class="form-group">

        <label for="inputEmail3" class="col-sm-3 control-label">LinkedIn URL</label>

        <div class="col-sm-9">

            <input type="text" class="form-control" id="contact_number" name="linkedin_url" placeholder="LinkedIn URL" value="{{$usermodel->linkedin_url}}">

        </div>

    </div>


    <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
    <div class="form-group">

        <label for="inputEmail3" class="col-sm-12 control-label">My summary</label>

        <div class="col-sm-12">

          <textarea name="brif" id="brif" class="form-control"  rows="10">{{$usermodel->brif}}</textarea>
            <script>
                CKEDITOR.replace( 'brif' );
            </script>
      </div>

  </div>







  <div class="form-group">

    <div class="col-sm-12 text-right">

        <input type="hidden" id="edit_user_id" name="edit_user_id" value="{{$usermodel->id}}">

        <input type="hidden" id="edit_user_role" name="edit_user_role" value="{{$usermodel->user_role}}">

        <input type="submit" class="btn btn-primary btn-success" id="org_save" name="org_save" value="Save changes">

    </div>

</div>



</div>

</div>

{!! csrf_field() !!}

</form>

@else



<form id="frmUsers" name="frmUsers" class="form-horizontal" method="post" novalidate="" action="{{url('admin/editPost')}}" enctype="multipart/form-data">

    <div class="row">



        <div class="col-sm-6">

            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">User Name</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" value="{{$usermodel->user_name}}">

                </div>

            </div>

            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{$usermodel->first_name}}">

                </div>

            </div>



            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{$usermodel->last_name}}">

                </div>

            </div>

            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>

                <div class="col-sm-9">

                    <label class="form-control" style="border: none;">{{$usermodel->email}}</label>

                </div>

            </div>



            <div class="form-group">

                <label for="inputEmail3" class="col-sm-3 control-label">Brithdate</label>

                 <div class="col-sm-9">

                    <input type="text" class="form-control birth_date" id="birth_date" name="birth_date" placeholder="YYYY-MM-DD" value="{{$usermodel->birth_date}}">

                 </div>

            </div>



       



        <div class="form-group">               

            <label for="inputEmail3" class="col-sm-3 control-label">Gender</label>

            <div class="col-sm-9">

                <input type="radio" name="gender" value="male"  @if($usermodel->gender=='male') checked @endif>Male <input type="radio" name="gender" value="female" @if($usermodel->gender=='female') checked @endif>Female

            </div>

        </div>



        <div class="form-group">

            <label for="inputEmail3" class="col-sm-3 control-label">Contact</label>

            <div class="col-sm-9">

                <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact" value="{{$usermodel->contact_number}}">

            </div>

        </div>

        <div class="form-group">

            <label for="inputEmail3" class="col-sm-3 control-label">Zipcode</label>

            <div class="col-sm-9">

                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="zipcode" value="{{$usermodel->zipcode}}">

            </div>

        </div>

</div>





<div class="col-sm-6 text-left">

    <div class="form-group">

        <label for="inputEmail3" class="col-sm-12 control-label">Account Type:  {{$usermodel->user_role}}</label>

            @if(!empty($usermodel->logo_img))

                <!-- <img src="{{public_path('/img/user/thumbnail/'.$usermodel->logo_img)}}">     -->

            @endif                  

    </div>





    <div class="form-group">

        <label for="inputEmail3" class="col-sm-12 control-label">My summary</label>

        <div class="col-sm-12">

          <textarea name="brif" id="brif" class="form-control"  rows="10">{{$usermodel->brif}}</textarea>

        </div>

    </div>


    @if($usermodel->proof_of_identity)
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">Proof of Identity</label>
        <div class="col-sm-12">
            <img src="{{asset($usermodel->proof_of_identity)}}"/>
        </div>
    </div>
    @endif

{!! csrf_field() !!}

    <div class="form-group">

        <div class="col-sm-4">

            <input type="hidden" id="edit_user_id" name="edit_user_id" value="{{$usermodel->id}}">

            <input type="hidden" id="edit_user_role" name="edit_user_role" value="{{$usermodel->user_role}}">

            <input type="submit" class="btn btn-primary btn-success" id="org_save" name="org_save" value="Save changes">

        </div>

    </form>
    
        <div class="col-sm-4">

        <form method="post" action="{{url('admin/approve')}}" >
        {!! csrf_field() !!}
            <input type="hidden" id="edit_user_id" name="edit_user_id" value="{{$usermodel->id}}">

            <input type="hidden" id="edit_user_role" name="edit_user_role" value="{{$usermodel->user_role}}">

            <input type="submit" class="btn btn-primary btn-success" id="approve" name="approve" value="Approve">
        </form>

        </div>

        <div class="col-sm-4">

        <form method="post" action="{{url('admin/reject')}}" >
        {!! csrf_field() !!}
            <input type="hidden" id="edit_user_id" name="edit_user_id" value="{{$usermodel->id}}">

            <input type="hidden" id="edit_user_role" name="edit_user_role" value="{{$usermodel->user_role}}">

            <input type="submit" class="btn btn-primary btn-danger" id="reject" name="reject" value="Reject">
        </form>

         </div>

    </div>

</div>



@endif





<script type="text/javascript">

    $(function(){

        $('#org_type').change(function(){

            if($(this).val()==2)

            {

                $(this).next().show();

            }

            else

            {

                 $(this).next().hide();

            }

        })

    })

</script>