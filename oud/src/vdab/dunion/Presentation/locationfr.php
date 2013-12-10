<!DOCTYPE html>
<!--
 * Version 1.05
 * changelog:
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
        <link rel="stylesheet" href="src/vdab/dunion/Presentation/css/main.css">

        <script src="src/vdab/dunion/Presentation/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>');</script>

        <script src="src/vdab/dunion/Presentation/js/main.js"></script>

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Dunion</h1><br>
                <h2>A PHP Scrum Project</h2>
            </header>
            <a href="#" id="logout">Logout</a>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">

                <article>
                    <div id="location">
                        <div class="description"></div>

                    </div>
                </article>
                
                <aside id="info">
                </aside>

                <aside id="dest">
                    <h2>Next destination:</h2>
                    <div class="routes"></div>
                </aside>

                <aside id="login">
                    <section>
                        <h3>Login</h3>
                        <form action="#" id="loginform" method="POST">
                            <div>
                                <label for="logginname">Username or Email:</label>
                                <input id="loginname" type="text" name="loginname">
                            </div>
                            <div>
                                <label for="password">Password:</label>
                                <input id="password" type="password" name="password">
                            </div>
                            <div id="lower">
                                <input class="submit" type="submit" name="submit" value="Login">
                            </div>
                        </form>
                        <a href="#" id="register">Not a Login yet? Register here</a>
                    </section>
                </aside>
                <aside id="register">
                    <section>
                        <h3>Register</h3> 
                        <form action="#" id="registerform" method="POST">
                            <div>
                                <label for="username">Username:</label>
                                <input id="username" type="text" name="username">
                            </div>
                            <div>
                                <label for="email">Email:</label>
                                <input id="email" type="email" name="email">
                            </div>
                            <div>
                                <label for="password">Password:</label>
                                <input id="password" type="password" name="password">
                            </div>
                            <div id="lower">
                                <input class="submit" type="submit" name="submitregister" value="Register">
                            </div>
                        </form>
                        <a href="#" id="login">Goto Login Page</a>
                    </section>
                </aside>
            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper">
                <h3> &copy Dunion 2013</h3>
            </footer>
        </div>


    </body>
</html>
