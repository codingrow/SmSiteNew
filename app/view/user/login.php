<?php
?>
<? //= Sm\html\HTML::inc_js('user/login')?>

<script>
    $(function () {
        $("#login_form").on("submit", function (event) {
            $("#username").val($.trim($("#username").val()));
            if ($("#username").val().length == 0) {
                $("#username_error").text("Please enter a username.");
                event.preventDefault();
            }
            if ($("#password").val().length == 0) {
                $("#password_error").text("Please enter a password.");
                event.preventDefault();
            }
        });
    });
</script>
<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <article>
        <form id="login_form" class="full-children" action="<?= MAIN_URL . 'user/_login' ?>" method="post">
            <label for="username">Username:
                <div class="error" id="username_error"></div>
                <input type="text" id="username" name="username" title="Username"/>
            </label>
            <label for="password">Password:
                <div class="error" id="password_error"></div>
                <input type="password" id="password" name="password"/>
            </label>
            <button class="loginbutton" type="submit">Go!</button>
        </form>
    </article>
</article>
