<?php
/**
 * User: Samuel
 * Date: 1/29/2015
 * Time: 2:37 PM
 */
?>
<?= Sm\html\HTML::inc_js('user/signup')?>
<section id="main" class="main container">
    <div id="primary" class="clearfix">
        <article>
            <form id="userSubmitForm" action="<?= MAIN_URL . 'user/_signup' ?>" method="post">
                <label for="username">
                    Username:
                    <input type="text" id="username" name="username" title="Username"/>
                    <span class="username error"></span>
                </label>

                <br/>

                <label for="password">
                    Password:
                    <input type="password" id="password" name="password"/>
                    <span class="password error"></span>
                </label>

                <br/>

                <label for="password_verify">
                    Verify Password:
                    <input type="password" id="password_verify" name="password_verify"/>
                    <span class="password_verify error"></span>
                </label>

                <br/>

                <label for="first_name">
                    First Name:
                    <input type="text" id="first_name" name="first_name"/>
                    <span class="first_name error"></span>
                </label>

                <br/>

                <label for="last_name">
                    Last Name:
                    <input type="text" id="last_name" name="last_name"/>
                    <span class="last_name error"></span>
                </label>

                <br/>

                <button type="submit">Submit</button>
            </form>
        </article>
    </div>
</section>