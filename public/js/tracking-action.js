var $pagination = $('#activity_pagination'),
    totalRecords = 0,
    records = [],
    displayRecords = [],
    recPerPage = 10,
    page = 1,
    totalPages = 0;

$(document).ready(function() {

    // active_pagination();
    $('.table_activity, .footable').dataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "pageLength": 10,
        "pagingType": "full_numbers",
        "language": {
            "paginate": {
                "first": "",
                "next": '',
                "previous": '',
                "last": ''
            }
        }
    });
    /*$('.table_activity').footable({
        limitNavigation: 5,
        firstText: '1'
    });
    $('ul.pagination').each(function(){
        if (Math.abs((parseInt($(this).find('.footable-page:last a').data('page')) + 1) - parseInt($(this).find('.footable-page-arrow:last a').text())) < 0.01) $(this).find('.footable-page-arrow:last').hide();
        else $(this).find(' .footable-page-arrow:last').show();
    });

    $('.pagination').on('click', 'li a[data-page]', function () { //, .footable-page-arrow
        var pagination = $(this).parents('.tab-pane.active .pagination');
        if (pagination.find('.footable-page:first a').data('page') == 0) pagination.find('.footable-page-arrow:first').hide();
        else pagination.find('.footable-page-arrow:first').show();
        if (Math.abs((parseInt(pagination.find('.footable-page:last a').data('page')) + 1) - parseInt(pagination.find('.footable-page-arrow:last a').text())) < 0.01) pagination.find('.footable-page-arrow:last').hide();
        else pagination.find('.footable-page-arrow:last').show();
    });
    $('.footable').footable({
        limitNavigation: 5,
        lastText: '>>',
        //nextText: '>',
        //previousText: '<',
        firstText: '1'
    });*/
    handleOrgStatusChanged();
    handleOppStatusChanged();

    $('#start_time option[value="08:00"]').attr("selected",true);
    $('#end_time option[value="09:00"]').attr("selected",true);
    $('#external-events div.external-event').each(function() {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true, // maintain when user navigates (see docs on the renderEvent method)

        });

        // make the event draggable using jQuery UI
        // $(this).draggable({
        //     zIndex: 1111999,
        //     revert: true,      // will cause the event to go back to its
        //     revertDuration: 0  //  original position after the drag
        // });
    });

    /* initialize the calendar
     -----------------------------------------------------------------*/
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();


});

// $('#opp_date_div .input-group.date').datepicker({
//     todayBtn: "linked",
//     keyboardNavigation: false,
//     forceParse: false,
//     calendarWeeks: true,
//     autoclose: true,
// });

function handleOrgStatusChanged() {
    $('#org_not_exist').on('change', function () {
        $('#invalid_org_name_alert').hide();
        OrgtoggleStatus();
    });
}

function OrgtoggleStatus() {
    if ($('#org_not_exist').is(':checked')) {
        $('#org_name').attr('disabled', true);
        $('.org_email_div').show();
        $('.opp_div').hide();
        $('.opp_private_div').show();
        $('#opp_date_div').show();

    } else {
        $('#org_name').removeAttr('disabled');
        $('.org_email_div').hide();
        $('.opp_div').show();
        $('.opp_private_div').hide();
        $('#opp_date_div').hide();
    }
}

function handleOppStatusChanged() {
    $('#opp_not_exist').on('change', function () {
        $('#invalid_opp_name_alert').hide();
        OpptoggleStatus();
    });
}

function OpptoggleStatus() {
    if ($('#opp_not_exist').is(':checked')) {
        $('#opp_name').attr('disabled', true);
        $('.opp_private_div').show();
        $('#opp_date_div').show();

    } else {
        $('#opp_name').removeAttr('disabled');
        $('.opp_private_div').hide();
        $('#opp_date_div').hide();
    }
}

$('#opp_name').on('change',function () {
    $('#invalid_opp_name_alert').hide();
});

