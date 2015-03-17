<?php
use Sm\html\HTML;

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>{{title}}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <?= HTML::css('sm-style') ?>
    <?= HTML::inc_js('jquery.min') ?>
    <?= HTML::inc_js('jquery.dropotron.min') ?>
    <script>
        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };
        (function ($) {
            $(function () {
                $('.if-js').show();
                var small_size = false;
                var resize = function () {
                    var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
                    if (!small_size && w < 900) {
                        var elem = $('#main .distributer');
                        elem.removeClass('distributer');
                        elem.addClass('distributer-inactive');
                        small_size = true;
                    } else if (small_size && w >= 900) {
                        var elem = $('#main .distributer-inactive');
                        elem.removeClass('distributer-inactive');
                        elem.addClass('distributer');
                        small_size = false;
                    }
                };
                // Advanced test for touch events
                if(isMobile.any()){
                    var elem = $('#main .distributer');
                    elem.removeClass('distributer');
                    elem.addClass('distributer-inactive');
                    small_size = true;
                }
                window.onresize = resize;
                window.onload = resize;
                // Dropdowns.
                $('#nav').find('> ul').dropotron({
                    mode: 'fade',
                    speed: 300,
                    alignment: 'center',
                    noOpenerFade: true
                });
            });
        })(jQuery);
    </script>
</head>
<body class="right-sidebar">
{{nest_header}}
<!-- Main -->
<div class="wrapper">
    <div id="main" class="row">
        <div class="row  distributer">
            <!-- Content -->
            <div class="row distributed content">
                {{nest_body}}
                <article class="module">
                    <a href="#" class="image featured"><?= HTML::img('http://cdn.papermag.com/uploaded_images/ocean-frank-507ed3e6ed64b.jpg', 'Banner Image', [], true) ?></a>
                </article>
            </div>
            <!-- Sidebar -->
            {{nest_sidebar}}
        </div>
        <!--        FEATURES -->
    </div>
</div>
<div class="wrapper features dark">
    <div class="row distributer images clearfix">
        <section class="distributed">
            <div class="image-wrapper">
                <a href="#" class="image featured"><img src="https://oztoice.files.wordpress.com/2014/07/20120121-day105-211.jpg?w=467" alt="I don't even know, man"/></a>
            </div>
        </section>
        <section class="distributed">
            <div class="image-wrapper">
                <a href="#" class="image featured"><img src="http://img.scoop.it/3_KRGsea0kkRSMkdDuVWojl72eJkfbmt4t8yenImKBVvK0kTmF0xjctABnaLJIm9" alt="Image? Image!"/></a>
            </div>
        </section>
        <section class="distributed">
            <div class="image-wrapper">
                <a href="#" class="image featured"><img src="http://img.scoop.it/S2NTc6yyIMyF889-VNoP1Tl72eJkfbmt4t8yenImKBVvK0kTmF0xjctABnaLJIm9" alt="Yet another image? Yet another image!"/></a>
            </div>
        </section>
    </div>
    <div class="row distributer">
        <section class="distributed">
            <header>
                <h3>Dolor sit consequat magna</h3>
            </header>
            <p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
               vel sem sit dolor neque semper magna lorem ipsum.</p>
            <ul class="actions">
                <li><a href="#" class="button">Elevate my awareness</a></li>
            </ul>
        </section>
        <section class="distributed">
            <header>
                <h3>Dolor sit consequat magna</h3>
            </header>
            <p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
               vel sem sit dolor neque semper magna lorem ipsum.</p>
            <ul class="actions">
                <li><a href="#" class="button">Elevate my awareness</a></li>
            </ul>
        </section>
        <section class="distributed">
            <header>
                <h3>Dolor sit consequat magna</h3>
            </header>
            <p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
               vel sem sit dolor neque semper magna lorem ipsum.</p>
            <ul class="actions">
                <li><a href="#" class="button">Elevate my awareness</a></li>
            </ul>
        </section>
    </div>
</div>
<!-- Footer -->
<div id="footer-wrapper" class="wrapper">
    <div id="footer" class="row container">
        <header class="major">
            <h2>{{site_title}}</h2>

            <p>To be honest, I don't know what I'm going to put here</p>
        </header>
    </div>
    <!-- COPYRIGHT  -->
    <div id="copyright" class="row container">
        &copy; {{site_title}}. All rights reserved.
    </div>
</div>

</body>
</html>