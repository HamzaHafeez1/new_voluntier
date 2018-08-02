jQuery(document).ready(function () {
$('#btn_agree').on('click',function () {
    $('#o_accept_terms').prop('checked', true);
    $('#v_accept_terms').prop('checked', true);
});

$(document).ready(function () {
    $('.forgot_user_success').hide();
    $('.forgot_password_success').hide();

});

$('#btn_next').on('click',function(){
    var level = $('#level').val();
    level = parseInt(level)+1;
    $('#level').val(level);

    $('.reg-first').hide();
    $('#btn_prev').show();
    if($('select[name=account]').val() == 'Volunteer'){
        $('.reg-second').show();
        $('.reg-third').hide();
        $(this).hide();
        $('#btn_regs').show();
    }else{
        if(parseInt($('#level').val())==1){
            $('.reg-select-org').show();
            $('.reg-second').hide();
            $('.reg-third').hide();
        }else if(parseInt($('#level').val())==2){
            if($('select[name=org_type]').val() == 1){
                $('.school-type').show();
                $('.non-org-type').hide();
                $('.ein-field').hide();
                $('#p_org_name').text('School Name');
            }
            if($('select[name=org_type]').val() == 2){
                $('.school-type').hide();
                $('.non-org-type').hide();
                $('.ein-field').show();
                $('#p_org_name').text('Organization Name');
            }
            if($('select[name=org_type]').val() == 3){
                $('.school-type').hide();
                $('.non-org-type').show();
                $('.ein-field').hide();
                $('#p_org_name').text('Organization Name');
            }
            if($('select[name=org_type]').val() == 4){
                $('.school-type').hide();
                $('.non-org-type').hide();
                $('.ein-field').hide();
                $('#p_org_name').text('Organization Name');
            }
            $('.reg-select-org').hide();
            $('.reg-second').hide();
            $('.reg-third').show();
            $(this).hide();
            $('#btn_regs').show();
        }
    }
});

$('#btn_prev').on('click',function(){
    var level = $('#level').val();
    level = parseInt(level)-1;
    $('#level').val(level);

    if($('select[name=account]').val() == 'Volunteer'){
        $('.reg-first').show();
        $('.reg-second').hide();
        $('.reg-select-org').hide();
        $('.reg-third').hide();
        $(this).hide();
        $('#btn_regs').hide();
        $('#btn_next').show();
    }else{
        if(parseInt($('#level').val())==1){
            $('.reg-select-org').show();
            $('.reg-second').hide();
            $('.reg-third').hide();
            $(this).show();
            $('#btn_regs').hide();
            $('#btn_next').show();
        }else{
            $('.reg-first').show();
            $('.reg-second').hide();
            $('.reg-select-org').hide();
            $('.reg-third').hide();
            $(this).hide();
            $('#btn_regs').hide();
            $('#btn_next').show();
        }
    }
});

$('#v_confirm').on('change',function () {
    if($('#v_password').val() != $(this).val()){
        $(this).css("border","1px solid #ff0000");
    }
});

$('#o_confirm').on('change',function () {
    if($('#o_password').val() != $(this).val()){
        $(this).css("border","1px solid #ff0000");
    }
});

$('.btn_regs').on('click',function(){
    var vol_flags = 0;
    var org_flags = 0;
    if($('.type-user').val() == 'Volunteer'){
        if ($("#v_user_name").val() == ''){
            $("#v_user_name").addClass("error-has");
            vol_flags++;
        }
        else{
            $("#v_user_name").removeClass("error-has");
        }

        if($('#first_name').val()==''){
            $('#first_name').addClass("error-has");
            vol_flags++;
        }
        else{
            $('#first_name').removeClass("error-has");
        }

        if($('#last_name').val()=='') {
            $('#last_name').addClass("error-has");
            vol_flags++;
        }else{
            $('#last_name').removeClass("error-has");
        }

        if($('#birth_day').val()=='') {
            $('#birth_day').addClass("error-has");
            vol_flags++;
        }else{
            $('#birth_day').removeClass("error-has");
        }


        if($('#birth_day').val()!='') {
             var birthday = $('#birth_day').val();
             var now = new Date();
             var past = new Date(birthday);
             var nowYear = now.getFullYear();
             var pastYear = past.getFullYear();
             var age = nowYear - pastYear;
             if(age<13){
               vol_flags++;
               $('#v_invalid_age').show();
             }
             else{
                 $('#v_invalid_age').hide();
             }
                // alert(age);
        }

        if($('#v_zipcode').val()=='') {
            $('#v_zipcode').addClass("error-has");

            vol_flags++;
        }else{
            $('#v_zipcode').removeClass("error-has");
        }
        if (!ValidateZipcode($('#v_zipcode').val())) {
            vol_flags++;
            $('#v_invalid_zipcode_alert').show();
        }else{
            $('#v_invalid_zipcode_alert').hide();
            $('#v_invalid_zipcode_alert').removeClass("error-has");
        }

        if($('#v_email').val()=='') {
            $('#v_email').addClass("error-has");
            vol_flags++;
        }else{
            $('#v_email').removeClass("error-has");
        }

        if (!ValidateEmail($('#v_email').val())) {
            vol_flags++;
            $('#v_invalid_email_alert').show();
        }else{
            $('#v_invalid_email_alert').hide();
        }

        if($('#v_contact_num').val()=='') {
            $('#v_contact_num').addClass("error-has");
            vol_flags++;
        }else{
            $('#v_contact_num').removeClass("error-has");
        }

        if (!ValidatePhonepumber($('#v_contact_num').val())) {
            vol_flags++;
            $('#v_invalid_contact_number').show();
        }
        else{
            $('#v_invalid_contact_number').hide();
            $('#v_invalid_zipcode_alert').removeClass("error-has");
        }

        if($('#v_password').val()=='') {
            $('#v_password').addClass("error-has");
            vol_flags++;
        }else{
            $('#v_password').removeClass("error-has");
        }


        if (!ValidatePassword($('#v_password').val())) {
            vol_flags++;
            $('#v_invalid_password').show();
        }else{
            $('#v_invalid_password').hide();
            $('#v_invalid_password').removeClass("error-has");
        }

        if($('#v_confirm').val() != $('#v_password').val()) {
            $('#v_confirm').addClass("error-has");
            vol_flags++;
        } else{
            $('#v_confirm').removeClass("error-has");
            $('#v_confirm').css("border", '');
        }


        if($("#verify_aga").is(":not(:checked)")){
            $("#verify_age_alert").show();
            $("#verify_age_alert").css("color","red");
            vol_flags++;
        } else{
            $("#verify_age_alert").hide();
            $('#verify_age_alert').removeClass("error-has");
        }

        if ($('.years-old-check-value').val() == 0){

        }else{
            $('.years-old-check-value').removeClass("error-has");
        }

        if ($('.terms-conditions-vol').val() == 0){

        }else{
            $('.years-old-check-value').removeClass("error-has");
        }
        if($("#v_accept_terms").is(":not(:checked)")){
            $("#v_terms_alert").show();
            $("#v_terms_alert").css("color","red");
            vol_flags++;
        }else{
            $('#v_terms_alert').removeClass("error-has");
        }



        if(vol_flags == 0){

            var url = API_URL + 'reg_volunteer';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            var type = "POST";
            var formData = {
                user_name: $("#v_user_name").val(),
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                birth_day: $('#birth_day').val(),
                zipcode: $('#v_zipcode').val(),
                email: $('#v_email').val(),
                contact_number: $('#v_contact_num').val(),
                password: $('#v_password').val(),
                gender: $("input[name='gender']:checked").val(),
            };
            $.ajax({
                type: type,
                url: url,
                data: formData,
                success: function (data) {
                    if(data.result == 'username exist'){
                        $('#v_invalid_username_alert').show();
                        $("#v_user_name").val('');
                    }
                    if(data.result == 'email exist'){
                        $('#v_existing_email_alert').show();
                        $("#v_email").val('');
                    }
                    if(data.result == 'invalid zipcode'){
                        $('#v_location_zipcode_alert').show();
                        $("#v_zipcode").val('');
                    }
                    if(data.result == 'success'){
                        $('#myModalSuccessfulReg').modal('show')

                        $('.close').click();
                        $('#myModalSingVolRegistration').hide();
                        $('#btn_prev').hide();
                        $('#btn_regs').hide();
                        $('.reg-forth').show();
                        $('#btn_ok').show();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    }else {
        if ($("#o_user_name").val() == ''){
            $("#o_user_name").css("border","1px solid #ff0000");
            org_flags++;
        }
        if ($("#org_name").val() == ''){
            $("#org_name").css("border","1px solid #ff0000");
            org_flags++;
        }
        if ($("#found_day").val() == ''){
            $("#found_day").css("border","1px solid #ff0000");
            org_flags++;
        }
        if ($("#o_zipcode").val() == ''){
            $("#o_zipcode").css("border","1px solid #ff0000");
            org_flags++;
        }
        if (!ValidateZipcode($('#o_zipcode').val())) {
            org_flags++;
            $('#o_invalid_zipcode_alert').show();
        }
        if ($("#o_email").val() == ''){
            $("#o_email").css("border","1px solid #ff0000");
            org_flags++;
        }
        if (!ValidateEmail($('#o_email').val())) {
            org_flags++;
            $('#o_invalid_email_alert').show();
        }
        if ($("#o_contact_num").val() == ''){
            $("#o_contact_num").css("border","1px solid #ff0000");
            org_flags++;
        }
        if (!ValidatePhonepumber($('#o_contact_num').val())) {
            org_flags++;
            $('#o_invalid_contact_number').show();
        }
        if ($("#o_password").val() == ''){
            $("#o_password").css("border","1px solid #ff0000");
            org_flags++;
        }
        if (!ValidatePassword($('#o_password').val())) {
            org_flags++;
            $('#o_invalid_password_alert').show();
        }
        if ($("#o_confirm").val() == ''){
            $("#o_confirm").css("border","1px solid #ff0000");
            org_flags++;
        }
        if($("#o_accept_terms").is(":not(:checked)")){
            $("#o_terms_alert").show();
            $("#o_terms_alert").css("color","red");
            org_flags++;
        }
        if($('#o_password').val() != $('#o_confirm').val()){
            org_flags++;
        }

        if(org_flags == 0){
            var url = API_URL + 'reg_organization';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var type = "POST";
            var formData = {
                user_name: $("#o_user_name").val(),
                org_name: $('#org_name').val(),
                school_type: $('#school_type option:selected').val(),
                ein: $('#org_ein').val(),
                nonprofit_org_type: $('#non_org_type').val(),
                birth_day: $('#found_day').val(),
                zipcode: $('#o_zipcode').val(),
                type: $( "#org_type option:selected" ).val(),
                email: $('#o_email').val(),
                contact_number: $('#o_contact_num').val(),
                password: $('#o_password').val(),
            }
            $.ajax({
                type: type,
                url: url,
                data: formData,
                success: function (data) {
                    if(data.result == 'username exist'){
                        $('#o_invalid_username_alert').show();
                        $("#o_user_name").val('');
                    }
                    if(data.result == 'email exist'){
                        $('#o_existing_email_alert').show();
                        $("#o_email").val('');
                    }
                    if(data.result == 'invalid zipcode'){
                        $('#o_location_zipcode_alert').show();
                        $("#o_zipcode").val('');
                    }
                    if(data.result == 'success'){
                        $('#myModalSuccessfulReg').modal('show')
                        $('.close').click();
                        $('#myModalSingOrgRegistration').hide();
                        $('.reg-third').hide();
                        $('#btn_prev').hide();
                        $('#btn_regs').hide();
                        $('.reg-forth').show();
                        $('#btn_ok').show();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    }
});

$('#btn_login_l').on('click',function() {

    var count = 0;
    if ($("#login_user").val() == ''){
        $("#login_user").css("border", "1px solid #ff0000");
        count++;
    }
    else
    {
        $("#login_user").css("border", "");
    }
    if ($("#login_password").val() == '')
    {
        $("#login_password").css("border", "1px solid #ff0000");
         count++;
    }
    else{
        $("#login_password").css("border", "");
    }
    if(count>0)
    {
        return false;
    }

    var url = API_URL + 'login_user';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    var type = "POST";
    var formData = {
        user_id: $("#login_user").val(),
        password: $("#login_password").val(),
    }
    $.ajax({
        type: type,
        url: url,
        data: formData,
        success: function (data) {
            if(data.result == 'invalid'){
                $('#password_not_match').show();
                $("#login_user").val('');
                $("#login_password").val('');
            }
            if(data.result == 'not_confirmed'){
                $('#confirm_not_match').show();
            }
            if(data.result == 'volunteer'){
                window.location.replace(SITE_URL+'volunteer');
            }
            if(data.result == 'organization'){
                window.location.replace(SITE_URL+'organization');
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

$('#forgot_user').on('click',function() {
    if ($("#get_user_email").val() == '')
        $("#get_user_email").css("border", "1px solid #ff0000");
    var url = API_URL + 'forgot_username';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    var type = "POST";
    var formData = {
        email: $("#get_user_email").val(),
    }
    $.ajax({
        type: type,
        url: url,
        data: formData,
        success: function (data) {
            if(data.result == 'success'){
                $('.forgot_user_form').hide();
                $('.forgot_user_success').show();
                $('#forgot_user').hide();
                $('#forgot_user_close').show();
            }
            if(data.result == 'email_not_exist'){
                $('#forgot_user_invalid_email').show();
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

$('#forgot_password_close').on('click', function () {
    $("#myModalForgotPassword").modal('hide');
});

$('#forgot_password').on('click',function() {
    if ($("#get_password_email").val() == '')
        $("#get_password_email").css("border", "1px solid #ff0000");
    var url = API_URL + 'forgot_password';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    var type = "POST";
    var formData = {
        email: $("#get_password_email").val(),
    }
    $.ajax({
        type: type,
        url: url,
        data: formData,
        success: function (data) {
            if(data.result == 'success'){
                $('.forgot_password_form').hide();
                $('.forgot_password_success').show();
                $('#forgot_password').hide();
                $('#forgot_password_invalid_email').hide()
                $('#forgot_password_close').show();
                $('.input-email').hide()
                $('.lab-email').hide()
            }
            if(data.result == 'email_not_exist'){
                $('#forgot_password_invalid_email').show();
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

$("#o_accept_terms").on('click',function () {
    $("#o_terms_alert").hide();
});

$("#verify_aga").on('click',function () {
    $("#verify_age_alert").hide();
});

$("#v_accept_terms").on('click',function () {
    $("#v_terms_alert").hide();
});

$('.form-control').on('click',function () {
    $(this).css("border","1px solid #e5e6e7");
    $(this).parent().find('.p_invalid').hide();
});

var cbpAnimatedHeader = (function() {
    var docElem = document.documentElement,
        header = document.querySelector( '.navbar-default' ),
        didScroll = false,
        changeHeaderOn = 200;
    function init() {
        window.addEventListener( 'scroll', function( event ) {
            if( !didScroll ) {
                didScroll = true;
                setTimeout( scrollPage, 250 );
            }
        }, false );
    }
    function scrollPage() {
        var sy = scrollY();
        if ( sy >= changeHeaderOn ) {
            $(header).addClass('navbar-scroll')
        }
        else {
            $(header).removeClass('navbar-scroll')
        }
        didScroll = false;
    }
    function scrollY() {
        return window.pageYOffset || docElem.scrollTop;
    }
    init();

})();
});
// Activate WOW.js plugin for animation on scrol
// new WOW().init();