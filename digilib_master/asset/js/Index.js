/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $('#username').focus();
    
    $('#fLogin').live('submit',function(){
        frmID = $(this);
        msgID = $('#message');
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        $(msgID).fadeOut('slow');
        $.post(url, data, function(o){
            $(frmID)[0].reset();
            if (o[0]) {
                window.location = o[1];
            } else {
                $(msgID).html(o[1]).fadeIn('slow');
            }
        }, 'json');
        return false;
    })
    
    
});


