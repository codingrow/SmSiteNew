<?php
use Sm\html\HTML;

?>
<!DOCTYPE HTML>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <script> document.documentElement.className = 'js'; </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- MAKE THE VEWPORT THING && apple_touch_icon-->
    <link rel="shortcut icon" href="<?= MAIN_URL . 'p/img/icons/favicon.ico'; ?>">
    <title>Two Column 1 - Halcyonic by HTML5 UP</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <script src="<?= MAIN_URL ?>p/js/jquery.min.js"></script>
    <script src="<?= MAIN_URL ?>p/js/skel.min.js"></script>
    <script src="<?= MAIN_URL ?>p/js/skel-layers.min.js"></script>
    <script src="<?= MAIN_URL ?>p/js/init.js"></script>

        <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/skel.css"/>
        <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/style.css"/>
    <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/style_one.css"/>
    <link rel="stylesheet" href="<?= MAIN_URL ?>p/css/style_desktop.css"/>
    <title>{{title}}</title>
</head>
<body class="subpage">


<!-- Header -->
<div id="header-wrapper">
    <header id="header" class="container">
        <div class="row">
            <div class="12u">

                <!-- Logo -->
                <h1><a href="#" id="logo">Halcyonic</a></h1>

                <!-- Nav -->
                <nav id="nav">
                    <a href="index.html">Homepage</a>
                    <a href="threecolumn.html">Three Column</a>
                    <a href="twocolumn1.html">Two Column #1</a>
                    <a href="twocolumn2.html">Two Column #2</a>
                    <a href="onecolumn.html">One Column</a>
                </nav>

            </div>
        </div>
    </header>
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

                            <h3>A generic two column layout</h3>
                        </header>
                        {{nest_body}}
                    </section>

                </div>
                <div class="3u">

                    <!-- Sidebar -->
                    <section>
                        <header>
                            <h2>Magna Phasellus</h2>
                        </header>
                        <ul class="link-list">
                            <li><a href="#">Sed dolore viverra</a></li>
                            <li><a href="#">Ligula non varius</a></li>
                            <li><a href="#">Nec sociis natoque</a></li>
                            <li><a href="#">Penatibus et magnis</a></li>
                            <li><a href="#">Dis parturient montes</a></li>
                            <li><a href="#">Nascetur ridiculus</a></li>
                        </ul>
                    </section>
                    <section>
                        <header>
                            <h2>Ipsum Dolor</h2>
                        </header>
                        <p>
                            Vehicula fermentum ligula at pretium. Suspendisse semper iaculis eros, eu aliquam
                            iaculis. Phasellus ultrices diam sit amet orci lacinia sed consequat.
                        </p>
                        <ul class="link-list">
                            <li><a href="#">Sed dolore viverra</a></li>
                            <li><a href="#">Ligula non varius</a></li>
                            <li><a href="#">Dis parturient montes</a></li>
                            <li><a href="#">Nascetur ridiculus</a></li>
                        </ul>
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
                                    <li><a href="<?= MAIN_URL ?>home">home</a></li>
                                    <li><a href="#">Sed mattis quis rutrum</a></li>
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
                            <div class="3u">
                                <ul class="link-list last-child">
                                    <li><a href="#">Neque amet dapibus</a></li>
                                    <li><a href="#">Sed mattis quis rutrum</a></li>
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
                    <h2>An Informative Text Blurb</h2>

                    <p>
                        Duis neque nisi, dapibus sed mattis quis, rutrum accumsan sed. Suspendisse eu
                        varius nibh. Suspendisse vitae magna eget odio amet mollis. Duis neque nisi,
                        dapibus sed mattis quis, sed rutrum accumsan sed. Suspendisse eu varius nibh
                        lorem ipsum amet dolor sit amet lorem ipsum consequat gravida justo mollis.
                    </p>
                </section>

            </div>
        </div>
    </footer>
</div>

<!-- Copyright -->
<div id="copyright">
    &copy; Untitled. All rights reserved. | Design: <a href="http://html5up.net">HTML5 UP</a>
</div>

</body>
</html>