
<!DOCTYPE HTML>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <script> document.documentElement.className = 'js'; </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- MAKE THE VEWPORT THING && apple_touch_icon-->
    <link rel="shortcut icon" href="<?= MAIN_URL . 'p/img/icons/favicon.ico'; ?>">
    <title> {{title}}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <script src="<?= MAIN_URL ?>p/js/jquery.min.js"></script>
    <script src="<?= MAIN_URL ?>p/js/skel.min.js"></script>
    <script src="<?= MAIN_URL ?>p/js/skel-layers.min.js"></script>
    <script src="<?= MAIN_URL ?>p/js/init.js"></script>

    <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/tcc_style.css"/>
    <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/style.css"/>
    <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/style_one.css"/>
    <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/style_desktop.css"/>
    <title>{{title}}</title>
</head>
<body class="subpage">


<!-- Header -->
<div id="header-wrapper">
    {{nest_header}}
</div>

<!-- Content -->
<div id="content-wrapper">
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="9u">

                    <!-- Main Content -->
                    <section>
                        <header>
                            <h2> {{title}} </h2>

                            <h3>{{secondary_title}}</h3>
                        </header>
                        {{nest_body}}

                    </section>

                </div>
                <div class="3u">

                    <!-- Sidebar -->
                    <section>
                        <header>
                            <h2>Current Charity</h2>
                        </header>
                        <p>We're currently donating to:

                        <div class="charname"><a href="#">Charity name</a></div>
                        <br/>
                        Please give all donations to the company CCO for processing.
                        </p>

                    </section>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div id="footer-wrapper">
    <footer id="footer" class="container">
        <div class="row">
            <div class="8u">

                <!-- Links -->
                <section>
                    <h2>Links to Important Stuff</h2>

                    <div>
                        <div class="row">
                            <div class="3u">
                                <ul class="link-list last-child">
                                    <li><a href="<?= MAIN_URL ?>home">Home</a></li>
                                    <li><a href="mailto:blackrock-il@westmonroepartners.com">Contact Us</a></li>
                                    <li><a href="#">Accumsan suspendisse</a></li>
                                    <li><a href="#">Eu varius vitae magna</a></li>
                                </ul>
                            </div>
                            <div class="3u">
                                <ul class="link-list last-child">
                                    <li><a href="#">Neque amet dapibus</a></li>
                                    <li><a href="#">Sed mattis quis rutrum</a></li>
                                    <li><a href="#">Accumsan suspendisse</a></li>
                                    <li><a href="#">Eu varius vitae magna</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <div class="4u">

                <!-- Blurb -->
                <section>
                    <h2>Why we donate</h2>

                    <p>
                        We here at Blackrock feel it is our duty as a business and a member of the community to
                        contribute to the success of our world's charities.
                        Every week, we encourage our employees to provide donations for the charity, as well as to vote
                        for next week's charity.
                    </p>
                </section>

            </div>
        </div>
    </footer>
</div>
<!--
 Copyright
<div id="copyright">
    &copy; Untitled. All rights reserved. | Design: <a href="http://html5up.net">HTML5 UP</a>
</div>-->

</body>
</html>