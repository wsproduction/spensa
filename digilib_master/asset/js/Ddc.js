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
    $('#btnAddData').live('click',function(){
        window.location = $(this).attr('link');
    });
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    $('#btnDeleteData').live('click',function(){
        var hiddenID = $('#hiddenID').val();
        var splitID = hiddenID.split(',');
        var arrayID = new Array();
        var idxArray = 0;
        var tempID;
        for (var i = 0 ; i < splitID.length ; i++) {
            tempID = splitID[i];
            if ($('#list_' + tempID).is(':checked')) {
                arrayID[idxArray] = tempID;
                idxArray++;
            }
        }
        
        if (arrayID.length > 0) {
            var conf = confirm("Are you sure to delete data?");
            if (conf) {
                $.post('ddc/delete', {
                    val:arrayID
                }, function(o){
                    $.get('ddc/read', {
                        p:Get_Cookie('_page')
                    }, function(o){
                        $('table#list tbody').html(o);
                    }, 'json');
                    
                }, 'json');
                
            }
        } else {
            alert('No item Selected');
        }
    });
    
    /* CHECKBOX ACTION */
    $('#cbSelectAll').live('click',function(){
        var hiddenID = $('#hiddenID').val();
        var splitID = hiddenID.split(',');
        var i;
        
        if($(this).is(':checked')){
            for (i=1; i<=splitID.length;i++) {
                $('#row_' + splitID[i]).removeClass().addClass('selected');
            }
            $('.cbList').attr('checked', true);
        } else {            
            for (i=1; i<splitID.length;i++) {
                $('#row_' + splitID[i]).removeClass().addClass($('#row_' + splitID[i]).attr('temp'));
            }
            $('.cbList').attr('checked', false);
        }
    });
    $('.cbList').live('click',function(){
        $('#cbSelectAll').attr('checked', false);
        if($(this).is(':checked')){
            $('#row_' + $(this).val()).removeClass().addClass('selected');
        } else {
            $('#row_' + $(this).val()).removeClass().addClass($('#row_' + $(this).val()).attr('temp'));
        }
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
    $('#fFilter').live('submit',function(){
        frmID = $(this);
        msgID = $('#message');
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        
        $(msgID).fadeOut('slow');
        $.post(url, data, function(o){
            if (o[0]) {
                $(frmID)[0].reset();
            }
            $(msgID).html(o[1]).fadeIn('slow');
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
    
    /* SET COOKIE */
    Set_Cookie('_page', 1, '', '/', '', '');
    
    /* PAGING */
    $('#pagePaging').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        $.get('ddc/read', {
            p:page
        }, function(o){
            Set_Cookie('_page', page, '', '/', '', '');
            $('table#list tbody').html(o);
        }, 'json');
        
    });
    $('#prevPaging').live('click',function(){
        keyID = $('#pagePaging');
        var page = parseInt($(keyID).val())-1;
        if (page>0) {
            $.get('ddc/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
            
        }
    });
    $('#nextPaging').live('click',function(){
        keyID = $('#pagePaging');
        var page = parseInt($(keyID).val())+1;
        if (page<$('#maxPaging').val()) {
            $.get('ddc/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
            
        }
        
    });
    
});


