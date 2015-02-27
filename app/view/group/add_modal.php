<article>
    <form id="create_group_form" class="full-children" action="<?= MAIN_URL . 'group/_create' ?>" method="post">
        <div class="half-children lr-float-children baby-row">
            <label class="floater" for="name">Group Name:
                <div class="error" id="name_error"></div>
                <input type="text" id="name" name="name" title="Group Name"/>
            </label>
            <label class="floater" for="type">Type of Group:
                <select class="hardcoded" name="type">
                    <option value="1">Standard</option>
                    <option value="2">Study Group</option>
                    <option value="3">Coalition</option>
                    <option value="4">These are going to come from the database</option>
                </select>
            </label>
        </div>
        <label for="description">Description of Group:
            <textarea id="description" name="description"></textarea>
        </label>
        <button class="loginbutton" type="submit">Go!</button>
    </form>
</article>