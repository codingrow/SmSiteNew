<?php
/**
 * User: Samuel
 * Date: 1/29/2015
 * Time: 2:37 PM
 */
?>
<?= Sm\html\HTML::inc_js('user/signup') ?>
<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <article>
        <form id="userSubmitForm" class="full-children" action="<?= MAIN_URL . 'user/_signup' ?>" method="post">
            <label class="required" for="username">
                Username:
                <input class="required" type="text" id="username" name="username" title="Username" placeholder="username"/>

                <span class="username error"></span>
            </label>
            <label class="required" for="primary_email">
                Email Address:
                <input class="required" type="text" id="primary_email" name="primary_email" placeholder="Email Adress"/>

                <span class="primary_email error"></span>
            </label>

            <div class="half-children lr-float-children baby-row">
                <label class="required floater" for="password">
                    Password:
                    <input class="required" type="password" id="password" name="password" placeholder="password"/>
                    <span class="password error"></span>
                </label>

                <label class="required floater" for="password_verify">
                    Verify Password:
                    <input class="required" type="password" id="password_verify" name="password_verify" placeholder="Verify Password"/>
                    <span class="password_verify error"></span>
                </label>
            </div>


            <div class="half-children lr-float-children baby-row">
                <label class="floater" for="first_name">
                    First Name:
                    <input class="required" type="text" id="first_name" name="first_name" placeholder="First Name"/>
                    <span class="first_name error"></span>
                </label>

                <label class="floater" for="last_name">
                    Last Name:
                    <input type="text" id="last_name" name="last_name" placeholder="Last Name"/>
                    <span class="last_name error"></span>
                </label>
            </div>

            <button type="submit" class="signup_button">Submit</button>
        </form>
    </article>
</article>
