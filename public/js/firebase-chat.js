var chat = (function(firebase){
    var connectedRef = null;

    function writeMessage(user, chat, message, file)
    {
        var message = {
            uid: user.Id,
            name: user.name,
            chatId: chat.Id,
            file: null,
            message: message,
            created: firebase.database.ServerValue.TIMESTAMP
        };
        if(typeof file !== 'undefined')
        {
            message.file = file;
        }
        var messageKey = firebase.database().ref('messages/' + chat.Id).push().key;
        message.Id = messageKey;

        var updates = {};
        updates['messages/' + chat.Id + '/' + messageKey] = message;
        //updates['/chats/' + chatId + '/' + messageKey] = message;

        firebase.database().ref('members/' + chat.Id).once('value', function(users){
            users = users.val();
            for(var uid in users)
            {
                if(uid == user.Id) continue;
                firebase.database().ref('members/').child(chat.Id).child(uid).child('unread').transaction(function(count){
                    return ++count;
                });
            }
        });

        firebase.database().ref().update(updates);
        return messageKey;
    }

    function updateFileStatus(chatId, messageId)
    {
        firebase.database().ref('messages').child(chatId).child(messageId).child('file').child('ready').set(true);
    }

    function subscribeOnMessageChange(chatId, messageId, callback)
    {
        firebase.database().ref('messages').child(chatId).child(messageId).on('value', callback);
    }

    function unsubscribeFromMessageChange(chatId, messageId)
    {
        firebase.database().ref('messages').child(chatId).child(messageId).off();
    }

    function addUserToChat(user, chat, type, onMessageCallback)
    {
        firebase.database().ref('chats/' + chat.Id).once('value', function(snapshot){
            var chat = snapshot.val();
            var userObj = {'name': user.name, 'unread': 0, 'chatId': chat.Id};
            firebase.database().ref('members/' + chat.Id + '/' + user.Id).set(userObj);
            firebase.database().ref('users/' + user.Id + '/chats/' + type + '/' + chat.Id).set(chat.name);
            var queryRef = firebase.database().ref('messages/' + chat.Id).orderByChild('created').startAt(Date.now());
            queryRef.on('child_added', onMessageCallback);
        });
    }

    function addUserToGroup(user, chat, onMessageCallback)
    {
        addUserToChat(user, chat, 'groups', onMessageCallback)
    }

    function addUserToOrg(user, chat, onMessageCallback)
    {
        addUserToChat(user, chat, 'organizations', onMessageCallback)
    }

    function addFriend(user, chat, onMessageCallback)
    {
        addUserToChat(user, chat, 'friends', onMessageCallback)
    }

    function addChat(title, photo)
    {
        var chat = { 'name': title, 'photo': photo};
        chat.Id = firebase.database().ref().child('chats').push(chat).key;
        firebase.database().ref('chats/' + chat.Id).update(chat);
        return chat;
    }

    function getChat(id, callback)
    {
        firebase.database().ref('chats/' + id).once('value', callback);
    }

    function addUser(name, photo, uid)
    {
        var user = { 'name': name, 'photo': photo, 'Id': uid};
        firebase.database().ref('users/' + uid).set(user);
        return user;
    }

    function getUser(uid, callback)
    {
        firebase.database().ref('users/' + uid).once('value', callback);
    }

    function updateStatus(user)
    {
        if(connectedRef == null) {
            connectedRef = firebase.database().ref('.info/connected');
            var lastOnlineRef = firebase.database().ref('users/' + user.Id + '/lastOnline');
            connectedRef.on('value', function(snap) {
                if (snap.val() === true) {
                    // We're connected (or reconnected)! Do anything here that should happen only if online (or on reconnect)
                    var con = firebase.database().ref('users/' + user.Id + '/online');

                    // When I disconnect, remove this device
                    con.onDisconnect().set(false);

                    // Add this device to my connections list
                    // this value could contain info about the device or a timestamp too
                    con.set(true);

                    // When I disconnect, update the last time I was seen online
                    lastOnlineRef.onDisconnect().set(firebase.database.ServerValue.TIMESTAMP);
                }
            });
        }
    }

    function login(token, callback, errorCallback)
    {
        //firebase.auth().onAuthStateChanged(function(user) {
            //if (user) {
            //    callback(user);
            //} else {
                if(typeof errorCallback != 'undefined')
                    firebase.auth().signInWithCustomToken(token).then(callback).catch(errorCallback);
                else firebase.auth().signInWithCustomToken(token).then(callback);
            //}
        //});
    }

    function logout()
    {
        firebase.auth().signOut();
    }

    function getUserChats(uid, callback)
    {
        firebase.database().ref('users/' + uid + '/chats').on('value', callback);
    }

    function getChatUsers(chatId, callback)
    {
        firebase.database().ref('members/' + chatId).on('value', callback);
    }

    function getChatMessages(chatId, callback, count, start)
    {
        if(typeof start == 'undefined') start = Date.now();// + 1000;
        firebase.database().ref('messages/' + chatId).orderByChild('created').endAt(start).limitToLast(count).once('value', callback);
    }

    function subscribeToChatMessages(chatId, onMessageCallback)
    {
        var ref = firebase.database().ref('messages/' + chatId).orderByChild('created').startAt(Date.now());
        ref.on('child_added', onMessageCallback);
        return ref;
    }

    function unubscribeChatMessages(ref)
    {
        if (ref != null) ref.off();
    }

    function subscribeOnOpponentsChange(callback)
    {
        firebase.database().ref('users').on('child_changed', callback);
    }

    function getUnreadCount(uid, chatId, callback)
    {
        firebase.database().ref('members/' + chatId + '/' + uid).on('value', callback);
    }

    function updateUnreadCount(uid, chatId, value)
    {
        firebase.database().ref('members/' + chatId + '/' + uid + '/' + 'unread').set(value);
    }

    function deleteChat(chatId, uid)
    {
        firebase.database().ref('members/' + chatId + '/' + uid).remove();
        firebase.database().ref('users/'  + uid + '/chats/friends/' + chatId).remove();
        firebase.database().ref('members/' + chatId).once('value').then(function(snapshot) {
            var members =  snapshot.val();
            if(Object.keys(members).length == 0)
            {
                firebase.database().ref('messages/' + chatId).remove();
                firebase.database().ref('chats/' + chatId).remove();
            }
        });
    }

    return {
        writeMessage: writeMessage,
        updateFileStatus: updateFileStatus,
        subscribeOnMessageChange: subscribeOnMessageChange,
        unsubscribeFromMessageChange: unsubscribeFromMessageChange,
        addUserToGroup: addUserToGroup,
        addUserToOrg: addUserToOrg,
        addFriend: addFriend,
        addChat: addChat,
        getChat: getChat,
        addUser: addUser,
        getUser: getUser,
        getChatUsers: getChatUsers,
        getUserChats: getUserChats,
        getChatMessages: getChatMessages,
        subscribeToChatMessages: subscribeToChatMessages,
        unubscribeChatMessages: unubscribeChatMessages,
        login: login,
        logout: logout,
        updateStatus: updateStatus,
        subscribeOnOpponentsChange: subscribeOnOpponentsChange,
        getUnreadCount: getUnreadCount,
        updateUnreadCount: updateUnreadCount,
        deleteChat: deleteChat
    }
}(firebase));