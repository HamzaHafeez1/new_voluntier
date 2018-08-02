@extends('layout.masterForAuthUser')


@section('css')
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('css/chat.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.bxslider.css')}}">
@endsection

@section('content')
    <div class="row-content wrapper-chat-box">


        <!-- -->
        <!-- -->
        <!-- -->

        <div class="wraper_ie_frame">

            <div class="space_frame">
            </div>
            <div id="frame" class="frame">
                <div id="sidepanel" class="sidepanel">

                    <div class="search">
                        <label><span class="gl-icon-search"></span></label>
                        <input type="text" placeholder="Search&hellip;" id="contacts-search">
                    </div>

                    <div class="top-bar"><ul class="tabs">
                            <li><a href="#groups" class="active"><span>Groups</span></a></li>
                            <li><a href="#organizations"><span>Opportunities</span></a></li>
                            <li><a href="#friends"><span>Friends</span></a></li>
                        </ul></div>

                    <div id="groups" class="contacts">
                        <ul>

                        </ul>
                    </div>

                    <div id="organizations" class="contacts">
                        <ul>

                        </ul>
                    </div>

                    <div id="friends" class="contacts">
                        <ul>

                        </ul>
                    </div>

                </div>
                <div class="content">
                    <div class="contact-profile">
                        <p id="chat-title"><a href="#" class="navtoggler"><span>Menu</span></a> <span></span></p>
                        {{--<button type="button" id="addchat">Add chat</button>--}}
                    </div>
                    <div class="messages" id="messages">
                        <ul>

                        </ul>
                    </div>
                    <div class="message-input">
                        <div class="wrap clearfix">
                            <textarea placeholder="Enter your message here&hellip;" id="message"></textarea>
                            <input type="file" id="attachment_file" style="display:none;" name="attachment"/>
                            <a href="#" id="attachment" class="attachment"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                            <a href="#" class="submit" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidepanel-backdrop"></div>
            </div>

        </div>

@endsection

