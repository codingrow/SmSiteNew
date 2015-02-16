/**
 * Created by Samuel on 2/7/2015.
 */
$(function(){
    $('form').live('submit', function(){
        var hasError = false;
        $.post($(this).attr('action'), $(this).serialize(), function(response){
            $('.error').text('');
            for (var key in response) {
                if (response.hasOwnProperty(key)) {
                    $('.error.'+key).text(response[key]);
                    hasError = true;
                }
            }
            console.log(hasError);
            if(hasError === false){
                window.location = 'http://localhost/SmSiteNew/me';
            }
        },'json');

        return false;
    });
});