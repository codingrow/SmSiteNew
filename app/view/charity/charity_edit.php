<form method="post" action="<?= MAIN_URL ?>manage/_edit_charity" class="add_charity_class">
    <label for="name">
        Charity To Edit:
        <input type="text" id="name" name="name" title="Name"/>
        <span class="name_error"></span>
    </label> <br/><br/>

    <h3>Fields to edit</h3>
    <label for="description">
        New Description:<br/>
        <textarea id="description" name="description" title="Description" cols="30"
                  rows="10"><?= $charity->entity->getDescription() ?></textarea>
        <span class="description_error"></span>
    </label><br/>
    <label for="contact_name">
        New Primary Contact:
        <input type="text" id="contact_name" name="contact_name" title=""/>
        <span class="contact_name_error"></span>
    </label><br/>
    <label for="url">
        New Website:
        <input type="text" id="url" name="url" title="Website"/>
        <span class="url_error"></span>
    </label><br/>
    <label for="tax_code">
        New Tax Code:
        <input type="text" id="tax_code" name="tax_code" title="Tax Code"/>
        <span class="Name error"></span>
    </label><br/>
    <label for="address">
        New Address:
        <input type="text" id="address" name="address" title="Address"/>
        <span class="Name error"></span>
    </label><br/>
    <label for="phone_number">
        New Phone Number:
        <input type="text" id="phone_number" name="phone_number" title="Phone Number"/>
        <span class="Name error"></span>
    </label><br/>
    <button>Update charity</button>

</form>