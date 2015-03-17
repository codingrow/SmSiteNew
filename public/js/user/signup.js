/**
 * Created by Samuel on 2/7/2015.
 */
$(function(){
    $('form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            complete: function (data) {
                var hasError = false;
                var response = JSON.parse(data.responseText);
                //console.log(response)
                //console.log(data)
                $('.error').text('');
                for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                        $('.error.' + key).text(response[key]);
                        //console.log($('.error.'+key));
                        hasError = true;
                    }
                }
                if (hasError === false) {
                    window.location = $('#logo a').href();
                }
            }
        });
    });
});