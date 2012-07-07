/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    $('#fLogin').live('submit',function(){
        deleteItem = $(this);
        var url =  $(this).attr('action');
        var data =  $(this).serialize();
        
        $.post(url, data, function(o){
            if (o[0]) {
                window.location = o[1];
            } else {
                alert('Login Gagal');
            }
        }, 'json');
        
        return false;
    })
    
    
});


