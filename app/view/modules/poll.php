<section>
    <header>
        <h2>Vote for the next charity</h2>
    </header>
    <p>
        Cast your vote to choose which charity we'll donate to next.
    </p>
    <!--                        <ul class="link-list">-->
    <!--                            <li><a href="#">Sed dolore viverra</a></li>-->
    <!--                            <li><a href="#">Ligula non varius</a></li>-->
    <!--                            <li><a href="#">Dis parturient montes</a></li>-->
    <!--                            <li><a href="#">Nascetur ridiculus</a></li>-->
    <!--                        </ul>-->
    <form action="charity_vote.php" method="post" class="charity_vote_form">
        <!--                            <select name="charity_choice">-->
        <!--                                <option value="charity_one">Charity One</option>-->
        <!--                                <option value="charity_two">Charity Two</option>-->
        <!--                                <option value="charity_three">Charity Three</option>-->
        <!--                                <option value="charity_four">Charity Four</option>-->
        <!--                            </select>-->
        <input type="radio" name="charity" value="1">Charity one<br/>
        <input type="radio" name="charity" value="2">Charity two<br/>
        <input type="radio" name="charity" value="3">Charity three<br/>
        <input type="radio" name="charity" value="4">Charity four<br/>
        <input type="submit" value="Vote!"/>

    </form>
</section>