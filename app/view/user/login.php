<?php
use Sm\Storage\Session;
use Model\Group;
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
<article>
    <form id="login_form" action="<?= MAIN_URL . 'user/_login' ?>" method="post">
        <div class="login_elements"><label for="user_identifier">Username:</label><input type="text" id="username"
                                                                                         name="user_identifier"
                                                                                         title="Username"/>

            <div class="error" id="username_error"></div>
        </div>
        <div class="login_elements"><label for="password">Password:</label><input type="password" id="password"
                                                                                  name="password"/>

            <div class="error" id="password_error"></div>
        </div>
        <div class="login_elements">
            <button class="loginbutton" type="submit">Go!</button>
        </div>
    </form>
</article>
