$(function() {
    //alert('ok');
    //loadall();


    // check if already logged in
    checkIfLoggedIn();
    //getEvent();
    // getMessagesLocation();
//    setInterval(getMessagesLocation, 1000);

    // if logged in, hide register and login form and fill up the location section


    //event listener registerlink
    $("#chatform").submit(function(event) {
        event.preventDefault();
        var text = this.msg;
        SubmitMessage(text.value);
        text.value = "";
        text.focus();
    });

    //event listener registerlink
    $("#registerbutton").click(function(event) {
        event.preventDefault();
        //alert('ok');
        $('#login').hide();
        $('#register').show();
    });

    //event listener loginlink
    $("#loginbutton").click(function(event) {
        event.preventDefault();
        //alert('ok');
        $('#login').show();
        $('#register').hide();
    });

    //event listener logoutlink
    $("#logoutbutton").click(function(event) {
        event.preventDefault();
        //alert('ok');
        logout();
    });

    //event listener change location

    $('div#routes').on('click', 'button#route', function(event) {
        event.preventDefault();
        //alert('ok');
        changeLocation(this.dataset.routeid);
        loadAll();
    });

    //event listener register form
    $("form#registerform").submit(function(event) {
        event.preventDefault();
        //ajax function register
        //alert('register');
        username = $("form#registerform input#username").val();
        email = $("form#registerform input#email").val();
        password = $("form#registerform input#password").val();
        if (username == "") {
            alert("Please provide a Username");
        } else if (email == "") {
            alert("Please provide an emailaddress");
        } else if (password == "") {
            alert("Please provide a password");
        } else {
            register(username, email, password);
        }
    });

    //event listener login form
    $("form#loginform").submit(function(event) {
        event.preventDefault();
        //ajax function login
        //alert('login');
        loginname = $("form#loginform input#loginname").val();
        password = $('form#loginform input#password').val();

        if (loginname == "") {
            alert("Please provide a valid Username or Email");
        } else if (password == "") {
            alert("Please provide a Password");
        } else {

            //alert("you're logged in");
            login(loginname, password);
        }
    });






}); // end document ready


function getEvent() {
    $.ajax({
        url: 'json_getEventLocation.php',
        dataType: 'json',
        async: false,
        data: {action: 'getEvent'},
        success: function(data) {
            if (data.exceptions) {
                switch (data.exceptions[0]) {
                    case 'ID_NOT_FOUND':
                        message = 'id not found.';
                        break;
                    case 'NO_EVENT':
                        message = 'no event!';
                        break;
                    case 'NO_RESULT':
                        message = 'no result!';
                        break;
                    default:
                        message = 'Error!';
                }
                $("div#event").html(message);
            } else {
                var alinea = $("<p>");
                alinea.empty().html(data.event.event.description);
                $("div#event").empty().append(alinea);
                var tableEl = $("<table>");
                var rijEl = $("<tr>");
                $.each(data.event.results, function(n, result) {
                    var info = '<td>'
                    info += '<a href=# data-id=' + result.id + '>' + result.id
                    info += '</a>'
                    info += '</td>'
                    rijEl.append(info);
                })
                tableEl.html(rijEl);
                $("div#event").append(tableEl);
//event listener result
                $("div#event a").click(function(event) {
                    event.preventDefault();
                    getResult(data.event.results[this.dataset.id]);
                });

            }
        }
    });

}

function getResult(data) {
    //console.log(idResult);
    console.log(data.description);

    if (data.outcome == 1) {
        changeLocation(2);
        loadAll();
    } else
    if (data.outcome == 2) {
        changeLocation(1);
        loadAll();
    } else
    if (data.outcome == 3) {
        $('#routes button').prop('disabled', false);
    }
    alert(data.description);

}


