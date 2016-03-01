$(document).ready(function() {
    ts3_getNbUser();
});

function ts3_getNbUser()
{
    $.ajax({
        url: $('.ts3-online').data('ajax-url'),
        type: 'post',
        dataType: 'json',
        success: function(obj) {
            if (obj.nbr > 0) {
                $('.ts3-online strong').text(obj.nbr_txt);
                $('.ts3-online span').text(obj.txt);
                $('.ts3-online').show();
            } else {
                $('.ts3-online').hide();
            }
            window.setTimeout(ts3_getNbUser, 300000);
        },
        error: function() {
            $('.ts3-online').hide();
            window.setTimeout(ts3_getNbUser, 300000)
        }
    });
}
