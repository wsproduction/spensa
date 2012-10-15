/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    $.get('dashboard/read', function (o){
        //console.log(o);
        for (var i=0;i<o.length;i++) {
            $('#listData').append(
                '<div>' + o[i].id + 
                ' - ' + o[i].text + 
                ' <a href="#" class="edit" >Edit</a>' +
                ' <a href="#" class="delete" rel="' + o[i].id + '" >Delete</a>' +
                ' </div>');
        }
    }, 'json');
    
    $('#fData').submit(function(){
        deleteItem = $(this);
        var url =  $(this).attr('action');
        var data =  $(this).serialize();
        
        $.post(url, data, function(o){
            $('#listData').append(
                '<div>' + o.id + 
                ' - ' + o.text + 
                ' <a href="#" class="edit" >Edit</a>' +
                ' <a href="#" class="delete" rel="' + o.id + '" >Delete</a>' +
                ' </div>');
            deleteItem[0].reset();
        }, 'json');
        
        return false;
    })
    
    $('.delete').live('click',function(){
        
        deleteItem = $(this);
        var id =  $(this).attr('rel');
        
        $.post('dashboard/delete', {
            'id' : id
        }, function(o){
            deleteItem.parent().remove();
        });
    });
});


