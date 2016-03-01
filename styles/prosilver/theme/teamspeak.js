$(document).ready(function() {
    ts3_refresh_server(true, true);
});

function ts3_refresh_server() {
    var progressText = $('#ts3-status').data('progress');
    $('#ts3-status').text(progressText).css('color', '#FF590E');
    $('#ts3-link').hide();
    $('#ts3-ip, #ts3-pwd').val(progressText);

    $.ajax({
        url: $('.table-ts3-list').data('ajax-url'),
        type: 'post',
        dataType: 'json',
        success: function(obj) {
            $('#ts3-pwd').val(obj.pwd);
            $('#ts3-ip').val(obj.url);

            // Offline
            if (!obj.status) {
                $('#ts3-status').text(obj.statusText).css('color', '#F00');
                $('#ts3-link').hide();
                $('.table-ts3-list tbody').html('<tr><td colspan="6" class="text-center" style="color: #F00;">' + obj.statusText + '</td></tr>');

                return;
            }

            $('#ts3-status').text(obj.statusText).css('color', '#00AD00');
            var url = 'ts3server://'+obj.url+'/?port='+obj.port+'&nickname='+obj.login;
            if (obj.pwd !== '') {
                url += '&password='+obj.pwd;
            }
            $('#ts3-link').attr('href', url).show();

            var code = '';
            if (obj.users_msg) {
                code = '<tr><td colspan="6" class="text-center">' + obj.users_msg + '</td></tr>';
            } else {
                $.each(obj.users, function(i, user) {
                    code += '<tr><td>'+user.login+'</td><td><a href="'+url+'&cid='+user.cid+'">'+user.channel+'</a></td><td>'+user.date+'</td><td>'+user.ip+'</td><td>'+user.os+'</td><td>'+user.version+'</td></tr>';
                });
            }
            $('.table-ts3-list tbody').html(code);
        }
    });
}