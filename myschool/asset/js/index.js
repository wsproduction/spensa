$(function () {
    $('#form_login').live('submit',function(){
        var loading = $('#loading-progress');
        var message = $('.box-login .message');
        var parent = $(this);
        var action = $(parent).attr('action');
        var data = $(parent).serialize();
        
        $.ajax({
            url : action,
            data : data,
            type : 'post',
            dataType : 'xml',
            beforeSend : function() {
                $(loading).slideDown('fast');
            },
            success : function(results) {
                $(loading).slideUp('fast');
                $(results).find('data').each(function(){
                    var status = $(this).find('status').text();
                    if (status == '1') {
                        window.location = $(this).find('direct').text();
                    } else {
                        $(message).html($(this).find('message').text());
                    }
                });
            }
        });
        return false;
    });
});
