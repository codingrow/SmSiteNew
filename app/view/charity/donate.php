<form method="post" action="<?= MAIN_URL ?>manage/_donate">
    <label for="name">
        Charity Name:
        <input type="text" id="name" name="name" title="Charity Name" , value="<?= $charity->getName() ?>"/>
        <span class="username error"></span>
    </label><br/>
    <label for="amount">
        Amount donating:
        <input type="text" id="amount" name="amount" title="Amount to donate"/>
        <span class="username error"></span>
    </label><br/>

    <button>Submit</button>
</form>