function getMessagesLocation() {
    $.ajax({
        url: 'json_getMessagesLocation.php',
        dataType: 'json',
        async: false,
        data: {action: 'getMessages'},
        success: function(data) {
            // console.log(data);
            if (data.exceptions) {
                switch (data.exceptions[0]) {
                    case 'ID_NOT_FOUND':
                        message = 'id not found.';
                        break;
                    case 'NO_MSG':
                        message = 'no messages!';
                        break;
                    default:
                        message = 'Error!';
                }
                $("#reChat").html(message);
            } else {

                if (data.lijstmessages.length !== 0) {

                    var tableEl = $("<table>");

                    $.each(data.lijstmessages, function(n, value) {
                        var rijEl = $("<tr>");
                        var kolomEl = $("<td>");
                        kolomEl.html(value.user.username + ":");
                        var kolomEl2 = $("<td>");
                        kolomEl2.html(value.text);
                        rijEl.append(kolomEl).append(kolomEl2);
                        tableEl.append(rijEl);
                    });
                    $("#reChat").empty().html(tableEl);
                } else {

                }
                //do something with data

            }
        }
    });
}



function SubmitMessage(text) {

    $.ajax({
        url: 'json_createMessage.php',
        dataType: 'json',
        data: {action: "createMessage", message: text},
        //async: false,
        success: function(data) {
            if (data.exceptions) {
                console.log(data.exceptions);
                switch (data.exceptions[0]) {
                    case 'IS_EMPTY_TEXT':
                        message = 'Please enter text.';
                        break;
                    case 'IS_EMPTY_USER':
                        message = 'user is empty!';
                        break;
                    case 'FORBIDDEN_CHARS_USERNAME':
                        message = 'Forbidden characters!';
                        break;
                    default:
                        message = 'Error!';
                }
                $("#reChat").html(message);
            } else {
                getMessagesLocation();
//                var elem = $('#reChat');
//                elem.scrollTop = elem.scrollHeight;
                $('#reChat').scrollTop($('#reChat')[0].scrollHeight);
            }
        }
    });
}
function loadAll() {

    //alert('ok');

    $.ajax({
        url: 'json_loadall.php',
        dataType: 'json',
        data: 'action=loadall',
        //async: false,
        success: function(data) {
            //do something with data
            //add gameinfo
            var info = '<div id="gameinfo">'
            info += '<h3>Username:</h3>'
            info += '<div id="user"></div>'
            info += '<h3>Score:</h3>'
            info += '<div id="score"></div>'
            info += '<h3>Players at this location:</h3>'
            info += '<div id="users"></div>'
            info += '</div>'
            $("#info").empty().append(info);
            getMessagesLocation();
            getEvent();
            //console.log(data.users);

            if (data.users.length !== 0) {


                var userlist = "<ul>";
                $.each(data.users, function() {
                    if (this.id != data.userdata.id) {
                        userlist += "<li";
                        if (this.logged_in == "1") {
                            userlist += " class='loggedin'";
                        }
                        userlist += ">" + this.username + ": " + this.score + "</li>";
                    }
                });
                userlist += "</ul>";
                // console.log(userlist);
            } else {
                userlist = "no players";
            }

            // add userlist at current location
            $('#gameinfo #users').empty().append(userlist);
            // add the user's username
            $('#gameinfo #user').empty().append(data.userdata.username);

            // add the user's score
            $('#gameinfo #score').empty().append(data.userdata.score);

            // add description of current location
            $('#location #description').empty().append(data.userdata.location.description);
            // add background image
            var imgUrl = "url(src/vdab/dunion/Presentation/img/" + data.userdata.location.id + ".jpg)";
            $('body').css("background-image", imgUrl);

            //add target routes from current location
            var routes = "";
            $.each(data.routes, function() {
                //////disable van knoppen bij loadall  disabled='disabled'
                routes += "<button class='btn btn-default' id='route' data-routeid='" + this.target.id + "'>" + this.target.name + "</button><br>";
            });
            var routeTitel = "<h3>Choose your destination:</h3>"
            $('#routes').empty().append(routeTitel).append(routes);

        }
    });
}
function login(loginname, password) {
    $.ajax({
        url: 'json_login.php',
        dataType: 'json',
        async: false,
        data: {action: 'login', loginname: loginname, password: password},
        success: function(data) {
            if (data.exceptions) {
                switch (data.exceptions[0]) {
                    case 'IS_EMPTY_USERNAME':
                        message = 'Username can not be empty.';
                        break;
                    case 'IS_EMPTY_PASSWORD':
                        message = 'Password can not be empty.';
                        break;
                    case 'USER_DOES_NOT_EXIST':
                        message = 'This user does not exist.';
                        break;
                    case 'PASSWORD_INCORRECT':
                        message = 'Username and/or password incorrect.';
                        break;
                    case 'FORBIDDEN_CHARS_USERNAME':
                        message = 'Forbidden characters in the username!';
                        break;
                    case 'FORBIDDEN_CHARS_PASSWORD':
                        message = 'Forbidden characters in the password!';
                        break;
                    default:
                        message = 'Error!';
                }
                alert(message);
            } else {
                //do something with data
                $('#register').hide();
                $('#login').hide();
                $('#logoutbutton').show();
                $('#location').show();
                $('#info').show();
                $('#dest').show();
                $("#info").show();
                $("#chatbox").show();
                $("#event").show();

                loadAll();
            }
        }
    });
}

