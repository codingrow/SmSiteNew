/**
 * Created by Samuel on 3/12/2015.
 */
$(function () {
    /** necessary to make a toggle plugin ? **/
    var no_edit = false;
    $('.toggle-edit').on('click', function (e) {
        if (!no_edit) {
            $('.edit').hide();
            $(this).text('EDIT');
            no_edit = true
        }
        else {
            $('.edit').show();
            $(this).text('STOP EDITING');
            no_edit = false
        }
    });
});