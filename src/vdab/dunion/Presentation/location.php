<!DOCTYPE html>
<!--
 * Version 1.06
 * changelog:
 * 1.06 Added 'location.css'-link (PV)
 * 1.05 Removed unused code (PV)
 * 1.04 Blank <div id="location"> added to <article> (PV)
 * 1.03 Register added to <aside> (PV)
 * 1.02 Login added to <aside> (PV)
 * 1.01 unused code in comments (PV) 
 * 1.00 generated via initializr.com/HTML5 Boilerplate styles (FV)
-->

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Dunion</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="src/vdab/dunion/Presentation/css/normalize.min.css">
        <link rel="stylesheet" href="src/vdab/dunion/Presentation/css/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="src/vdab/dunion/Presentation/css/location.css">

        <script src="src/vdab/dunion/Presentation/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>');</script>

        <script src="src/vdab/dunion/Presentation/js/main.js"></script>

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <header>
                <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Dunion<small> a PHP Scrum Project</small></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" id="logoutbutton">Logout</a></li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </header>

            <div class="container" id="main-container">

                <!--LOGIN-->
                <div class="row" id="login">
                    <div class="col-md-8" ><h2>Welkom</h2></div>
                    <div class="col-md-4" >
                        <h3>Login</h3>

                        <form id="loginform">
                            <div class="form-group">
                                <label for="loginname">Username or Email:</label>
                                <input type="text" name="loginname" class="form-control" id="loginname" placeholder="Enter username or email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password">
                            </div>
                            <button type="submit" class="btn btn-default" id="submit">Login</button>
                        </form>
                        <a href="#" id="registerbutton">Go to Registration page</a>
                    </div>
                </div>

                <!--REGISTREREN-->
                <div class="row" id="register">
                    <div class="col-md-8" ><h2>Welkom</h2></div>
                    <div class="col-md-4" >
                        <h3>Registreren</h3>

                        <form id="registerform">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" class="form-control" id="email" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password">
                            </div>
                            <button type="submit" class="btn btn-default" id="submitregister">Register</button>
                        </form>
                        <a href="#" id="loginbutton">Go to Login Page</a>
                    </div>
                </div>

                <!--ALLES-->
                <div class="row" id="location">
                    <div class="col-md-8">
                        <div id="description"></div>
                        <div id="event"></div>

                    </div>

                    <div class="col-md-4" >
                        <div id="info"></div><hr>

                        <div id="routes">
                        </div><hr>

                        <div id="chatbox">
                            <h3>Chatbox</h3>
                            <div id="reChat">

                            </div>
                            <form action="#" id="chatform">
                                <div>
                                    <input class="form-control" placeholder="Your message" id="msg" type="text" name="msg">
                                </div>
                                <div>
                                    <button class="btn btn-default" type="submit" name="submitchat">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>


    </body>
</html>
