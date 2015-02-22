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
    <!--    <label for="date">-->
    <!--        Date of donation:-->
    <!--        <input type="text" id="date" name="date" title="Date" value="--><?php
    //            $today = getdate();
    //            echo $today["month"]."/".$today["mday"]."/".$today["year"];
    //        ?><!--"/>-->
    </label><br/>

    <button>Submit</button>
</form>