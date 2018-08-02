@extends('layout.masterForAuthUser')

@section('css')
    <style>
        .flying-panel{
            display: none;
            margin-left: 30%;
            margin-top: 1%;
            width: 40%;
            z-index: 99;
        }

        @media screen and (max-width: 1024px){
            .flying-panel{
                display: none;
                margin-left: 20%;
                margin-top: 1%;
                width: 60%;
                z-index: 99;
            }
        }

        @media screen and (max-width: 724px){
            .flying-panel{
                display: none;
                margin-left: 10%;
                margin-top: 1%;
                width: 80%;
                z-index: 99;
            }
        }

        @media screen and (max-width: 524px){
            .flying-panel{
                display: none;
                margin-left: 3%;
                margin-top: 1%;
                width: 94%;
                z-index: 99;
            }
        }



        @media (max-width: 575.98px){
            .wrapper-search-map .wrapper-one-links .row > div:last-child {
                padding: 0;
            }
        }


    </style>
@endsection

@section('content')
    <div class="row-content wrapper_map_frame">



        <div class="flex-item">

            <div class="wrapper-search-map">
                <div class="container">

                    <div class="form-group">
                        <label class="label-text">Enter Keyword:</label>
                        <div class="wrapper-two-links clearfix">
                            <a href="{{url('/volunteer/opportunity')}}" class="sitemap"><i class="fa fa-sitemap" aria-hidden="true"></i></a>
                            <div class="wrapper_input">
                                <input type="text" id="input_keyword_search" class="form-control" placeholder="" value="">
                            </div>
                            <a href="#" id="btn_keyword_search" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="wrapper-one-links clearfix">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label class="label-text">Opportunity Types:</label>
                                    <div class="wrapper_select">
                                        <select id="opp-checkbox" class="custom-dropdown opp-search-checkbox" multiple hidden>
                                            @foreach($op_type as $key=>$ot)


                                                <option value="{{$key}}" class="opp-search-checkbox oppr_li" id="opprtype{{$key}}">{{$ot['name']}} ({{$ot['count']}})</option>



                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6" style="padding: 0;">

                                    <label class="label-text">Organization Types:</label>
                                    <div class="wrapper_select">
                                        <select class="org-search-checkbox" multiple hidden>

                                            @foreach($og_type as $key=>$og)

                                                <option value="{{$key}}" class="org-search-checkbox oppr_li" id="orgtype{{$key}}">{{$og['name']}} ({{$og['count']}})</option>

                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <a href="#" class="calendar count-info" data-toggle="dropdown"  title="Opportunuties" id="datepicker">

                                    <div class="wrapper-calendar">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <div class="dropdown-date wrapper_input">
                                        <div class="sub-title text-left">Select Date Range</div>
                                        <input class="chose-date" id="start" name="start" type="text">
                                        <span class="buffer">-</span>
                                        <input class="chose-date" id="end" name="end" type="text">
                                    </div>
                                </a>
                            </div>


                        </div>
                    </div>






                </div>

            </div>

        </div>

        <div class="flex-item">

            <div class="modal-content flying-panel">
                <div class="modal-header">

                    <div class="main-text">
                        <h3 class="h3">We've found <strong class="green">0</strong> volunteer opportunities near</h3>
                        <p class="light mt-5">Please type the full location name, e.g. New York, NY</p>
                    </div>



                </div>
                <div class="modal-body">



                    <form id="search_opportunity" role="form" method="get" action="{{url('volunteer/opportunity/search')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">

                            <div class="wrapper-one-links clearfix">
                                <div  class="wrapper_input">

                                    <input id="input_search_loc" type="text" name="input_search_loc" placeholder="Sample: City, State" value="{{$search_addr['city']}}, {{$search_addr['state']}}">
                                </div>
                                <a id="btn_search_loc" href="#" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
                            </div>

                        </div>

                    </form>



                </div>
                <div class="modal-footer pb-0">



                </div>
            </div>

            <div class="google-map-space">

                <div class="google-map" id="big-map">
                    <input type="hidden" id="lat_val" value="{{$search_addr['lat']}}">
                    <input type="hidden" id="lng_val" value="{{$search_addr['lng']}}">
                </div>


            </div>
        </div>



    </div>

