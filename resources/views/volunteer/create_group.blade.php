@extends('volunteer.layout.master')

@section('css')
    <link href="<?=asset('css/plugins/select2/select2.min.css')?>" rel="stylesheet">
    <link href="<?=asset('css/plugins/nouslider/nouislider.css')?>" rel="stylesheet">
    <style>
        .group-info-field{
            width: 100%;
            float: right;
            border: 1px solid#ddd;
            background: #fafafa;
            padding: 20px;}
    </style>
@endsection
@section('content')
    <div class="content-panel">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-12 animated fadeInRight impact-panel">
                    @if($group_id == null)
                        <div class="post-header">
                            @if(Session::has('error'))
                                <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">×</a>
                                    {!!Session::get('error')!!}
                                </div>
                            @endif
                            <h1>Creating New Group</h1>
                            <p>You can create new Group right now. Fill below boxes and click "Create Group" button!</p>
                        </div>
                        <div class="divider"></div>
                        <form id="post_opportunity" role="form" method="post" action="{{url('api/volunteer/group/create_vol_group')}}" enctype="multipart/form-data">
                            <input type="hidden" id="banner_size" value="0">
                            {{csrf_field()}}
                            <div class="post-body">
                                <div class="group-info-field">
                                    <h2>Group Information</h2>
                                    <div class="profile-image-hover">
                                        <img src="<?=asset('img/logo/group-default-logo.png')?>" class="img-circle circle-border m-b-md" alt="profile">
                                        <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                            <input type="file" accept="image/*" name="file_logo" id="inputImage" class="hide">Upload Icon
                                        </label>
                                        <label title="Upload banner file" for="inputBanner" class="btn btn-primary">
                                            <input type="file" accept="image/*" name="file_banner" id="inputBanner" class="hide">Upload Banner
                                        </label>
                                    </div>
                                    <div style="clear: both;"></div>
                                    <p>Group Name:</p>
                                    <input type="text" name="group_name" class="form-control" id="group_name" value="">
                                    <p>Group Description:</p>
                                    <textarea rows="5" name="description" class="form-control" id="description"></textarea>
                                     <p>Group Type:</p>
                                    <select name="group_type" class="form-control" id="group_type" value="">
                                      <option value="1">Public</option>
                                      <option value="0">Private</option>
                                    </select>
                                </div>
                                <div class="contact-info">
                                    <h2>Contact Info</h2>
                                    <div class="col-md-4">
                                        <p>Contact name:</p>
                                        <input type="text" name="contact_name" class="form-control" id="contact_name" value="{{Auth::user()->first_name}}">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Contact Email:</p>
                                        <input type="text" name="contact_email" class="form-control" id="contact_email" value="{{Auth::user()->email}}">
                                        <p class="p_invalid" id="invalid_email_alert">Invalid email address.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Contact Phone:</p>
                                        <input type="text" name="contact_phone" class="form-control" id="contact_phone" value="{{Auth::user()->contact_number}}">
                                        <p class="p_invalid" id="invalid_phone_alert">Invalid Phone number.</p>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="divider"></div>
                            <div class="post-footer">
                                <button type="button" id="btn_create_group" class="btn btn-primary pull-right">Create Group</button>
                                <a href="{{url('/volunteer/group')}}" type="button" id="btn_create_group" class="btn btn-danger pull-right" style="margin-right: 5px">Back</a>
                                <div style="clear: both;"></div>
                            </div>
                        </form>
                    @else
                        <div class="post-header">
                            @if(Session::has('error'))
                                <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">×</a>
                                    {!!Session::get('error')!!}
                                </div>
                            @endif
                            <h1>Edit Group</h1>
                            <p>You can Edit Group here. Only Administrator can edit Group contents!</p>
                        </div>
                        <div class="divider"></div>
                        <form id="post_opportunity" role="form" method="post" action="{{url('api/volunteer/group/change_org_group')}}" enctype="multipart/form-data">
                            <input type="hidden" id="banner_size" value="0">
                            {{csrf_field()}}
                            <div class="post-body">
                                <div class="group-info-field">
                                    <h2>Group Information</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="profile-image-hover">
                                                @if($group_info->logo_img == null)
                                                    <img src="<?=asset('img/logo/group-default-logo.png')?>" class="img-circle circle-border m-b-md" alt="profile">
                                                @else
                                                    <img src="{{url('/uploads/volunteer_group_logo/thumb/'.$group_info->logo_img)}}" class="img-circle circle-border m-b-md" alt="profile">
                                                @endif
                                                <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                                    <input type="file" accept="image/*" name="file_logo" id="inputImage" class="hide">Upload Logo
                                                </label>
                                                
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            @if($group_info->banner_image != null)
                                                <img src="{{url('/uploads/volunteer_group_banner/thumb/'.$group_info->banner_image)}}" class="" alt="banner">
                                            @endif
                                            <label title="Upload banner file" for="inputBanner" class="btn btn-primary" style="margin-top: 10px;">
                                                <input type="file" accept="image/*" name="file_banner" id="inputBanner" class="hide">Upload Banner
                                            </label>
                                        </div>   
                                    </div>
                                    <div style="clear: both;"></div>
                                    <p>Group Name:</p>
                                    <input type="text" name="group_name" class="form-control" id="group_name" value="{{$group_info->name}}">
                                    <p>Group Description:</p>
                                    <textarea rows="5" name="description" class="form-control" id="description">{{$group_info->description}}</textarea>
									<p>Group Type:</p>
                                    <select name="group_type" class="form-control" id="group_type" value="">
                                      <option value="1" @if($group_info->is_public==1) selected="selected" @endif >Public</option>
                                      <option value="0" @if($group_info->is_public==0) selected="selected" @endif>Private</option>
                                    </select>
                                </div>
                                <div class="contact-info">
                                    <h2>Contact Info</h2>
                                    <div class="col-md-4">
                                        <p>Contact name:</p>
                                        <input type="text" name="contact_name" class="form-control" id="contact_name" value="{{$group_info->contact_name}}">
                                    </div>
                                    <div class="col-md-4">
                                        <p>Contact Email:</p>
                                        <input type="text" name="contact_email" class="form-control" id="contact_email" value="{{$group_info->contact_email}}">
                                        <p class="p_invalid" id="invalid_email_alert">Invalid email address.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Contact Phone:</p>
                                        <input type="text" name="contact_phone" class="form-control" id="contact_phone" value="{{$group_info->contact_phone}}">
                                        <p class="p_invalid" id="invalid_phone_alert">Invalid Phone number.</p>
                                    </div>
                                </div>
                                <input type="hidden" name="group_id" id="group_id" value="{{$group_id}}">
                                <div style="clear: both;"></div>
                            </div>
                            <div class="divider"></div>
                            <div class="post-footer">
                                <button type="button" id="btn_create_group" class="btn btn-primary pull-right">Change Group</button>
                                <a href="{{url('/volunteer/group')}}" type="button" id="btn_create_group" class="btn btn-danger pull-right" style="margin-right: 5px">Back</a>
                                <div style="clear: both;"></div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
@endsection
@section('script')
    <script></script>
    <script>
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
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    
                    if(this.width<1200 || this.height<280)
                    {
                        $('#banner_size').val(1);
                        alert('Recomended banner size 1200 X 280. Please try another');
                    }
                    else{
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

        $(document).ready(function(){
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
//                        $inputImage.val("");
                            $image.attr('src', e.target.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            }else {
                $inputImage.addClass("hide");
            }
        });
    </script>
@endsection