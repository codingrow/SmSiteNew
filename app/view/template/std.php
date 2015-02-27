<?php
use Sm\Core\URI;
use Sm\html\HTML;
?>

<?= MAIN_URL ?>home

<!DOCTYPE HTML>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <script> document.documentElement.className = 'js'; </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">        <!-- MAKE THE VEWPORT THING && apple_touch_icon-->
    <link rel="shortcut icon" href="<?= MAIN_URL.'p/img/icons/favicon.ico'; ?>">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,400italic' rel='stylesheet' type='text/css'>
    <?= HTML::inc_js('jquery-1.11.1')?>
    <title>{{title}}</title>
</head>
    {{nest_header}}
<section class="mainHeader clearfix">
    <div class="container clearfix">
        <div class="title clearfix">
            <h2>{{title}}</h2>
        </div>
    </div>
</section>
<body>
    <section class="testNotReal clearfix">
        <div class="container clearfix">
            <div class="testTitle clearfix" style="height:100%; width:100%;">
                {{nest_body}}
            </div>
        </div>
    </section>
</body>
<div id="footer-wrap">
    <footer class="container_30">
        <section class="grid_8">
            <h3> Got something to say?</h3>
            <form action="" method="post">
                <input type="text" name="name" placeholder="Your Name" />
                <input type="text" name="email" placeholder="Your Email" />
                <textarea name="projectDetails" placeholder="Your Comment" ></textarea>
                <button> Submit! </button>
            </form>
        </section>
    </footer>
</div>

<div id="siteInfo">
    <footer class="container_30">
        <p> Copyright '14' -- SBDA -- All Rights Reserved</p>
        <nav>
            <ul>
                <li><?= HTML::anchor('home', 'HOME', 'The Portal to the site')?></li>
                <li><?= HTML::anchor('read', 'READ', 'Read up on your favorite topics')?></li>
                <li><?= HTML::anchor('post', 'POST', 'Add to the community')?></li>
                <li><?= HTML::anchor('blog', 'BLOG', 'Interact with our blog!')?></li>
                <li><?= HTML::anchor('contact', 'CONTACT US', 'Got a question? Have a comment? Let us know!')?></li>
            </ul>
        </nav>
    </footer>
</div>
<link href='http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
</html>