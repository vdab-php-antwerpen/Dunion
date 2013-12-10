$(function() {
    //alert('ok');
    //loadall();


    // check if already logged in
    checkIfLoggedIn();

    getMessagesLocation();
    setInterval(getMessagesLocation, 1000);

    // if logged in, hide register and login form and fill up the location section


 //event listener registerlink
    $("#chatform").click(function(event) {
        event.preventDefault();
        var text = val(this.msg);
        SubmitMessage(text);
    });

    //event listener registerlink
    $("a#register").click(function(event) {
        event.preventDefault();
        //alert('ok');
        $('aside#login').hide();
        $('aside#register').show();
    });

    //event listener loginlink
    $("a#login").click(function(event) {
        event.preventDefault();
        //alert('ok');
        $('aside#login').show();
        $('aside#register').hide();
    });

    //event listener logoutlink
    $("a#logout").click(function(event) {
        event.preventDefault();
        //alert('ok');
        logout();
    });

    //event listener change location

    $('div.routes').on('click', 'a.route', function(event) {
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
                    default:
                        message = 'Error!';
                }
                alert(message);
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

                    $("div#reChat").html(tableEl);
                } else {
                    $("div#reChat").html("no messages");
                }
                //do something with data

            }
        }
    });
}



function SubmitMessage(text) {
    console.log('submit');
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
            info += '<div class="user"></div>'
            info += '<h3>Score:</h3>'
            info += '<div class="score"></div>'
            info += '<h3>players at this location:</h3>'
            info += '<div class="users"></div>'
            info += '</div>'
            $("aside#info").empty().append(info);
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
            $('div#gameinfo .users').empty().append(userlist);
            // add the user's username
            $('div#gameinfo .user').empty().append(data.userdata.username);

            // add the user's score
            $('div#gameinfo .score').empty().append(data.userdata.score);

            // add description of current location
            $('div#location .description').empty().append(data.userdata.location.description);
            // add background image
            var imgUrl = "url(src/vdab/dunion/Presentation/img/" + data.userdata.location.id + ".jpg)";
            $('div.main-container').css("background-image", imgUrl);

            //add target routes from current location
            var routes = "";
            $.each(data.userdata.location.routes, function() {
                routes += "<a href='#' class='route' data-routeid='" + this.target + "'>" + this.target + "</a><br>";
            });
            $('div.routes').empty().append(routes);
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
                $('aside#register').hide();
                $('aside#login').hide();
                $('a#logout').show();
                $('div#location').show();
                $('aside#info').show();
                $('aside#dest').show();
                $("aside#info").show();
                $("div#chatbox").show();
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

    $('aside#register').hide();
    $('aside#login').show();
    $('a#logout').hide();
    $('aside#info').hide();
    $('aside#dest').hide();
    $("aside#info").hide();
    $('div.main-container').attr('style', 'background-image:none');
    $('div#location').hide();
    $("div#chatbox").hide();

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
                $('aside#register').hide();
                $('aside#login').hide();
                $('a#logout').show();
                $('div#location').show();
                $('div#gameinfo').show();
                $('aside#dest').show();
                $("aside#info").show();
                $("div#chatbox").show();
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
                $('aside#register').hide();
                $('aside#login').hide();
                $('a#logout').show();
                $('div#location').show();
                $('div#gameinfo').show();
                $('aside#dest').show();
                $("aside#info").show();
                $("div#chatbox").show();
                loadAll();

            } else {
                // if not logged in, show login form
                $('aside#register').hide();
                $('aside#login').show();
                $('a#logout').hide();
                $('div#location').hide();
                $('div#gameinfo').hide();
                $('aside#dest').hide();
                $("aside#info").hide();
                $("div#chatbox").hide();
            }
        }
    });
}



