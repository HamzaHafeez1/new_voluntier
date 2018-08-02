@extends('layout.masterForAuthUser')



@section('css')
    <link rel="stylesheet" href="{{asset('front-end/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-slider.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/main.css')}}">


    <style>
        .p_invalid {
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

    <div class="wrapper-create-edit-group">
        <div class="container">
            <form id="post_opportunity" role="form" method="post" action="{{url('api/organization/edit_opportunity')}}/{{$oppr_info->id}}" enctype="multipart/form-data">

                {{csrf_field()}}

                <div class="main-text border-bottom">
                    <h2 class="h2">Edit Opportunity</h2>
                    <p class="light">You can edit your Opportunity here</p>
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
                                    <div class="logo-box" style="background: @if($oppr_info->logo_img == '') #fafbfb url('../img/upload/logo.png') no-repeat scroll 50% 50%;" @else url('{{asset('uploads') . '/' . $oppr_info->logo_img}}') no-repeat scroll 50% 50%;" @endif class="logo-box"></div>
                                </div>

                            </div>
                            <div class="col-12">


                                <div class="form-group text-right">
                                    <div class="wrapper-file-upload">
                                        <input accept="image/*" name="file_logo" id="inputImage" class="hide"
                                               type="file">
                                        <a href="#"><span>Upload logo</span></a>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Opportunity Title:</label>
                            <div class="wrapper_input">
                                <input type="text" name="title" class="form-control" id="title" value="{{$oppr_info->title}}" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Opportunity Type:</label>
                            <div class="wrapper_select">
                                <select name="opportunity_type" id="opportunity_type"
                                        class="form-control custom-dropdown">
                                    @foreach($opportunity_category as $oc)

                                        <option <?php if($oppr_info->category_id == $oc->id){?> selected <?php } ?> value="{{$oc->id}}">{{$oc->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Opportunity Description:</label>
                            <div class="wrapper_input">
                                <textarea name="description" class="form-control" id="description"
                                          placeholder="">{{$oppr_info->description}}</textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Minimum Age:</label>
                            <div class="wrapper_select">
                                <select class="custom-dropdown form-control" name="min_age" id="min_age">
                                    <option <?php if($oppr_info->min_age == 13){?> selected <?php } ?> value="13">13</option>
                                    <option <?php if($oppr_info->min_age == 15){?> selected <?php } ?> value="15">15</option>
                                    <option <?php if($oppr_info->min_age == 17){?> selected <?php } ?> value="17">17</option>
                                    <option <?php if($oppr_info->min_age == 20){?> selected <?php } ?> value="20">20</option>
                                    <option <?php if($oppr_info->min_age == 30){?> selected <?php } ?> value="30">30</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Activities:</label>
                            <div class="wrapper_input">
                                <textarea name="activity" class="form-control" id="activity" placeholder="">{{$oppr_info->activity}}</textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Qualification:</label>
                            <div class="wrapper_input">
                                <textarea name="qualification" class="form-control" id="qualification"
                                          placeholder="">{{$oppr_info->qualification}}</textarea>
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
                                <input name="street1" class="form-control" id="street1" type="text" value="{{$oppr_info->street_addr1}}"
                                       placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Street 2:</label>
                            <div class="wrapper_input">
                                <input name="street2" class="form-control" id="street2" type="text" value="{{$oppr_info->street_addr2}}"
                                       placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label-text">City:</label>
                            <div class="wrapper_input">
                                <input name="city" class="form-control" id="city" type="text" value="{{$oppr_info->city}}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">State:</label>
                                    <div class="wrapper_input">
                                        <select name="state" class="form-control" id="state">
                                            <option <?php if($oppr_info->state == 'AL'){?> selected <?php } ?> value="AL">Alabama</option>

                                            <option <?php if($oppr_info->state == 'AK'){?> selected <?php } ?> value="AK">Alaska</option>

                                            <option <?php if($oppr_info->state == 'AZ'){?> selected <?php } ?> value="AZ">Arizona</option>

                                            <option <?php if($oppr_info->state == 'AR'){?> selected <?php } ?> value="AR">Arkansas</option>

                                            <option <?php if($oppr_info->state == 'CA'){?> selected <?php } ?> value="CA">California</option>

                                            <option <?php if($oppr_info->state == 'CO'){?> selected <?php } ?> value="CO">Colorado</option>

                                            <option <?php if($oppr_info->state == 'CT'){?> selected <?php } ?> value="CT">Connecticut</option>

                                            <option <?php if($oppr_info->state == 'DE'){?> selected <?php } ?> value="DE">Delaware</option>

                                            <option <?php if($oppr_info->state == 'DC'){?> selected <?php } ?> value="DC">District Of Columbia</option>

                                            <option <?php if($oppr_info->state == 'FL'){?> selected <?php } ?> value="FL">Florida</option>

                                            <option <?php if($oppr_info->state == 'GA'){?> selected <?php } ?> value="GA">Georgia</option>

                                            <option <?php if($oppr_info->state == 'HI'){?> selected <?php } ?> value="HI">Hawaii</option>

                                            <option <?php if($oppr_info->state == 'ID'){?> selected <?php } ?> value="ID">Idaho</option>

                                            <option <?php if($oppr_info->state == 'IL'){?> selected <?php } ?> value="IL">Illinois</option>

                                            <option <?php if($oppr_info->state == 'IN'){?> selected <?php } ?> value="IN">Indiana</option>

                                            <option <?php if($oppr_info->state == 'IA'){?> selected <?php } ?> value="IA">Iowa</option>

                                            <option <?php if($oppr_info->state == 'KA'){?> selected <?php } ?> value="KS">Kansas</option>

                                            <option <?php if($oppr_info->state == 'KY'){?> selected <?php } ?> value="KY">Kentucky</option>

                                            <option <?php if($oppr_info->state == 'LA'){?> selected <?php } ?> value="LA">Louisiana</option>

                                            <option <?php if($oppr_info->state == 'ME'){?> selected <?php } ?> value="ME">Maine</option>

                                            <option <?php if($oppr_info->state == 'MD'){?> selected <?php } ?> value="MD">Maryland</option>

                                            <option <?php if($oppr_info->state == 'MA'){?> selected <?php } ?> value="MA">Massachusetts</option>

                                            <option <?php if($oppr_info->state == 'MI'){?> selected <?php } ?> value="MI">Michigan</option>

                                            <option <?php if($oppr_info->state == 'MN'){?> selected <?php } ?> value="MN">Minnesota</option>

                                            <option <?php if($oppr_info->state == 'MS'){?> selected <?php } ?> value="MS">Mississippi</option>

                                            <option <?php if($oppr_info->state == 'MO'){?> selected <?php } ?> value="MO">Missouri</option>

                                            <option <?php if($oppr_info->state == 'MT'){?> selected <?php } ?> value="MT">Montana</option>

                                            <option <?php if($oppr_info->state == 'NE'){?> selected <?php } ?> value="NE">Nebraska</option>

                                            <option <?php if($oppr_info->state == 'NV'){?> selected <?php } ?> value="NV">Nevada</option>

                                            <option <?php if($oppr_info->state == 'NH'){?> selected <?php } ?> value="NH">New Hampshire</option>

                                            <option <?php if($oppr_info->state == 'NJ'){?> selected <?php } ?> value="NJ">New Jersey</option>

                                            <option <?php if($oppr_info->state == 'NM'){?> selected <?php } ?> value="NM">New Mexico</option>

                                            <option <?php if($oppr_info->state == 'NY'){?> selected <?php } ?> value="NY">New York</option>

                                            <option <?php if($oppr_info->state == 'NC'){?> selected <?php } ?> value="NC">North Carolina</option>

                                            <option <?php if($oppr_info->state == 'ND'){?> selected <?php } ?> value="ND">North Dakota</option>

                                            <option <?php if($oppr_info->state == 'OH'){?> selected <?php } ?> value="OH">Ohio</option>

                                            <option <?php if($oppr_info->state == 'OK'){?> selected <?php } ?> value="OK">Oklahoma</option>

                                            <option <?php if($oppr_info->state == 'OR'){?> selected <?php } ?> value="OR">Oregon</option>

                                            <option <?php if($oppr_info->state == 'PA'){?> selected <?php } ?> value="PA">Pennsylvania</option>

                                            <option <?php if($oppr_info->state == 'RI'){?> selected <?php } ?> value="RI">Rhode Island</option>

                                            <option <?php if($oppr_info->state == 'SC'){?> selected <?php } ?> value="SC">South Carolina</option>

                                            <option <?php if($oppr_info->state == 'SD'){?> selected <?php } ?> value="SD">South Dakota</option>

                                            <option <?php if($oppr_info->state == 'TN'){?> selected <?php } ?> value="TN">Tennessee</option>

                                            <option <?php if($oppr_info->state == 'TX'){?> selected <?php } ?> value="TX">Texas</option>

                                            <option <?php if($oppr_info->state == 'UT'){?> selected <?php } ?> value="UT">Utah</option>

                                            <option <?php if($oppr_info->state == 'VT'){?> selected <?php } ?> value="VT">Vermont</option>

                                            <option <?php if($oppr_info->state == 'VA'){?> selected <?php } ?> value="VA">Virginia</option>

                                            <option <?php if($oppr_info->state == 'WA'){?> selected <?php } ?> value="WA">Washington</option>

                                            <option <?php if($oppr_info->state == 'WV'){?> selected <?php } ?> value="WV">West Virginia</option>

                                            <option <?php if($oppr_info->state == 'WI'){?> selected <?php } ?> value="WI">Wisconsin</option>

                                            <option <?php if($oppr_info->state == 'WY'){?> selected <?php } ?> value="WY">Wyoming</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">Zipcode:</label>
                                    <div class="wrapper_input">
                                        <input name="zipcode" class="form-control" id="zipcode" type="text" value="{{$oppr_info->zipcode}}"
                                               placeholder="">
                                        <p class="p_invalid" id="invalid_zipcode_alert">Invalid ID. Please enter
                                            another.</p>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Additional Info:</label>
                            <div class="wrapper_input">
                                <textarea name="add_info" class="form-control" placeholder="">{{$oppr_info->additional_info}}</textarea>
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
                                        <input name="start_date" readonly id="start_date" class="form-control"
                                               type="text" value="{{date("m/d/Y",strtotime($oppr_info->start_date))}}" placeholder="">
                                        <span class="focus-border"></span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>


                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-text">End Date:</label>
                                    <div class="wrapper_input fa-icons">
                                        <input name="end_date" readonly id="end_date" class="form-control" type="text"
                                               value="{{date("m/d/Y",strtotime($oppr_info->end_date))}}" placeholder="">
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
                                <input name="start_at" id="slider-range" type="text" value="" data-slider-min="0"
                                       data-slider-max="1440"
                                       data-slider-step="30" data-slider-value="[540,1020]">

                                <input type="hidden" name="start_at" id="start_at" value="{{$oppr_info->start_at}}" autocomplete="off">

                                <input type="hidden" name="end_at" id="end_at" value="{{$oppr_info->end_at}}" autocomplete="off">
                            </div>

                        </div>


                        <div class="form-group">
                            <div class="checkbox-list" id="weekdays_chk_border">

                                <label class="label-text">Select Week Days:</label>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Monday" class="weekdays_chk" id="mon" <?php if(strpos($oppr_info->weekdays, 'Monday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Monday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Tuesday" class="weekdays_chk" id="tue" <?php if(strpos($oppr_info->weekdays, 'Tuesday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Tuesday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Wednesday" class="weekdays_chk" id="wed" <?php if(strpos($oppr_info->weekdays, 'Wednesday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Wednesday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Thursday" class="weekdays_chk" id="thu" <?php if(strpos($oppr_info->weekdays, 'Thursday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Thursday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Friday" class="weekdays_chk" id="fri" <?php if(strpos($oppr_info->weekdays, 'Friday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Friday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Saturday" class="weekdays_chk" id="sat" <?php if(strpos($oppr_info->weekdays, 'Saturday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Saturday</span>
                                    </label></div>

                                <div class="wrapper-checkbox"><label>
                                        <input type="checkbox" value="Sunday" class="weekdays_chk" id="sun" <?php if(strpos($oppr_info->weekdays, 'Sunday')!==false) echo 'checked' ?>>
                                        <i></i>
                                        <span class="label-checkbox-text">Sunday</span>
                                    </label></div>

                            </div>
                            <input type="hidden" id="weekday_vals" name="weekday_vals" value="{{$oppr_info->weekdays}}">
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
                                <input type="text" value="{{$oppr_info->contact_name}}" placeholder="" name="contact_name" class="form-control"
                                       id="contact_name">
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Email:</label>
                            <div class="wrapper_input">
                                <input type="text" value="{{$oppr_info->contact_email}}" placeholder="" name="contact_email" class="form-control"
                                       id="contact_email">
                                <p class="p_invalid" id="invalid_email_alert">Invalid email address.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-4">

                        <div class="form-group">
                            <label class="label-text">Contact Phone:</label>
                            <div class="wrapper_input">
                                <input type="text" value="{{$oppr_info->contact_number}}" placeholder="" name="contact_phone" class="form-control"
                                       id="contact_phone">
                                <p class="p_invalid" id="invalid_phone_alert">Invalid Phone number.</p>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="wrapper_row_link">
                    <div class="wrapper-link two-link margin-top">
                        <a href="{{url('/organization/opportunity')}}"
                           class="red"><span>Close</span></a>
                        <a id="btn_post" href="#"><span>CONFIRM EDIT(s)</span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="<?=asset('js/plugins/nouslider/nouislider.js')?>"></script>
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
                startDate: '{{date("m/d/Y",strtotime($oppr_info->start_date))}}',
                'format': 'mm/dd/yyyy',
                'autoclose': true,
                'orientation': 'right',
                'todayHighlight': true
            });
            var starAt = $('#start_at').val()
            var endAt = $('#end_at').val()

            var starAtNumber = toMin(starAt);
            var endAtNumber = toMin(endAt);


            var start_at = toMin($('#start_at').val());
            var end_at = toMin($('#end_at').val());
            $('#slider-range').attr('data-slider-value', '[' + starAtNumber +',' + endAtNumber + ']')



            var slid = $("#slider-range").slider({});




            $(".slider-range .tooltip.tooltip-min").append('<span class="slider-time-1">'+ $('#start_at').val() +'</span>');
            $(".slider-range .tooltip.tooltip-max").append('<span class="slider-time-2">'+ $('#end_at').val()  +'</span>');

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


                $('.slider-range .slider-time-2').html(hours2 + ':' + minutes2);


            });
        });


        console.log(start_at,end_at)

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


        function toMin(current_time){

            var current_min;

            if(current_time.slice(-2)=='AM'){

                if(current_time.slice(0,-5)=='12'){

                    current_min = 1440;

                    return current_min;

                }else {

                    current_min = parseInt(current_time.slice(0,-5))*60;

                    current_min = current_min+parseInt(current_time.slice(0,-2).slice(-2));

                    return current_min;

                }

            }else{

                if(current_time.slice(0,-5)=='12'){

                    current_min = 720+parseInt(current_time.slice(0,-2).slice(-2));

                    return current_min;

                }else {

                    current_min = 720+parseInt(current_time.slice(0,-5))*60;

                    current_min = current_min+parseInt(current_time.slice(0,-2).slice(-2));

                    return current_min;

                }

            }

        }






        $("#slider-range").on('change', function ( values, handle ) {
            var value = values['value']['newValue'];
            $('#start_at').val(toTime(value[0]));

            $('#end_at').val(toTime(value[1]));

        });

    </script>

@endsection