function logout() {
    $.ajax({
        url: 'json_logout.php',
        dataType: 'json',
        async: false,
        data: {action: 'logout'},
        //	      success: function (data) {
        //	      		//do something with data
        //	    	  //console.log(data);
        //	    	
//	      }
    });

    $('#register').hide();
    $('#login').show();
    $('#logoutbutton').hide();
    $('#info').hide();
    $('#dest').hide();
    $('#event').hide();
    $('body').attr('style', 'background-image:../img/default.jpg');
    $('#location').hide();
    $("#chatbox").hide();

}

function register(username, email, password) {
    $.ajax({
        url: 'json_register.php',
        dataType: 'json',
        async: false,
        data: {action: 'register', username: username, email: email, password: password},
        success: function(data) {
            console.log(data.exceptions);
            if (data.exceptions) {
                switch (data.exceptions[0]) {
                    case 'IS_EMPTY_USERNAME':
                        message = 'Username can not be empty.';
                        break;
                    case 'IS_EMPTY_PASSWORD':
                        message = 'Password can not be empty.';
                        break;
                    case 'IS_EMPTY_EMAIL':
                        message = 'Emailaddress can not be empty.';
                        break;
                    case 'NOT_VALID_EMAIL':
                        message = 'Please provide a valid email.';
                        break;
                    case 'FORBIDDEN_CHARS_USERNAME':
                        message = 'Forbidden characters in the username!';
                        break;
                    case 'FORBIDDEN_CHARS_PASSWORD':
                        message = 'Forbidden characters in the password!';
                        break;
                    case 'FORBIDDEN_CHARS_EMAIL':
                        message = 'Forbidden characters in the email!';
                        break;
                    default:
                        message = 'Error!';
                }
                alert(message);
            } else {
                //do something with data
                //console.log(data);
                $('#register').hide();
                $('#login').hide();
                $('#logoutbutton').show();
                $('#location').show();
                $('#gameinfo').show();
                $('#dest').show();
                $("#info").show();
                $("#chatbox").show();
                $("#event").show();
                loadAll();
            }
        }
    });
}

function changeLocation(location_id) {
    $.ajax({
        url: 'json_changelocation.php',
        dataType: 'json',
        async: false,
        data: {action: 'changelocation', location_id: location_id},
        success: function(data) {

            //do something with data
            //console.log(data)
        }
    });
}

function checkIfLoggedIn(loggedin) {
    //alert('ok');
    $.ajax({
        url: 'json_logincheck.php',
        dataType: 'json',
        async: false,
        data: 'action=logincheck',
        success: function(data) {
            //do something with data
            //console.log(data);
            if (data.loggedin.value == 1) {
                $('#register').hide();
                $('#login').hide();
                $('#logoutbutton').show();
                $('#location').show();
                $('#gameinfo').show();
                $('#dest').show();
                $("#info").show();
                $("#chatbox").show();
                loadAll();

            } else {
                // if not logged in, show login form
                $('#register').hide();
                $('#login').show();
                $('#logoutbutton').hide();
                $('#location').hide();
                $('#gameinfo').hide();
                $('#dest').hide();
                $("#info").hide();
                $("#chatbox").hide();
            }
        }
    });
}