@section('script')

            <script src="/js/jquery.fancybox.js"></script>
            <script src="//sdk.amazonaws.com/js/aws-sdk-2.251.1.min.js"></script>

            <script>

                $(document).ready(function() {

                    var $outerwidth = $('.row-header header .outer-width-box');
                    var $innerwidth = $('.row-header header .inner-width-box');

                    function checkWidth() {

                        var outersize = $outerwidth.width();
                        var innersize = $innerwidth.width();

                        if( innersize > outersize) {

                            $('body').addClass("navmobile");

                        } else {

                            $('body').removeClass("navmobile");
                            $('body').removeClass("offcanvas-menu-show");

                        }


                    }

                    checkWidth();
                    $(window).resize(checkWidth);

                    $('.offcanvas-menu-backdrop').on('click', function(e) {
                        $('body').toggleClass("offcanvas-menu-show");
                        e.preventDefault();
                    });

                    $('.wrapper_bottom_footer > .row-header-mobile header a.navtoggler').on('click', function(e) {
                        $('body').toggleClass("offcanvas-menu-show");
                        e.preventDefault();
                    });

                    $(document).on('click', '#groups > ul > li, #organizations > ul > li, #friends > ul > li', function () {
                        $('.frame').removeClass('sidepanel-show');
                        console.log(4)
                    })
                });

            </script>

            <script>
                var albumBucketName = 'my-voluntier-chat-files';
                var bucketRegion = 'us-east-2';
                var IdentityPoolId = 'us-east-2:55c2009a-c0d2-4a37-8b13-3e27085134d6';

                AWS.config.update({
                    region: bucketRegion,
                    credentials: new AWS.CognitoIdentityCredentials({
                        IdentityPoolId: IdentityPoolId
                    })
                });

                var s3 = new AWS.S3({
                    apiVersion: '2006-03-01',
                    params: {Bucket: albumBucketName}
                });
            </script>


            <script>
                var user = {};
                var cid;
                var current = null;
                $(document).ready(function() {
                    $.get('<?php echo route('chat-token', ['uid' => Auth::user()->user_name])?>', function(token){
                        chat.login(token, function(data){
                            chat.getUser(data.uid, function(usr){
                                user = usr.val();
                                if(user == null)
                                {
                                    user = chat.addUser('{{Auth::user()->user_role === 'organization' ? Auth::user()->org_name : Auth::user()->getFullNameVolunteer()}}', '{{asset('uploads/' . Auth::user()->logo_img)}}', data.uid);
                                }
                                chat.getUserChats(user.Id, function(chats){
                                    chats = chats.val();
                                    var userChats = JSON.parse(window.sessionStorage.getItem('userChats'));
                                    for(var type in chats) {
                                        $('#' + type + ' ul').html('');
                                        var remove = '';
                                        if(type == 'friends')
                                        {
                                            remove = '<a href="javascript:void(0);" class="times delete-chat"><span>&times;</span></a>';
                                        }
                                        for (var c in chats[type]) {
                                            var photo = '';
                                            if(userChats == null || typeof userChats[c] == 'undefined')
                                            {
                                                chat.getChat(c, function(ct){
                                                    var userChats = JSON.parse(window.sessionStorage.getItem('userChats'));
                                                    if(userChats == null) userChats = {};
                                                    ct = ct.val();
                                                    if(ct == null) return;
                                                    userChats[ct.Id] = ct;
                                                    window.sessionStorage.setItem('userChats', JSON.stringify(userChats));
                                                    var photo = ct.photo;
                                                    if(typeof ct[user.Id] != 'undefined' && ct[user.Id] != null) photo = ct[user.Id];
                                                    $('#' + ct.Id + ' .avatar').css('background-image', "url('" + photo + "')");
                                                });
                                            }
                                            else {
                                                photo = userChats[c].photo;
                                                if(typeof userChats[c][user.Id] != 'undefined' && userChats[c][user.Id] != null) photo =  userChats[c][user.Id];
                                            }

                                            var group = '<li class="contact" id="' + c + '" data-chat-id="' + c + '">\
                                                <div class="wrap">\
                                                <div class="avatar" style="background-image:url(\'' + photo + '\')"><span class="badge" style="display:none;">0</span></div>\
                                                <div class="meta">\
                                                <p class="name">' + chats[type][c] + '</p>\
                                                </div>\
                                                </div>' + remove + '</li>';
                                            $('#' + type + ' ul').append(group);
                                            chat.getUnreadCount(user.Id, c, function(unread){
                                                unread = unread.val();
                                                if(unread != null && unread.unread > 0){
                                                    if(typeof cid != 'undefined' && cid != null && unread.chatId == cid.Id)
                                                    {
                                                        $('#' + unread.chatId + ' .badge').hide();
                                                        chat.updateUnreadCount(user.Id, cid.Id, 0);
                                                        $('#unread_' + cid.Id).remove();
                                                        $('#message-box .badge').text($('#unread-messages-list li').length);
                                                    }
                                                    else {
                                                        $('#' + unread.chatId + ' .badge').text(unread.unread);
                                                        $('#' + unread.chatId + ' .badge').show();
                                                    }
                                                }
                                                else {
                                                    $('#' + unread.chatId + ' .badge').hide();
                                                }
                                            });
                                        }
                                    }
                                    var currentChat = window.location.search.split('&');
                                    if(currentChat.length > 0)
                                    {
                                        currentChat = currentChat[0].split('=');
                                        if(currentChat.length > 1) {
                                            var tab = $('#' + currentChat[1]).parents('div.contacts').index('#sidepanel div.contacts');
                                            $('ul.tabs li').eq(tab).children('a').click();
                                            $('#' + currentChat[1]).click();
                                        }
                                    }
                                });
                            });
                        });
                    });
                    $('#send').click(sendMessage);
                    $('#message').on('keypress', sendMessage);
                    $('#sidepanel').on('click', 'li.contact', function(){
                        if($(this).length == 0) return;
                        $(this).addClass('active').siblings().removeClass('active');
                        chat.unubscribeChatMessages(current);
                        cid = {'Id': $(this).data('chat-id'), 'name': $(this).find('p.name').text()};
                        chat.updateUnreadCount(user.Id, cid.Id, 0);
                        $('#unread_' + cid.Id).remove();
                        $('#message-box .badge').text($('#unread-messages-list li').length);
                        if($('#unread-messages-list li').length == 0) $('#message-box .badge').hide();
                        $('#chat-title span').text(cid.name);
                        $('#messages ul').html('');
                        $('#messages').data('loaded', false);
                        chat.getChatMessages(cid.Id, function(messages){
                            messages.forEach(displayChatMessage);
                            $('#messages').animate({scrollTop: $('#messages ul').height()}, 100);
                            current = chat.subscribeToChatMessages(cid.Id, function(data){
                                displayChatMessage(data);
                                $('#messages').animate({scrollTop: $('#messages ul').height()}, 300);
                            });
                        }, 10);
                    });
                    $('#friends').on('click', '.delete-chat', function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        if(confirm('Are you sure you want to delete this chat?'))
                        {
                            chat.deleteChat($(this).parent('li').data('chat-id'), user.Id);
                            var that = this;
                            setTimeout(function(){
                            if(cid != null && cid.Id == $(that).parent('li').data('chat-id'))
                            {
                                $('#messages ul').html('');
                                $('#chat-title span').text('');
                                cid = null;
                            }
                            }, 300);
                            var url = API_URL + 'deleteChat/' + encodeURI($(this).parent('li').data('chat-id'));

                            var type = "post";

                            $.ajax({
                                type: type,
                                url: url,
                                success: function()
                                {
                                    return true;
                                }
                            });
                            $(this).parent('li').remove();
                        }
                    });
                    $('#messages').scroll(function(){
                        if (cid == null) return;
                        if($(this).scrollTop() == 0 && $('#messages').data('loaded') != true)
                        {
                            chat.getChatMessages(cid.Id, function(messages){
                                if(!messages.hasChildren())
                                {
                                    $('#messages').data('loaded', true);
                                    return;
                                }
                                $('#messages li').removeClass('first');
                                $('#messages li:first-child').addClass('first');
                                messages.forEach(displayChatMessage);
                                $('#messages').scrollTop($('#messages li.first').position().top - $('#messages li.first').height() - 13);
                                $('#messages li').removeClass('first');
                            }, 50, $('#messages li:first-child').data('date'));
                        }
                    });
                    $('.tabs a').click(function(e){
                        e.preventDefault();
                        $('.contacts').hide();
                        $(this).parent().siblings().children('a').removeClass('active');
                        $(this).addClass('active');
                        $($(this).attr('href')).fadeIn(300);
                    });

                    $('#attachment').click(function(e){
                        e.preventDefault();
                        $('#attachment_file').click();
                    });
                    $('#attachment_file').change(function(e){
                        sendFile(e.target.files[0]);
                        $('#attachment_file').val('');
                    });
                    $('#contacts-search').on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#organizations li, #groups li, #friends li").filter(function() {
                            $(this).toggle($(this).find('.name').text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });

                function sendMessage(e)
                {
                    if((e.type == 'keypress' && e.which == 13) || e.type == 'click') {
                        e.preventDefault();
                        if($('#message').val() == '') return;
                        chat.writeMessage(user, cid, $('#message').val());
                        $('#message').val('');
                    }
                }

                function displayChatMessage(message)
                {
                    var message = message.val();
                    var date = new Date(message.created);
                    var hours = date.getHours();
                    var ampm = 'AM';
                    var base_path = "";
                    var month = ['January', 'February', 'March',' April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    if (hours > 12)
                    {
                        hours -= 12;
                        ampm = 'PM';
                    }
                    var date_formatted = date.getDate() + ' ' + month[date.getMonth()] + ' ' + hours + ':' + date.getMinutes() + ' ' + ampm;
                    var formatted = '';
                    var chatUsers = JSON.parse(window.sessionStorage.getItem('chatUsers'));
                    var photo = '';
                    if(chatUsers == null || typeof chatUsers[message.uid] == 'undefined')
                    {
                        chat.getUser(message.uid, function(u){
                            var chatUsers = JSON.parse(window.sessionStorage.getItem('chatUsers'));
                            if(chatUsers == null) chatUsers = {};
                            u = u.val();
                            chatUsers[u.Id] = u;
                            window.sessionStorage.setItem('chatUsers', JSON.stringify(chatUsers));
                            $('#' + message.Id + ' .avatar').css('background-image', "url('" + u.photo + "')");
                        });
                    }
                    else {
                        photo = chatUsers[message.uid].photo;
                    }
                    message.created--;
                    if(message.file == null) {
                        formatted = '<li class="sent" id="' + message.Id + '" data-date="' + message.created + '">\
                               <div class="avatar" style="background-image:url(\'' + photo + '\')"></div>\
                               <div>\
                               <p class="name">\
                               <span>' + message.name + '</span>\
                               <span class="date">' + date_formatted + '</span>\
                               </p>\
                               <p>' + htmlEncode(message.message) + '</p>\
                               </div>\
                               </li>';
                        if($('#messages li.first').length > 0)
                        {
                            $('#messages li.first').before(formatted);
                        }
                        else {
                            $('#messages ul').append(formatted);
                        }
                    }
                    else {
                        if(message.file.ready) {
                            var bucketPath = '//s3.us-east-2.amazonaws.com/my-voluntier-chat-files/';
                            if(message.file.isImage || message.file.isVideo)
                            {
                                var thumb = bucketPath + message.file.path;
                                formatted = '<li class="sent" id="' + message.Id + '" data-date="' + message.created + '">\
                                   <div class="avatar" style="background-image:url(\'' + photo + '\')"></div>\
                                   <div>\
                                   <p class="name">\
                                   <span>' + message.name + '</span>\
                                   <span class="date">' + date_formatted + '</span>\
                                   </p>\
                                   <p><span class="attachment">';
                                if(message.file.isVideo) {
                                    formatted += '<a data-fancybox="gallery" class="video_box" href="' + bucketPath + message.file.path + '">\
                                        <span class="flex-container">\
                                        <span class="flex-item"><img src="{{asset('img/icon_video.png')}}" alt=""></span>\
                                        <span class="flex-item">\
                                        <span class="name">' + message.file.name + '</span>\
                                    </span>\
                                    </span>\
                                    </a>';
                                }
                                else {
                                    formatted += '<a href="' + bucketPath + message.file.path + '"><img src="' + thumb + '">' + name + '</a></span></p>';
                                }
                                formatted += '</div>\
                                   </li>';
                            }
                            else {
                                formatted = '<li class="sent" id="' + message.Id + '" data-date="' + message.created + '">\
                                   <div class="avatar" style="background-image:url(\'' + photo + '\')"></div>\
                                   <div>\
                                   <p class="name">\
                                   <span>' + message.name + '</span>\
                                   <span class="date">' + date_formatted + '</span>\
                                   </p>\
                                   <p><a href="' + bucketPath + message.file.path + '">' + message.file.name + '</a></p>\
                                   </div>\
                                   </li>';
                            }
                            if($('#messages li.first').length > 0)
                            {
                                $('#messages li.first').before(formatted);
                            }
                            else {
                                $('#messages ul').append(formatted);
                            }
                            $('.attachment a').fancybox({beforeLoad : function() {
                                console.log(this);
                                var href = this.src;
                                    //width = this.width,
                                    //height = this.height;

                                // Check if quictime movie and change content
                                if (href.toLowerCase().indexOf('.mov') != -1) {
                                    this.src    = '<object pluginspage="http://www.apple.com/quicktime/download" data="'+ href + '" type="video/quicktime"><param name="autoplay" value="true"><param name="scale" value="tofit"><param name="controller" value="true"><param name="enablejavascript" value="true"><param name="src" value="' + href + '"><param name="loop" value="false"></object>';
                                    this.type       = 'html';
                                }
                            }});
                        }
                        else{
                            chat.subscribeOnMessageChange(cid.Id, message.Id, function(message){
                                var bucketPath = '//s3.us-east-2.amazonaws.com/my-voluntier-chat-files/';
                                message = message.val();
                                if(!message.file.ready) return;
                                if(message.file.isImage || message.file.isVideo)
                                {
                                    var thumb = bucketPath + message.file.path;
                                    formatted = '<li class="sent" id="' + message.Id + '" data-date="' + message.created + '">\
                                   <div class="avatar" style="background-image:url(\'' + photo + '\')"></div>\
                                   <div>\
                                   <p class="name">\
                                   <span>' + message.name + '</span>\
                                   <span class="date">' + date_formatted + '</span>\
                                   </p>\
                                   <p><span class="attachment">';
                                    if(message.file.isVideo) {
                                        formatted += '<a data-fancybox="gallery" class="video_box" href="' + bucketPath + message.file.path + '">\
                                        <span class="flex-container">\
                                        <span class="flex-item"><img src="{{asset('img/icon_video.png')}}" alt=""></span>\
                                        <span class="flex-item">\
                                        <span class="name">' + message.file.name + '</span>\
                                    </span>\
                                    </span>\
                                    </a>';
                                    }
                                    else {
                                        formatted += '<a href="' + bucketPath + message.file.path + '"><img src="' + thumb + '">' + name + '</a></span></p>';
                                    }
                                    formatted += '</div>\
                                   </li>';
                                }
                                else {
                                    formatted = '<li class="sent" id="' + message.Id + '" data-date="' + message.created + '">\
                                       <div class="avatar" style="background-image:url(\'' + photo + '\')"></div>\
                                       <div>\
                                       <p class="name">\
                                       <span>' + message.name + '</span>\
                                       <span class="date">' + date_formatted + '</span>\
                                       </p>\
                                       <p><a href="' + bucketPath + message.file.path + '">' + message.file.name + '</a></p>\
                                       </div>\
                                       </li>';
                                }
                                if($('#messages li.first').length > 0)
                                {
                                    $('#messages li.first').before(formatted);
                                }
                                else {
                                    $('#messages ul').append(formatted);
                                }
                                $('.attachment a').fancybox({
                                    beforeLoad : function() {
                                        var href = this.src;
                                            //width = this.width,
                                            //height = this.height;

                                        // Check if quictime movie and change content
                                        if (href.toLowerCase().indexOf('.mov') != -1) {
                                            this.src    = '<object pluginspage="http://www.apple.com/quicktime/download" data="'+ href + '" type="video/quicktime"><param name="autoplay" value="true"><param name="scale" value="tofit"><param name="controller" value="true"><param name="enablejavascript" value="true"><param name="src" value="' + href + '"><param name="loop" value="false"></object>';
                                            this.type       = 'html';
                                        }
                                    }
                                });
                                chat.unsubscribeFromMessageChange(cid.Id, message.Id);
                                $('#messages').animate({scrollTop: $('#messages ul').height()}, 300);
                            });
                        }
                    }
                }

                function sendFile(file)
                {
                    if (file.type.indexOf('image/jpeg') >= 0) {
                        var fr = new FileReader();
                        fr.onload = function(e){
                            var file = new Blob([e.target.result], {type:'image/jpeg'});
                            var or = getOrientation(e.target.result);
                            correctImageRotation(file, or);
                        }
                            //removeExiffData;
                        fr.readAsArrayBuffer(file);
                    }
                    else {
                        process(file);
                    }
                }

                function process(file)
                {
                    var f = {'ready': false, 'isImage': false, 'isVideo': false};
                    if(file.type.indexOf('image') >= 0)
                    {
                        f.isImage = true;
                    }
                    if(file.type.indexOf('video') >= 0)
                    {
                        f.isVideo = true;
                    }
                    var fileName = file.name;
                    if(typeof fileName == 'undefined') fileName = 'image.jpg';
                    f.name = fileName;
                    var albumPhotosKey = Date.now() + '_';

                    f.path = albumPhotosKey + fileName;
                    messageId = chat.writeMessage(user, cid, '', f);
                    s3.upload({
                        Key: f.path,
                        Body: file,
                        ACL: 'public-read',
                        ContentType: file.type
                    }, function(err, data) {
                        if (err) {
                            return alert('There was an error uploading your file: ' + err.message);
                        }
                        chat.updateFileStatus(cid.Id, messageId);
                    });
                }

                function dataURItoBlob(dataURI) {
// convert base64/URLEncoded data component to raw binary data held in a string
                    var byteString;
                    if (dataURI.split(',')[0].indexOf('base64') >= 0)
                        byteString = atob(dataURI.split(',')[1]);
                    else
                        byteString = unescape(dataURI.split(',')[1]);
// separate out the mime component
                    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
// write the bytes of the string to a typed array
                    var ia = new Uint8Array(byteString.length);
                    for (var i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    return new File([ia], 'image.jpg', {type: 'image/jpeg'});
                }

                function correctImageRotation(blob, or)
                {
                    if(or < 0) process(blob);
                    var canvas = document.createElement('canvas');
                    canvas.style = "display: none";
                    var img = new Image();
                    var deg = 0;
                    switch(or){
                        case 1: process(blob);
                        return;
                        break;
                        case 3: deg = 180;
                        break;
                        case 6: deg = 90;
                        break;
                        case 8: deg = 270;
                        break;
                        default: process(blob);
                        return;
                    }

                    img.onload = function(){
                        if(or == 6)
                        {
                            canvas.width  = img.height;
                            canvas.height = img.width;
                        }
                        else
                        {
                            canvas.width  = img.width;
                            canvas.height = img.height;
                        }
                        var ctx = canvas.getContext('2d');
                        ctx.translate(canvas.width, 0);
                        ctx.rotate(deg*Math.PI/180);
                        ctx.drawImage(img, 0, 0);
                        process(dataURItoBlob(canvas.toDataURL('image/jpeg', 1.0)));
                    };

                    img.src = URL.createObjectURL(blob);
                }

                function getOrientation(file)
                {
                    var view = new DataView(file);
                    if (view.getUint16(0, false) != 0xFFD8)
                    {
                        return -2;
                    }
                    var length = view.byteLength, offset = 2;
                    while (offset < length)
                    {
                        if (view.getUint16(offset+2, false) <= 8) return callback(-1);
                        var marker = view.getUint16(offset, false);
                        offset += 2;
                        if (marker == 0xFFE1)
                        {
                            if (view.getUint32(offset += 2, false) != 0x45786966)
                            {
                                return -1;
                            }

                            var little = view.getUint16(offset += 6, false) == 0x4949;
                            offset += view.getUint32(offset + 4, little);
                            var tags = view.getUint16(offset, little);
                            offset += 2;
                            for (var i = 0; i < tags; i++)
                            {
                                if (view.getUint16(offset + (i * 12), little) == 0x0112)
                                {
                                    return view.getUint16(offset + (i * 12) + 8, little);
                                }
                            }
                        }
                        else if ((marker & 0xFF00) != 0xFF00)
                        {
                            break;
                        }
                        else
                        {
                            offset += view.getUint16(offset, false);
                        }
                    }
                    return -1;
                }

                /*function removeExiffData(){
                    console.log(this);
                    var dv = new DataView(this.result);
                    var offset = 0, recess = 0;
                    var pieces = [];
                    var i = 0;
                    if (dv.getUint16(offset) == 0xffd8){
                        offset += 2;
                        var app1 = dv.getUint16(offset);
                        offset += 2;
                        while (offset < dv.byteLength){
                            if (app1 == 0xffe1){

                                pieces[i] = {recess:recess,offset:offset-2};
                                recess = offset + dv.getUint16(offset);
                                i++;
                            }
                            else if (app1 == 0xffda){
                                break;
                            }
                            offset += dv.getUint16(offset);
                            var app1 = dv.getUint16(offset);
                            offset += 2;
                        }
                        if (pieces.length > 0){
                            var newPieces = [];
                            pieces.forEach(function(v){
                                newPieces.push(this.result.slice(v.recess, v.offset));
                            }, this);
                            newPieces.push(this.result.slice(recess));
                            var br = new File(newPieces, 'image.jpg', {type: 'image/jpeg'});
                            process(br);
                        }
                        else
                        {
                            process(new File([this.result],  'image.jpg', {type: 'image/jpeg'}))
                        }
                    }
                }*/

            </script>

            <script>

                $(document).ready(function() {

                    var $outerwidth = $('.row-header header .outer-width-box');
                    var $innerwidth = $('.row-header header .inner-width-box');

                    function checkWidth() {

                        var outersize = $outerwidth.width();
                        var innersize = $innerwidth.width();

                        if( innersize > outersize) {

                            $('body').addClass("navmobile");

                        } else {

                            $('body').removeClass("navmobile");
                            $('body').removeClass("offcanvas-menu-show");

                        }


                    }

                    checkWidth();
                    $(window).resize(checkWidth);

                    $('.offcanvas-menu-backdrop').on('click', function(e) {
                        $('body').toggleClass("offcanvas-menu-show");
                        e.preventDefault();
                    });

                    $('.wrapper_bottom_footer > .row-header-mobile header a.navtoggler').on('click', function(e) {
                        $('body').toggleClass("offcanvas-menu-show");
                        e.preventDefault();
                    });




                    $('.sidepanel-backdrop').on('click', function(e) {
                        $('#frame').toggleClass("sidepanel-show");
                        e.preventDefault();
                    });

                    $('.wrapper-chat-box .frame a.navtoggler').on('click', function(e) {
                        $('#frame').toggleClass("sidepanel-show");
                        e.preventDefault();
                    });

                });

            </script>
@endsection