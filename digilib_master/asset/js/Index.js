/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    $('#fLogin').live('submit',function(){
        msgID = $('#message');
        var url =  $(this).attr('action');
        var data =  $(this).serialize();
        $(msgID).fadeOut('slow');
        $.post(url, data, function(o){
            if (o[0]) {
                window.location = o[1];
            } else {
                $(msgID).html(o[1]).fadeIn('slow');
            }
        }, 'json');
        
        return false;
    })
    
    
});


