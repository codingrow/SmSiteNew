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
    <?= HTML::css('telephasic-style') ?>
    <?= HTML::inc_js('jquery.min') ?>
    <?= HTML::inc_js('telephasic/jquery.dropotron.min') ?>
    <?= HTML::inc_js('telephasic/init') ?>
</head>
<script>
    $(function () {
        //$('#sidebar').hide();
        //document.getElementById('content').style.maxWidth = '100%';
        //document.getElementById('content').style.width = '100%';
    })
</script>
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
                    <a href="#" class="image featured"><?= HTML::img('telephasic/pic01.jpg', 'Banner Image', ['height' => '200px']) ?></a>
                </article>
                <article class="module">
                    <a href="#" class="image featured"><?= HTML::img('telephasic/pic03.jpg', 'Banner Image', ['height' => '200px']) ?></a>
                </article>
            </div>
            <!-- Sidebar -->
            {{nest_sidebar}}
        </div>
        <!--        FEATURES -->
    </div>
</div>
<div class="wrapper features dark">
    <div class="row distributer">
        <section class="feature distributed">
            <div class="image-wrapper">
                <a href="#" class="image featured"><?= HTML::img('telephasic/pic03.jpg') ?></a>
            </div>
            <header>
                <h3>Dolor sit consequat magna</h3>
            </header>
            <p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
               vel sem sit dolor neque semper magna lorem ipsum.</p>
            <ul class="actions">
                <li><a href="#" class="button">Elevate my awareness</a></li>
            </ul>
        </section>
        <section class="feature distributed">
            <div class="image-wrapper">
                <a href="#" class="image featured"><?= HTML::img('telephasic/pic04.jpg') ?></a>
            </div>
            <header>
                <h3>Dolor sit consequat magna</h3>
            </header>
            <p>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur
               vel sem sit dolor neque semper magna lorem ipsum.</p>
            <ul class="actions">
                <li><a href="#" class="button">Elevate my awareness</a></li>
            </ul>
        </section>
        <section class="feature distributed">
            <div class="image-wrapper">
                <a href="#" class="image featured"><?= HTML::img('telephasic/pic05.jpg') ?></a>
            </div>
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