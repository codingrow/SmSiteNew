<form method="post" action="<?= MAIN_URL ?>employees/_add">
    <label for="username">
        Username:
        <input type="text" id="username" name="username" title="Username"/>
        <span class="username error"></span>
    </label>

    <br/>

    <label for="password">
        Password:
        <input type="text" id="password" name="password"/>
        <span class="password error"></span>
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
    <label for="primary_email">
        Email Address:
        <input type="text" id="primary_email" name="primary_email"/>
        <span class="primary_email error"></span>
    </label>
    <button>Submit</button>
</form>