@endsection

{{--@include('components.auth.modal_pop_up_search_by_location')--}}

@section('script')

    <script src="{{asset('front-end/js/select2.full.js')}}"></script>
    <script src="{{asset('front-end/js/select2.multi-checkboxes.js')}}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es"></script>



    <script src="<?=asset('front-end/js/bootstrap-datepicker.js')?>"></script>

    <script src="<?=asset('js/plugins/datetimepicker/moment.js')?>"></script>




    <script>

        $(document).ready(function() {

            sendRequest()

            $('select').select2MultiCheckboxes({
                templateSelection: function(selected, total){return "Selected " + selected.length + " of " + total;},
                width: "auto"
            })

            $('#myModalSearchByLocation').modal('show');
        });

    </script>









    <script type="text/javascript">



        function sendRequest() {

            var opp_values = $('.opp-search-checkbox').val();

            var org_values = $('.org-search-checkbox').val();


            var start_Date = $('#start').val();

            var end_Date = $('#end').val();

            var location = $('#input_search_loc').val();

            var keyword = $('#input_keyword_search').val();



            var url = API_URL + 'volunteer/opportunity/getSearchResult';

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });



            console.log();

            var type = "get";

            var formData = {

                opp_types: opp_values,

                org_types: org_values,

                start_date: start_Date,

                end_date: end_Date,

                location: location,

                keyword: keyword,

            };

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {
                    if($('.calendar').hasClass('count-info open')){
                        $('.flying-panel').hide()

                    } else{
                        $('.flying-panel').show()
                    }
                    console.log(data)


                    $('.green').text(data.countOpp);



                    var myLatLng = {lat: parseFloat(data.search_addr['lat']),lng: parseFloat(data.search_addr['lng'])};

                    var mapOptions = {

                        zoom: 12,

                        center: myLatLng,

                        // Style for Google Maps

                        styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

                    };

                    // Get all html elements for map

                    var mapElement = document.getElementById('big-map');

                    // Create the Google Map using elements

                    var map = new google.maps.Map(mapElement, mapOptions);



                    $.each(data.opprs, function (index,value) {

                        var number = index+1;

                        if(value.logo_img == null){

                            logo = "<?=asset('front-end/img/org/001.png') ?>";

                        }else{

                            logo = "<?=asset('uploads') ?>/"+value.logo_img;

                        }




                        var OpLatLng = {lat: parseFloat(value[0]['lat']), lng: parseFloat(value[0]['lng'])};

                        var marker = new google.maps.Marker({

                            position: OpLatLng,

                            map: map,

                            icon: '{{asset('front-end/img/pin.png')}}',

                        });

                        var contentString = '<div class="map-modal-box"><div><div class="main-text">';

                        for (var i = 0; i < value.length; i++){
                            contentString = contentString +
                                '<p class="h3">'+value[i]['title']+'</p>'+
                                '<p><strong>Opportunity</strong></p> ' +
                                '<p>' +value[i]['description']+'</p> ' +
                                '<p class="light"> ' + value[i]['start_date'] +' '+ value[i]['street_addr1']+','+value[i]['city']+','+ value[i]['state']+ '</p> ' +
                                '<p><a href="{{url('/volunteer/view_opportunity')}}/' +value[i]['id']+ '">View opportunity info</a></p>';
                        }

                        contentString = contentString + '</div></div></div>';


                        var infowindow = new google.maps.InfoWindow({

                            content: contentString

                        });

                        marker.addListener('click', function() {

                            infowindow.open(map, marker);

                        });

                    });

                    $('.oppr_li').on('click',function () {

                        var op_id = $(this).val();

                        getLocation(op_id,data);

                    });

                },
                error: function (data) {
                    if($('.calendar').hasClass('count-info open')){
                        $('.flying-panel').hide()

                    } else{
                        $('.flying-panel').show()
                    }
                    console.log('Error:', data);

                }

            });



        }

        $('#btn_keyword_search').on('click',function(){

            sendRequest();

        });



        $('#input_keyword_search').keyup(function(e){

            if(e.keyCode == 13)

                sendRequest();

        });



        $('#btn_search_loc').on('click',function () {

            sendRequest();

        });



        $('.opp-search-checkbox').on('change',function () {

            sendRequest();

        });



        $('.org-search-checkbox').on('change',function () {

            sendRequest();

        });



        $('#start').on('change',function () {

            sendRequest();

        });



        $('#end').on('change',function () {

            sendRequest();

        });

        $('#btn_search_loc').on('click',function () {

            if($('#input_search_loc').val() != ''){

                $('#search_opportunity').submit();

            }

        });

        $('#input_search_loc').keyup(function(e){

            var ser_content = $('#input_search_loc').val();

            if(e.keyCode == 13)

            {

                if(ser_content != ''){

                    if($('#input_search_loc').val() != ''){

                        $('#search_opportunity').submit();

                    }

                }

            }

        });



        function getLocation(op_id, opp_data) {

            var url = API_URL + 'volunteer/find_opportunity_on_map';

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });



            console.log();

            var type = "POST";

            var formData = {

                opportunity_id: op_id,

            };

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {
                    if($('.calendar').hasClass('count-info open')){
                        $('.flying-panel').hide()

                    } else{
                        $('.flying-panel').show()
                    }
                    var myLatLng = {lat: parseFloat(data.result['lat']),lng: parseFloat(data.result['lng'])};

                    var mapOptions = {

                        zoom: 12,

                        center: myLatLng,

                        // Style for Google Maps

                        styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

                    };

                    // Get all html elements for map

                    var mapElement = document.getElementById('map');

                    // Create the Google Map using elements

                    var map = new google.maps.Map(mapElement, mapOptions);



                    $.each(opp_data.opprs, function (index,value) {

                        var number = index+1;

                        if(value.logo_img == null){

                            logo = "<?=asset('front-end/img/org/001.png') ?>";

                        }else{

                            logo = "<?=asset('uploads') ?>/"+value.logo_img;

                        }

                        var OpLatLng = {lat: parseFloat(value.lat), lng: parseFloat(value.lng)};

                        var marker = new google.maps.Marker({

                            position: OpLatLng,

                            map: map,

                            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+number+'|ff1100|ffffff',

                        });

                        var contentString = '<div class="map-modal-box">'+
                            '<div class="main-text">'+
                            '<p class="h3">'+value.title+'</p>'+
                            '<p><strong>Opportunity</strong></p> ' +
                            '<p>' +value.description+'</p> ' +
                            '<p class="light"> ' +value.start_date +' '+ value.street_addr1+','+value.city+','+value.state+ '</p> ' +
                            '<p><a href="{{url('/volunteer/view_opportunity')}}/' +value.id+ '">View opportunity info</a></p>'+
                            '</div>'+
                            '</div>';



                        var infowindow = new google.maps.InfoWindow({

                            content: contentString

                        });

                        if(op_id == value.id){

                            infowindow.open(map, marker);

                        }

                        marker.addListener('click', function() {

                            infowindow.open(map, marker);

                        });



                    })

                },

                error: function (data) {
                    if($('.calendar').hasClass('count-info open')){
                        $('.flying-panel').hide()

                    } else{
                        $('.flying-panel').show()
                    }
                    console.log('Error:', data);

                }

            });

        }





        $('.oppr_li').on('click',function () {

            var op_id = $(this).val();

            var url = API_URL + 'volunteer/find_opportunity_on_map';

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });



            console.log();

            var type = "POST";

            var formData = {

                opportunity_id: op_id,

            };

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {
                    var myLatLng = {lat: parseFloat(data.result['lat']),lng: parseFloat(data.result['lng'])};

                    var mapOptions = {

                        zoom: 12,

                        center: myLatLng,

                        // Style for Google Maps

                        styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

                    };

                    // Get all html elements for map

                    var mapElement = document.getElementById('map');

                    // Create the Google Map using elements

                    var map = new google.maps.Map(mapElement, mapOptions);



                        <?php $i=0; ?>

                            @foreach($opprs as $op)

                        <?php $i++; ?>

                    var OpLatLng{{$i}} = {lat: parseFloat({{$op->lat}}), lng: parseFloat({{$op->lng}})};

                    var marker{{$i}} = new google.maps.Marker({

                        position: OpLatLng{{$i}},

                        map: map,

                        icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld={{$i}}|ff1100|ffffff',

                    });

                    var contentString{{$i}} = '<div class="map-modal-box">'+
                        '<div class="main-text">'+
                        '<p class="h3">'+value.title+'</p>'+
                        '<p><strong>Opportunity</strong></p> ' +
                        '<p>' +value.description+'</p> ' +
                        '<p class="light"> ' +value.start_date +' '+ value.street_addr1+','+value.city+','+value.state+ '</p> ' +
                        '<p><a href="{{url('/volunteer/view_opportunity')}}/' +value.id+ '">View opportunity info</a></p>'+
                        '</div>'+
                        '</div>';



                    var infowindow{{$i}} = new google.maps.InfoWindow({

                        content: contentString{{$i}}

                    });



                    if(op_id == parseInt({{$op->id}})){

                        infowindow{{$i}}.open(map, marker{{$i}});

                    }

                    marker{{$i}}.addListener('click', function() {

                        infowindow{{$i}}.open(map, marker{{$i}});

                    });

                    @endforeach

                },

                error: function (data) {
                    console.log('Error:', data);

                }

            });

        });



        $('#search_address').on('click',function () {

            // $(this).hide();


            $('#input_search_loc').val($(this).text());

        })

        // When the window has finished loading google map



        var selector = '.explore-sidebar li';



        $(selector).on('click', function(){

            $(selector).removeClass('active');

            $(this).addClass('active');

        });



        $(document).on('click.bs.dropdown.data-api', '.dropdown', function (e) {

            e.stopPropagation();

        });





        $(function () {

            $('#start,#end').datetimepicker({

                useCurrent: false,

                minDate: moment(),

                ignoreReadonly: true,

                allowInputToggle: true,

                format: 'MM/DD/YYYY'

            });

            $('#start').change(function () {
                console.log(4222222222222222222222)
            })

            $('#start').datetimepicker().on('dp.change', function (e) {

                var incrementDay = moment(new Date(e.date));

                incrementDay.add(0, 'days');

                $('#end').data('DateTimePicker').minDate(incrementDay);

                sendRequest();

                //$(this).data("DateTimePicker").hide();

            });

            $('#end').datetimepicker().on('dp.change', function (e) {

                var decrementDay = moment(new Date(e.date));

                decrementDay.subtract(0, 'days');

                $('#start').data('DateTimePicker').maxDate(decrementDay);

                $(this).data("DateTimePicker").hide();

                sendRequest();

            });
        });

        $('#start').datepicker({
            'format': 'mm/dd/yyyy',
            'autoclose': true,
            'orientation': 'right',
            startDate: '+0d',
            'todayHighlight': true,
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('#end').datepicker('setStartDate', endDate);
        }).on('clearDate', function (selected) {
            $('#end').datepicker('setStartDate', '+0d');
        });

        $('#end').datepicker({
            'format': 'mm/dd/yyyy',
            startDate: '+0d',
        });

        $(document).ready(function () {

            $('.opp-search-selectall').click(function() {

                if ($(this).is(':checked')) {

                    $('#opp-checkbox input').attr('checked', true);

                } else {

                    $('#opp-checkbox input').attr('checked', false);

                }

            });

        });
        $('.calendar .wrapper-calendar').click(function () {
            $('.calendar').toggleClass('open')
        })

        $('.calendar').click(function () {
            if($(this).hasClass('count-info open')){
                $('.flying-panel').hide()

            } else{
                $('.flying-panel').show()
            }
        })
    </script>

@endsection

