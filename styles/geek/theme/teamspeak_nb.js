$(document).ready(function() {
    window.setTimeout(ts3_getNbUser, 30000);
});

function ts3_getNbUser()
{
    $.ajax({
        url: $('.ts3-online').data('ajax-url'),
        type: 'post',
        dataType: 'json',
        success: function(obj) {
            // Homepage
            if ($('.ts3-online').length) {
                if (obj.nbr > 0) {
                    $('.ts3-online strong').text(obj.nbr_txt);
                    $('.ts3-online span').text(obj.txt);
                    $('.ts3-online').show();
                } else {
                    $('.ts3-online').hide();
                }
            }

            // Puce nb
            if (obj.nbr > 0) {
                $('li.tab.teamspeak strong .counter').text(obj.nbr);
                $('li.tab.teamspeak').addClass('non-zero');
            } else {
                $('li.tab.teamspeak').removeClass('non-zero');
            }

            window.setTimeout(ts3_getNbUser, 30000);
        },
        error: function() {
            $('.ts3-online').hide();
            window.setTimeout(ts3_getNbUser, 30000)
        }
    });
}