$('#org_name').on('change',function () {
    $('#invalid_org_name_alert').hide();
    var org_id = $(this).val();
    if(org_id != ''){
        var url = API_URL + 'volunteer/track/getOpportunities';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log();
        var type = "post";
        var formData = {
            org_id: org_id,
        }
        $.ajax({
            type: type,
            url: url,
            data: formData,
            success: function (data) {
                $('#opp_name').find('option')
                    .remove()
                    .end();
                // if(data.oppors != 'not exist'){
                $('#opp_name')
                    .append($("<option></option>"));
                $.each(data.oppor, function (index,value) {
                    $('#opp_name')
                        .append($("<option></option>")
                            .attr("value",value.id)
                            .text(value.title));
                });
                $(".select_opportunity").select2({
                    placeholder: "Select an Opportunity",
                    allowClear: true
                });
                //
                // }
                $('.opp_div').show();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
});

$(".select_organization").select2({
    placeholder: "Select an Organization",
    allowClear: true
});

$(".select_opportunity").select2({
    placeholder: "Select an Opportunity",
    allowClear: true
});

$('#btn_add_opp').on('click',function () {
    var flag = 0;
    var is_org_exist = 0;
    var is_opp_exist = 0;
    if ($('#checkbox_div').is(':checked')) {
        if($('#org_emails').val() == ''){
            $('#invalid_org_email_alert').show();
            flag++;
        }
        if($('#private_org_name').val() == ''){
            $('#invalid_private_name_alert').show();
            flag++;
        }
    }else{
        is_org_exist = 1;
        if($('#org_name').val() == ''){
            $('#invalid_org_name_alert').show();
            flag++;
        }
        if ($('#opp_not_exist').is(':checked')) {
            if($('#private_opp_name').val() == ''){
                $('#invalid_private_name_alert').show();
                flag++;
            }
        }else {
            is_opp_exist = 1;
            if($('#opp_name').val() == ''){
                $('#invalid_opp_name_alert').show();
                flag++;
            }
        }
    }

    if(flag == 0){
        if(is_org_exist == 0){
            $('#is_no_org').val(1);
            $('#add_opportunity').modal('hide');
            $('.opp_select_div').hide();
            $('.private_opp_div_add_hours').show();
            var private_opp = $('#private_org_name').val();
            $('#private_opp_name_hours').val(private_opp);
            $('#start_time').prop('disabled', false);
            $('#selected_date').val($('#end_date').val())
            $('#end_time').prop('disabled', false);
            $('#add_hours').modal('show')
        }else{
            var url = API_URL + 'volunteer/track/joinToOpportunity';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var org_id = $('#org_name').val();
            var opp_id = $('#opp_name').val();
            var opp_name = $('#opp_name option:selected').text();
            var org_email = $('#org_emails').val();
            var private_opp = $('#private_opp_name').val();
            var end_date = $('#end_date').val();

            var type = "post";
            var formData = {
                is_opp_exist: is_opp_exist,
                org_id: org_id,
                opp_id: opp_id,
                opp_name: opp_name,
                org_email: org_email,
                private_opp: private_opp,
                end_date: end_date,
            };

            $.ajax({
                type: type,
                url: url,
                data: formData,
                success: function (data) {
                    // location.reload();
                    var logo = SITE_URL+'front-end/img/org/001.png';
                    var currentdate = new Date();
                    var current_time = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+'-'+currentdate.getDate()+' '+currentdate.getHours() + ":"+ currentdate.getMinutes() + ":"+ currentdate.getSeconds();
                    var link = SITE_URL+'volunteer/view_opportunity/'+opp_id;

                    if(data.result == 'already exist'){
                        $('#opportunity_exist_alert').show()
                    }else if(data.result == 'public opportunity added'){
                        $('#external-events').append($('<li cclass="external-event navy-bg" value="'+opp_id+'"><a href="#"><span>'+opp_name+'</span></a></li>'));
                        $('#opp_id').append($('<option value="'+opp_id+'">'+opp_name+'</option>'));
                        $('#add_opportunity').modal('hide');

                        // if(data.opp_logo == null){
                        //     logo = SITE_URL+'img/logo/opportunity-default-logo.png';
                        // }else{
                        //     logo = SITE_URL+'uploads/'+data.opp_logo;
                        // }
                        // $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="'+logo+'"> <i class="fa fa-chain"></i>You Joined on Opportunity <a href="'+link+'"><strong>'+opp_name+'</strong></a></td><td>'+current_time+'</td></tr>'));
                        if($('#is_from_addhour').val()==1){
                            $('#opp_id').select2().select2('val',opp_id);
                            $('#add_hours').modal('toggle');
                        }
                        activityChange()
                    }else if(data.result == 'private opportunity added'){
                        $('#external-events').append($('<li cclass="external-event navy-bg" value="'+data.opp_id+'"><a style="background: #ff7a39" href="#"><span>'+private_opp+'</span></a></li>'));

                        $('#opp_id').append($('<option value="'+data.opp_id+'">'+private_opp+'</option>'));
                        $('#add_opportunity').modal('hide');

                        activityChange()

                        if($('#is_from_addhour').val()==1){
                            $('#opp_id').select2().select2('val',data.opp_id);
                            $('#add_hours').modal('toggle');
                        }
                    }
                    // active_pagination();
                    $('#external-events div.external-event').each(function() {

                        // store data so the calendar knows to render an event upon drop
                        $(this).data('event', {
                            title: $.trim($(this).text()), // use the element's text as the event title
                            stick: true, // maintain when user navigates (see docs on the renderEvent method)

                        });

                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 1111999,
                            revert: true,      // will cause the event to go back to its
                            revertDuration: 0  //  original position after the drag
                        });
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    }
});

$('.form-control').on('click',function () {
    $(this).css("border","1px solid #e5e6e7");
    $(this).parent().find('.p_invalid').hide();
});

// $('#start_time').on('change',function () {
//     var current_time = $(this).val();
//     var t = current_time.slice(0,2);
//     t = parseInt(t);
//     t = t+1;
//     if(t < 10){
//         var forward_time =  ("0"+t+current_time.slice(2));
//     }else{
//         var forward_time =  (t+current_time.slice(2));
//     }
//     if($('#end_time').val() < current_time){
//         $('#end_time option').filter(function() {
//             return ($(this).val() == forward_time); //To select Blue
//         }).prop('selected', true);
//     }else {
//         forward_time = $('#end_time').val();
//     }
//     var h = parseInt(forward_time.slice(0,2)) - parseInt(current_time.slice(0,2));
//     var m = parseInt(forward_time.slice(3)) - parseInt(current_time.slice(3));
//     if(m<0){
//         h = h-1;
//         m = 30;
//     }
//     var mins = h*60+m;
//     // $('#hours').text("("+h+"hrs "+m+"mins)");
//     $('#hours').text("("+mins+"mins)");
// });
//
// $('#end_time').on('change',function () {
//     var end_time = $(this).val();
//     var start_time = $('#start_time').val();
//     var t = start_time.slice(0,2);
//     t = parseInt(t);
//     t = t+1;
//     if(t < 10){
//         var forward_time =  ("0"+t+start_time.slice(2));
//     }else{
//         var forward_time =  (t+start_time.slice(2));
//     }
//     if(end_time < start_time){
//         $('#end_time option').filter(function() {
//             return ($(this).val() == forward_time); //To select Blue
//         }).prop('selected', true);
//     }else {
//         forward_time = end_time;
//     }
//     var h = parseInt(forward_time.slice(0,2)) - parseInt(start_time.slice(0,2));
//     var m = parseInt(forward_time.slice(3)) - parseInt(start_time.slice(3));
//     if(m<0){
//         h = h-1;
//         m = 30;
//
//     }
//     var mins = h*60+m;
//     // $('#hours').text("("+h+"hrs "+m+"mins)");
//     $('#hours').text("("+mins+"mins)");
// });
$('#opp_id').on('change',function () {
    $('#empty_opportunity_alert').hide();
});

// $('#btn_add_hours').on('click', function(e){
//     e.preventDefault();
//
//     var selected_date = $('#selected_date').val();
//     selected_date = selected_date.slice(0,10);
//     var opp_id = $('#opp_id').val();
//     var opp_name = $('#opp_id option:selected').text();
//     var logged_mins = $('#hours').text();
//     logged_mins = (logged_mins.slice(1)).slice(0,-5);
//     var start_time = $('#start_time').val();
//     var end_time = $('#end_time').val();
//     var adding_hours_comments = $('#adding_hours_comments').val();
//    // var adding_hours_comments = $('#comments1').val();
//     var tracking_id = $('#track_id').val();
//     var is_edited = $('#is_edit').val();
//     var is_no_org = $('#is_no_org').val();
//     if(is_no_org == 1){
//         opp_id = 'private';
//     }
//     var private_opp_name = $('#private_opp_name_hours').val();
//     var org_email = $('#org_emails').val();
//     if(opp_id != ''){
//         $('#btn_add_hours').prop('disabled', true);
//         var url = API_URL + 'volunteer/track/addHours';
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         console.log();
//         var type = "post";
//         var formData = {
//             opp_id: opp_id,
//             opp_name: opp_name,
//             start_time: start_time,
//             end_time: end_time,
//             logged_mins: logged_mins,
//             selected_date: selected_date,
//             comments: adding_hours_comments,
//             is_edit: is_edited,
//             tracking_id: tracking_id,
//             is_no_org: is_no_org,
//             private_opp_name: private_opp_name,
//             org_email: org_email,
//         };
//         $.ajax({
//             type: type,
//             url: url,
//             data: formData,
//             success: function (data) {
//                 if(data.result == 'approved track'){
//                     $('.confirmed_track').show();
//                 }else if(data.result == 'declined track') {
//
//                 }else{
//                     if(data.opp_logo == null){
//                         var logo = SITE_URL+'img/logo/opportunity-default-logo.png';
//                     }else{
//                         var logo = SITE_URL+'uploads/'+data.opp_logo;
//                     }
//                     var currentdate = new Date();
//                     var current_time = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+'-'+currentdate.getDate()+' '+currentdate.getHours() + ":"+ currentdate.getMinutes() + ":"+ currentdate.getSeconds();
//                     var current_date = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+'-'+currentdate.getDate();
//                     var url = SITE_URL+'volunteer/view_opportunity/'+opp_id;
//                     if(data.is_link_exist == 1){
//                         var link = '<a href="'+url+'"><strong>'+opp_name+'</strong></a>';
//                     }else{
//                         if(is_no_org ==0){
//                             var link = '<strong>'+opp_name+'</strong>';
//                         }else{
//                             var link = '<strong>'+private_opp_name+'</strong>';
//                         }
//                     }
//                     if(is_edited == 0){
//                         $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="'+logo+'"> <i class="fa fa-reply"></i>You Added '+logged_mins+'mins on Opportunity '+link+'</td><td>'+current_time+'</td></tr>'));
//
//                         $('.table_pending_view').prepend($('<tr class="pending-approval" id="pending'+tracking_id+'"><td style="text-align: left; padding-left: 20px"><img alt="image" class="img-circle" src="'+logo+'"> '+link+'</td><td>'+selected_date+'</td><td>'+start_time+'</td><td>'+end_time+'</td><td>'+logged_mins+'</td><td>'+current_date+'</td><td class="label label-warning" style="display: table-cell; font-size:13px;">Pending</td></tr>'));
//                     }else {
//                         $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="'+logo+'"> <i class="fa fa-reply"></i>You Updated Logged Hours to '+logged_mins+'mins on Opportunity '+link+'</td><td>'+current_time+'</td></tr>'));
//                         $('#'+'pending'+tracking_id).remove();
//                         $('.table_pending_view').prepend($('<tr class="pending-approval" id="pending'+tracking_id+'"><td style="text-align: left; padding-left: 20px"><img alt="image" class="img-circle" src="'+logo+'"> '+link+'</td><td>'+selected_date+'</td><td>'+start_time+'</td><td>'+end_time+'</td><td>'+logged_mins+'</td><td>'+current_date+'</td><td class="label label-warning" style="display: table-cell; font-size:13px;">Pending</td></tr>'));
//                     }
//                     active_pagination();
//                     doSubmit(data.track_id);
//                 }
//             },
//             error: function (data) {
//                 console.log('Error:', data);
//             }
//         });
//     }else {
//         $('#empty_opportunity_alert').show();
//     }
// });

function doSubmit(track_id){
    $("#add_hours").modal('hide');
    var selected_val = $('#selected_date').val();
    var date_val = selected_val.slice(0,11);
    var ext_val = selected_val.slice(16);

    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var start_val = date_val.concat(start_time,ext_val);
    var end_val = date_val.concat(end_time,ext_val);
    var comments = $('#adding_hours_comments').val();

    var is_no_org = $('#is_no_org').val();
    var title = $('#opp_id option:selected').text();
    if(is_no_org == 1){
        title = $('#private_opp_name_hours').val();
    }

}

$('#btn_remove_hours').on('click',function (e) {
    e.preventDefault()
    var tracking_id = $('#track_id').val();
    var opp_id = $('#opp_id').val();
    var opp_name = $('#opp_id option:selected').text();
    if($('#is_no_org').val() == 1){
        opp_id = 0;
        opp_name = $('#private_opp_name_hours').val();
    }
    var url = API_URL + 'volunteer/track/removeHours';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log();
    var type = "post";
    var formData = {
        tracking_id: tracking_id,
    };
    console.log(formData);
    var supThis = this
    $.ajax({
        type: type,
        url: url,
        data: formData,
        success: function (data) {
            location.reload()
            $('#calendar').calendar('removeEvents',data.result);
            $("#add_hours").modal('hide');
            if(data.opp_logo == null){
                var logo = SITE_URL+'front-end/img/org/001.png';
            }else{
                var logo = SITE_URL+'uploads/'+data.opp_logo;
            }
            var currentdate = new Date();
            var current_time = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+'-'+currentdate.getDate()+' '+currentdate.getHours() + ":"+ currentdate.getMinutes() + ":"+ currentdate.getSeconds();
            var url = SITE_URL+'volunteer/view_opportunity/'+opp_id;
            if(data.is_link_exist != 1){
                var link = '<strong>'+opp_name+'</strong>';
            }else{
                var link = '<a href="'+url+'"><strong>'+opp_name+'</strong></a>';
            }
            $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="'+logo+'"> <i class="fa fa-trash"></i>You removed Logged Hours on Opportunity '+link+'</td><td>'+current_time+'</td></tr>'));

            $('#'+'pending'+tracking_id).remove();
            // active_pagination();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

// $('#action_range').change(function () {
//     active_pagination();
// });

$('#add_on_addtime').on('click',function () {
    $('#is_from_addhour').val(1);
    $(".select_organization").select2('val','');
    $('#org_emails').val('');
    $('.org_email_div').hide();
    $('.opp_div').hide();
    $('.opp_private_div').hide();
    $('#opp_date_div').hide();
    $('#org_not_exist').attr('checked', false);
    $('#opp_not_exist').attr('checked', false);
    $('#org_name').attr('disabled', false);
    $('#opp_name').attr('disabled', false);
    $('#private_opp_name').val('');
    $('#end_date').val('');
});

$('.add_opportunity_dlg').on('click',function () {
    $('#is_from_addhour').val(0);
    $('#is_no_org').val(0);
    $(".select_organization").select2('val','');
    $('#org_emails').val('');
    $('.private_opp_div').hide();
    $('.org_email_div').hide();
    $('.opp_div').hide();
    $('.opp_private_div').hide();
    $('#opp_date_div').hide();
    $('#org_not_exist').attr('checked', false);
    $('#opp_not_exist').attr('checked', false);
    $('#org_name').attr('disabled', false);
    $('#opp_name').attr('disabled', false);
});

function active_pagination() {
    $('.track-activity-panel').empty();

    var range = $('#action_range').val();
    var url = API_URL + 'volunteer/track/activityView';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log();
    var type = "get";
    var formData = {
        range: range,
    };

    $.ajax({
        url: url,
        type: type,
        data: formData,
        success: function (data) {
            records = data.activity;
            totalRecords = records.length;
            totalPages = Math.ceil(totalRecords / recPerPage);
            apply_pagination();
        }
    });

    function apply_pagination() {
        $('#example').footable({
            limitNavigation: 5,
            firstText: '1'
        });
        $('ul.pagination').each(function(){
            if (Math.abs((parseInt($(this).find('.footable-page:last a').data('page')) + 1) - parseInt($(this).find('.footable-page-arrow:last a').text())) < 0.01) $(this).find('.footable-page-arrow:last').hide();
            else $(this).find(' .footable-page-arrow:last').show();
        });

        $('.pagination').on('click', 'li a[data-page]', function () { //, .footable-page-arrow
            var pagination = $(this).parents('.tab-pane.active .pagination');
            if (pagination.find('.footable-page:first a').data('page') == 0) pagination.find('.footable-page-arrow:first').hide();
            else pagination.find('.footable-page-arrow:first').show();
            if (Math.abs((parseInt(pagination.find('.footable-page:last a').data('page')) + 1) - parseInt(pagination.find('.footable-page-arrow:last a').text())) < 0.01) pagination.find('.footable-page-arrow:last').hide();
            else pagination.find('.footable-page-arrow:last').show();
        });
        /*$pagination.twbsPagination('destroy');
        $pagination.twbsPagination({
            totalPages: totalPages,
            visiblePages: 5,
            onPageClick: function (event, page) {
                displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                endRec = (displayRecordsIndex) + recPerPage;
                displayRecords = records.slice(displayRecordsIndex, endRec);
                generate_table();
            }
        });*/

    }

    function generate_table() {
        $('.track-activity-panel').empty();
        for (var i = 0; i < displayRecords.length; i++) {
            if( displayRecords[i].opp_logo == null){
                var logo = SITE_URL+'front-end/img/org/001.png';
            }else{
                var logo = SITE_URL+'uploads/'+ displayRecords[i].opp_logo;
            }
            if( displayRecords[i].type == 2 ||  displayRecords[i].type == 3)
                var icon = 'fa-reply';
            else if( displayRecords[i].type == 1)
                var icon = 'fa-chain';
            else if( displayRecords[i].type == 4)
                var icon = 'fa-trash';
            else if( displayRecords[i].type == 5)
                var icon = 'fa-certificate';
            if( displayRecords[i].link == 1){
                var url = SITE_URL+'volunteer/view_opportunity/'+ displayRecords[i].oppor_id;
                var link = "<a href="+url+"><strong>"+displayRecords[i].oppor_title+"</strong></a>";
            }else{
                var link = '<strong>'+ displayRecords[i].oppor_title+'</strong>';
            }
            $('.track-activity-panel').append($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="'+logo+'"> <i class="fa '+icon+'"></i>'+displayRecords[i].content+' '+link+'</td><td>'+displayRecords[i].updated_at+'</td></tr>'));
        }
    }
}