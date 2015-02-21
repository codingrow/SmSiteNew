<form method="post" action="<?= MAIN_URL ?>manage/_add_charity">
    <label for="name">
        Name:
        <input type="text" id="name" name="name" title="Name"/>
        <span class="name_error"></span>
    </label>
    <label for="description">
        Description:
        <input type="text" id="description" name="description" title="Description"/>
        <span class="description_error"></span>
    </label>
    <label for="contact_name">
        Primary Contact:
        <input type="text" id="contact_name" name="contact_name" title=""/>
        <span class="contact_name_error"></span>
    </label>
    <label for="url">
        Website:
        <input type="text" id="url" name="url" title="Website"/>
        <span class="url_error"></span>
    </label>
    <label for="tax_code">
        Tax Code:
        <input type="text" id="tax_code" name="tax_code" title="Tax Code"/>
        <span class="Name error"></span>
    </label>
    <label for="address">
        Address:
        <input type="text" id="address" name="address" title="Address"/>
        <span class="Name error"></span>
    </label>
    <label for="phone_number">
        Phone Number:
        <input type="text" id="phone_number" name="phone_number" title="Phone Number"/>
        <span class="Name error"></span>
    </label>
    <button>Create charity</button>

</form>