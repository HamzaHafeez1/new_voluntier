@extends('layout.masterForAuthUser')

@section('css')

    <link rel="stylesheet" href="{{asset('front-end/css/main.css')}}">
@endsection
@section('content')
    <div class="wrapper-create-edit-group">
        <div class="container">
            <form id="post_opportunity" role="form" method="post"
                  @if(Auth::user()->user_role == 'organization' )
                      @if($group_id == null)
                       action="{{url('api/organization/group/create_org_group')}}"
                      @else
                        action="{{url('api/organization/group/change_org_group')}}"
                      @endif
                  @else
                      @if($group_id == null)
                      action="{{url('api/volunteer/group/create_vol_group')}}"
                      @else
                      action="{{url('api/volunteer/group/change_org_group')}}"
                      @endif
                  @endif
                  enctype="multipart/form-data">
                <input type="hidden" id="banner_size" value="0">
                {{csrf_field()}}
                <div class="main-text border-bottom">
                    <h2 class="h2">{{((if_route_pattern('volunteer-group-group_add') or if_route_pattern('organization-group-group_add') ) and if_route_param('id', null)) ? 'Creating New Group' : 'Edit Group'}}</h2>
                    <p class="light">{{((if_route_pattern('volunteer-group-group_add') or if_route_pattern('organization-group-group_add') )  and if_route_param('id', null)) ? 'You can create a new Group right now. Fill out the information below and click "Create Group".' : 'You can edit your Group here. Only an Administrator can edit this page.'}}</p>
                </div>


                <div class="form-group">
                    <div class="main-text">
                        <h3 class="h3">Group Info</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <div class="logo-box profile-image-hover"
                                 @if($group_id == null)
                                        style="background-image:url('{{asset('front-end/img/upload/logo.png')}}')"
                                 @else
                                    @if($group_info->logo_img == null)
                                        style="background-image:url('{{asset('front-end/img/upload/logo.png')}}')" class="img-circle circle-border m-b-md"
                                    @else
                                        style="background-image:url('{{url('/uploads/volunteer_group_logo/')}}/{{$group_info->logo_img}}')" class="img-circle circle-border m-b-md" alt="profile"
                                    @endif

                                 @endif


                             ></div>

                            <div class="form-group text-right">
                                <div class="wrapper-file-upload">
                                    <input name="file_logo" type="file" accept="image/*" id="inputImage">
                                    <a href="#"><span>Upload logo</span></a>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-12 col-md-8">

                        <div class="form-group text-right">
                            <div class="banner-box"
                                 @if($group_id == null)
                                    style="background-image:url('{{asset('front-end/img/upload/banner.png')}}')"
                                 @else
                                    @if($group_info->banner_image != null)
                                        style="background-image:url('{{url('/uploads/volunteer_group_banner/thumb/'.$group_info->banner_image)}}')"  alt="banner"
                                    @else
                                        style="background-image:url('{{asset('front-end/img/upload/banner.png')}}')"
                                    @endif

                                @endif
                                        ></div>
                            <div class="form-group">
                                <div class="wrapper-file-upload">
                                    <input type="file" id="inputBanner" accept="image/*" name="file_banner">
                                    <a href="#"><span>Upload banner</span></a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-6">

                        <div class="form-group">
                            <label class="label-text">Group Name:</label>
                            <div class="wrapper_input">
                                <input type="text" id="group_name" name="group_name" class="form-control" value="{{ $group_id !== null ?  $group_info->name  : ""}}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">

                        <div class="form-group">
                            <label class="label-text">Group Type:</label>
                            <div class="wrapper_select">
                                <select name="group_type" class="custom-dropdown form-control">
                                    @if($group_id == null)
                                        <option value="1" selected="selected">Public</option>
                                        <option value="0" >Private</option>
                                    @else
                                        <option value="1" @if($group_info->is_public==1) selected="selected" @endif >Public</option>
                                        <option value="0" @if($group_info->is_public==0) selected="selected" @endif>Private</option>
                                    @endif


                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="label-text">Group Description:</label>
                    <div class="wrapper_input">
                        <textarea class="form-control" name="description" id="description" placeholder="">{{$group_id !== null ? $group_info->description : "" }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="main-text">
                        <h3 class="h3">Contact Info</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Name:</label>
                            <div class="wrapper_input">
                                <input type="text" id="contact_name" name="contact_name" class="form-control" value="{{ Auth::user()->user_role == 'organization' ? Auth::user()->org_name :  Auth::user()->first_name}}" placeholder="">
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Email:</label>
                            <div class="wrapper_input">
                                <input type="text" id="contact_email" name="contact_email" class="form-control" value="{{Auth::user()->email}}" placeholder="">
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Phone:</label>
                            <div class="wrapper_input">
                                <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="{{Auth::user()->contact_number}}" placeholder="">
                            </div>
                        </div>

                    </div>
                </div>


                <div class="wrapper_row_link">
                    <div class="wrapper-link two-link margin-top">
                        <a href="{{Auth::user()->user_role == 'organization' ? url('/organization/group') : url('/volunteer/group') }}" class="red"><span>Back</span></a>
                        <a href="#" id="btn_create_group"><span>{{((if_route_pattern('volunteer-group-group_add') or if_route_pattern('organization-group-group_add'))  and if_route_param('id', null)) ? 'Create group' : 'Confirm Edit(s)'}}</span></a>
                    </div>
                </div>
                @if($group_id != null)
                    <input type="hidden" name="group_id" id="group_id" value="{{$group_id}}">
                @endif

            </form>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('front-end/js/jquery.bxslider-rahisified.js') }}"></script>
    <script src="{{ asset('front-end/js/select2.full.js') }}"></script>
    <script src="{{ asset('js/check_validate.js') }}"></script>

    <script>
        function readURL(input, name) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                        name.css('background-image', 'url(' + e.target.result +  ')');
                    console.log(e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
                // console.log()e.target.result;
            }
        }

        $('#btn_create_group').on('click',function(e) {
            e.preventDefault;
            var flags = 0;
            if ($("#group_name").val() == ''){
                $("#group_name").css("border","1px solid #ff0000");
                flags++;
            }
            if ($("#description").val() == ''){
                $("#description").css("border","1px solid #ff0000");
                flags++;
            }
            if($('#contact_name').val()=='') {
                $('#contact_name').css("border", "1px solid #ff0000");
                flags++;
            }
            if($('#contact_email').val()=='') {
                $('#contact_email').css("border", "1px solid #ff0000");
                flags++;
            }
            if (!ValidateEmail($('#contact_email').val())) {
                flags++;
                $('#invalid_email_alert').show();
            }
            if($('#contact_phone').val()=='') {
                $('#contact_email').css("border", "1px solid #ff0000");
                $('#invalid_email_alert').show();
                flags++;
            }
            if (!ValidatePhonepumber($('#contact_phone').val())) {
                flags++;
                $('#invalid_phone_alert').show();
                $('#contact_phone').css("border", "1px solid #ff0000");
            }
            if(flags == 0 && $('#banner_size').val()==0){
                $('#post_opportunity').submit();
            }
        });

        var _URL = window.URL || window.webkitURL;

        $("#inputBanner").change(function (e) {
            var file, img;
            readURL(this, $('.banner-box'));
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {

                    if(this.width<1200 || this.height<280)
                    {
                        $('#banner_size').val(1);
                        alert('Recomended banner size 1200 X 280. Please try another');
                    }
                    else{
                        console.log()
                        $('#banner_size').val(0);

                        //alert(this.width+'=='+this.height);
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        $('.form-control').on('click',function () {
            $(this).css("border","1px solid #e5e6e7");
            $(this).parent().find('.p_invalid').hide();
        });

        $(document).ready(function () {

            $('body').on('change','#inputImage', function () {
                readURL(this, $('.profile-image-hover'));
            })



            $("select").select2({
                theme: "bootstrap",
                minimumResultsForSearch: -1
            });

            $('#weekdays').change(function () {
                $('#weekday_vals').val($('#weekdays').val());
            });

            var $image = $(".profile-image-hover > img")

            var $inputImage = $("#inputImage");

            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                        files = this.files,
                        file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function (e) {
                            $image.attr('src', e.target.result);
                        };
                    } else {
                        console.log("Please choose an image file.");
                    }
                });
            }else {
                $inputImage.addClass("hide");
            }

        });
    </script>
@endsection