<?php
/**
 * User: Samuel
 * Date: 2/20/2015
 * Time: 3:26 PM
 *
 * Test the file upload functionality
 */
?>
<section id="main" class="main container">
    <div id="primary" class="clearfix">
        <form method="post" enctype="multipart/form-data" action="<?= MAIN_URL ?>test/_file_upload">
            <?= MAIN_URL ?>test/_file_upload
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
            <label for="nothing">This is unnecessary: <input type="text" name="nothing"/></label>
            <br/>
            <label for="file">This is unnecessary: <input type="file" name="file"/></label>

            <button>This is the submit</button>
        </form>
    </div>
</section>
