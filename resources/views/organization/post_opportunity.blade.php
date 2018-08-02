@extends('layout.masterForAuthUser')

@section('css')
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-slider.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/main.css')}}">


    <style>
        .p_invalid{
            display: none;
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 3px;
            color: red !important;
        }
    </style>
@endsection
@section('content')
    <form id="post_opportunity" role="form" method="post" action="{{url('api/organization/post_opportunity')}}" enctype="multipart/form-data">
        {{csrf_field()}}
    <div class="wrapper-create-edit-group">
        <div class="container">


                <div class="main-text border-bottom">
                    <h2 class="h2">Posting New Opportunity</h2>
                    <p class="light">Please fill out fields below and click "Post Opportunity"</p>
                </div>


                <div class="row">


                    <div class="col-12 col-md-6">

                        <div class="form-group">
                            <div class="main-text">
                                <h3 class="h3">Opportunity Info</h3>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="col-12">

                                <div class="form-group">
                                    <div class="logo-box"></div>
                                </div>

                            </div>
                            <div class="col-12">


                                <div class="form-group text-right">
                                    <div class="wrapper-file-upload">
                                        <input accept="image/*" name="file_logo" id="inputImage" class="hide" type="file">
                                        <a href="#"><span>Upload logo</span></a>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Opportunity Title:</label>
                            <div class="wrapper_input">
                                <input type="text" name="title" class="form-control" id="title" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Opportunity Type:</label>
                            <div class="wrapper_select">
                                <select  name="opportunity_type" id="opportunity_type" class="form-control custom-dropdown">
                                    @foreach($opportunity_category as $oc)
                                        <option value="{{$oc->id}}">{{$oc->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Opportunity Description:</label>
                            <div class="wrapper_input">
                                <textarea name="description" class="form-control" id="description" placeholder=""></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Minimum Age:</label>
                            <div class="wrapper_select">
                                <select class="custom-dropdown form-control" name="min_age" id="min_age">
                                    <option value="13">13</option>
                                    <option value="15">15</option>
                                    <option value="17">17</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Activities:</label>
                            <div class="wrapper_input">
                                <textarea name="activity" class="form-control" id="activity" placeholder=""></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Qualification:</label>
                            <div class="wrapper_input">
                                <textarea name="qualification" class="form-control" id="qualification" placeholder=""></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="col-12 col-md-6">

                        <div class="form-group">
                            <div class="main-text">
                                <h3 class="h3">Address</h3>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Street 1:</label>
                            <div class="wrapper_input">
                                <input name="street1" class="form-control" id="street1" type="text" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Street 2:</label>
                            <div class="wrapper_input">
                                <input name="street2" class="form-control" id="street2" type="text" value="" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">City:</label>
                            <div class="wrapper_input">
                                <input name="city" class="form-control" id="city" type="text" value="" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">State:</label>
                                    <div class="wrapper_input">
                                        <select name="state" class="form-control" id="state">
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="DC">District Of Columbia</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">Zipcode:</label>
                                    <div class="wrapper_input">
                                        <input name="zipcode" class="form-control" id="zipcode" type="text" value="" placeholder="">
                                        <p class="p_invalid" id="invalid_zipcode_alert">Invalid ID. Please enter another.</p>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Additional Info:</label>
                            <div class="wrapper_input">
                                <textarea name="add_info" class="form-control" placeholder=""></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="main-text">
                                <h3 class="h3">Time Info</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">Start Date:</label>
                                    <div class="wrapper_input fa-icons">
                                        <input name="start_date" readonly id="start_date" class="form-control" type="text" value="" placeholder="">
                                        <span class="focus-border"></span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>


                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">End Date:</label>
                                    <div class="wrapper_input fa-icons">
                                        <input name="end_date" readonly id="end_date" class="form-control" type="text" value="" placeholder="">
                                        <span class="focus-border"></span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="form-group">
                            <label id="time-range" class="label-text">
                                Time Range:
                            </label>


                            <div class="slider-range">
                                <input name="start_at"  id="slider-range" type="text" value="" data-slider-min="0" data-slider-max="1440"
                                       data-slider-step="15" data-slider-value="[540,1020]">

                                <input type="hidden" name="start_at" id="start_at" value="9:00 AM" autocomplete="off">

                                <input type="hidden" name="end_at" id="end_at" value="5:00 PM" autocomplete="off">
                            </div>

                        </div>


                        <div class="form-group">
                            <div class="checkbox-list" id="weekdays_chk_border">

                                <label class="label-text">Select Week Days:</label>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Monday" class="weekdays_chk" id="mon">
                                        <i></i>
                                        <span class="label-checkbox-text">Monday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Tuesday" class="weekdays_chk" id="tue">
                                        <i></i>
                                        <span class="label-checkbox-text">Tuesday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Wednesday" class="weekdays_chk" id="wed">
                                        <i></i>
                                        <span class="label-checkbox-text">Wednesday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Thursday" class="weekdays_chk" id="thu">
                                        <i></i>
                                        <span class="label-checkbox-text">Thursday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Friday" class="weekdays_chk" id="fri">
                                        <i></i>
                                        <span class="label-checkbox-text">Friday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Saturday" class="weekdays_chk" id="sat">
                                        <i></i>
                                        <span class="label-checkbox-text">Saturday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Sunday" class="weekdays_chk" id="sun">
                                        <i></i>
                                        <span class="label-checkbox-text">Sunday</span>
                                    </label></div>

                            </div>
                            <input type="hidden" id="weekday_vals" name="weekday_vals" value="">
                        </div>



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
                                <input type="text" value="{{Auth::user()->user_name}}" placeholder="" name="contact_name" class="form-control" id="contact_name">
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Email:</label>
                            <div class="wrapper_input">
                                <input type="text" value="{{Auth::user()->email}}" placeholder="" name="contact_email" class="form-control" id="contact_email">
                                <p class="p_invalid" id="invalid_email_alert">Invalid email address.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Phone:</label>
                            <div class="wrapper_input">
                                <input type="text" value="{{Auth::user()->contact_number}}" placeholder="" name="contact_phone" class="form-control" id="contact_phone">
                                <p class="p_invalid" id="invalid_phone_alert">Invalid Phone number.</p>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="wrapper_row_link">
                    <div class="wrapper-link two-link margin-top">
                        <a href="{{url('/organization/opportunity')}}" class="red"><span>Close</span></a>
                        <a id="btn_post"  href="#"><span>Post opportunity</span></a>
                    </div>
                </div>

        </div>
    </div>
    </form>
@endsection
@section('script')
    <script src="<?=asset('js/plugins/datetimepicker/moment.js')?>"></script>
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

        $('#btn_post').on('click', function (e) {
            e.preventDefault;
            var flags = 0;
            if ($("#title").val() == '') {
                $("#title").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#description").val() == '') {
                $("#description").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#activity").val() == '') {
                $("#activity").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#qualification").val() == '') {
                $("#qualification").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#street1").val() == '') {
                $("#street1").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#city").val() == '') {
                $("#city").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#state").val() == '') {
                $("#state").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($('#zipcode').val() == '') {
                $('#zipcode').css("border", "1px solid #ff0000");
                flags++;
            }
            if (!ValidateZipcode($('#zipcode').val())) {
                flags++;
                $('#zipcode').css("border", "1px solid #ff0000");
                $('#invalid_zipcode_alert').show();
            }
            if ($("#start_date").val() == '') {
                $("#start_date").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#end_date").val() == '') {
                $("#end_date").css("border", "1px solid #ff0000");
                flags++;
            }
            if ($("#weekday_vals").val() == '') {
                $("#weekdays_chk_border").css("border", "1px solid #ff0000");
                flags++;
            }
            else{
                $("#weekdays_chk_border").css("border", "1px solid #fff");
            }
            if ($('#contact_name').val() == '') {
                $('#contact_name').css("border", "1px solid #ff0000");
                flags++;
            }
            if ($('#contact_email').val() == '') {
                $('#contact_email').css("border", "1px solid #ff0000");
                flags++;
            }
            if (!ValidateEmail($('#contact_email').val())) {
                flags++;
                $('#invalid_email_alert').show();
            }
            if ($('#contact_phone').val() == '') {
                $('#contact_email').css("border", "1px solid #ff0000");
                flags++;
            }
            if (!ValidatePhonepumber($('#contact_phone').val())) {
                flags++;
                $('#invalid_phone_alert').show();
                $('#contact_phone').css("border", "1px solid #ff0000");
            }
            if (flags == 0) {
                $('#post_opportunity').submit();
            }
        });

        $('.form-control').on('click', function () {
            $(this).css("border", "1px solid #e5e6e7");
            $(this).parent().find('.p_invalid').hide();
        });

        $(document).ready(function () {
            $('body').on('change','#inputImage', function () {
                readURL(this, $('.logo-box'));
            })

            $('.weekdays_chk').on('click', function(){
                var weekdays = '';
                $('.weekdays_chk').each(function(){
                    if($(this).is(':checked')){
                        weekdays += $(this).val()+',';
                    }
                });
                if(weekdays != ''){
                    weekdays = weekdays.slice(0, -1);
                }
                $('#weekday_vals').val(weekdays);
            });

            $("select").select2({
                theme: "bootstrap",
                minimumResultsForSearch: -1
            });

            $('.wrapper_input.fa-icons input').datepicker({
                startDate: '+0d',
                'format': 'mm/dd/yyyy',
                'autoclose': true,
                'orientation': 'right',
                'todayHighlight': true
            });


            $("#slider-range").slider({});


            $(".slider-range .tooltip.tooltip-min").append('<span class="slider-time-1">9:00 AM</span>');
            $(".slider-range .tooltip.tooltip-max").append('<span class="slider-time-2">5:00 PM</span>');

            $("#slider-range").on("slide", function (slideEvt) {


                var hours1 = Math.floor(slideEvt.value[0] / 60);
                var minutes1 = slideEvt.value[0] - (hours1 * 60);

                if (hours1.length == 1) hours1 = '0' + hours1;
                if (minutes1.length == 1) minutes1 = '0' + minutes1;
                if (minutes1 == 0) minutes1 = '00';
                if (hours1 >= 12) {
                    if (hours1 == 12) {
                        hours1 = hours1;
                        minutes1 = minutes1 + " PM";
                    } else {
                        hours1 = hours1 - 12;
                        minutes1 = minutes1 + " PM";
                    }
                } else {
                    hours1 = hours1;
                    minutes1 = minutes1 + " AM";
                }
                if (hours1 == 0) {
                    hours1 = 12;
                    minutes1 = minutes1;
                }


                $('.slider-range .slider-time-1').html(hours1 + ':' + minutes1);


                var hours2 = Math.floor(slideEvt.value[1] / 60);
                var minutes2 = slideEvt.value[1] - (hours2 * 60);

                if (hours2.length == 1) hours2 = '0' + hours2;
                if (minutes2.length == 1) minutes2 = '0' + minutes2;
                if (minutes2 == 0) minutes2 = '00';
                if (hours2 >= 12) {
                    if (hours2 == 12) {
                        hours2 = hours2;
                        minutes2 = minutes2 + " PM";
                    } else if (hours2 == 24) {
                        hours2 = 11;
                        minutes2 = "59 PM";
                    } else {
                        hours2 = hours2 - 12;
                        minutes2 = minutes2 + " PM";
                    }
                } else {
                    hours2 = hours2;
                    minutes2 = minutes2 + " AM";
                }

                function toTime(current_time){

                    var mins = parseInt(current_time);

                    var min = mins%60;

                    var hours = (mins-min)/60;

                    var day = 'AM';

                    if(min < 10){

                        min = '0'+min.toString();

                    }else{

                        min = min.toString();

                    }

                    if (hours >= 12 && hours < 24){

                        day = 'PM';

                    }

                    if(hours > 12){

                        hours = hours-12;

                    }

                    return hours.toString()+':'+min.toString()+day;

                }
                $('.slider-range .slider-time-2').html(hours2 + ':' + minutes2);
                $("#slider-range").on('change', function ( values, handle ) {
                    var value = values['value']['newValue'];
                    $('#start_at').val(toTime(value[0]));

                    $('#end_at').val(toTime(value[1]));

                });

            });
        });
    </script>
@endsection