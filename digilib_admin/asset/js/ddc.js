/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){  
        
    
    if ($('#level').val()==2) {
        $('tr.sub1').fadeIn('slow');
    } else if ($('#level').val()==3) {
        $('tr.sub1').fadeIn('slow');
        $('tr.sub2').fadeIn('slow');
    }
    
    /* WYSIWYG elRTE */
    elRTE.prototype.options.panels.web2pyPanel = [
    'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
    'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
    'link', 'image'
    ];
    elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];
    
    var opts = {
        cssClass : 'el-rte',
        // lang     : 'ru',
        height   : 180,
        width    : 600,
        toolbar  : 'web2pyToolbar',
        cssfiles : ['css/elrte-inner.css']
    }
    $('#description').elrte(opts);
    
    /* BUTTON ACTION */
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    
    /* SUBMIT ACTIONS */    
    $('#fAdd').live('submit',function(){
        frmID = $(this);
        msgID = $('#message');
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        
        $(msgID).fadeOut('slow');
        $.post(url, data, function(o){
            if (o[0]) {
                if (o[1]) {
                    $('#description').elrte('val',' ');
                    $(frmID)[0].reset();
                }
            }
            $(msgID).html(o[2]).fadeIn('slow');
        }, 'json');
        
        return false;
    });
    
    /* CHANGE VALUE ACTIONS */  
    $('#level').live('change',function(){
        var url = $(this).attr('link');
        if ($(this).val()==2) {
            $.get(url, function(o){
                $('tr.sub1 td.sub1').html(o);
                form_tips('sub1');
                $("#fAdd #sub1").rules("add",{
                    required : true
                });
            }, 'json');
            
            $('tr.sub1').fadeIn('slow');
        } else if ($(this).val()==3) {
            $.get(url, function(o){
                $('tr.sub1 td.sub1').html(o);
                form_tips('sub1');
                $("#fAdd #sub1").rules("add",{
                    required : true
                });
            }, 'json');
            
            
            var sub2  = '<select id="sub2" name="sub2" tips="Chose Level DDC">';
            sub2 += '   <option value="" selected></option>';
            sub2 += '</select>';
            $('tr.sub2 td.sub2').html(sub2);
            form_tips('sub2');
            $("#fAdd #sub2").rules("add",{
                required : true
            });
            
            $('tr.sub1').fadeIn('slow');
            $('tr.sub2').fadeIn('slow');
        } else {
            $("#fAdd #sub1").rules("add",{
                required : false
            });
            $("#fAdd #sub2").rules("add",{
                required : false
            });
            $('tr.sub1').fadeOut('slow');
            $('tr.sub2').fadeOut('slow');
        }
    });
    $('#sub1').live('change',function(){
        var url = $(this).attr('link');
        $.get(url,{
            id:$(this).val()
        }, function(o){
            $('tr.sub2 td.sub2').html(o);
            form_tips('sub2');
            $("#fAdd #sub2").rules("add",{
                required : true
            });
        }, 'json');
        
    });
    
    
});


