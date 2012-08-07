/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){    
    $.get('getAuthor', function(o){
        $("#author").tokenInput(o, {
            theme: "facebook",
            preventDuplicates: true
        });
    }, 'json');
    
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
    $('#profile').elrte(opts);
    
    /* CHANGE VALUE ACTIONS */  
    $('#country').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $.get(url, {id:id}, function(o){
            $('#city').html(o);
        }, 'json');
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
                    $(frmID)[0].reset();
                }
            }
            $(msgID).html(o[2]).fadeIn('slow');
        }, 'json');
        
        return false;
    });
    
    $('#fUpload').live('submit',function(){
        $(this).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                //console.log(parOut); 
                if (parOut) {
                    var obj = eval('(' + parOut +')');
                    console.log(obj.html); 
                    $('#pesan').html($.base64.decode(obj.html));
                }
            }
        });
        return false;
    });
    
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
                $.post('catalog/delete', {
                    val:arrayID
                }, function(o){
                    $.get('catalog/read', {
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
    
    /* SET COOKIE */
    Set_Cookie('_page', 1, '', '/', '', '');
    
    /* PAGING */
    $('#paging').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        $.get('catalog/read', {
            p:page
        }, function(o){
            Set_Cookie('_page', page, '', '/', '', '');
            $('table#list tbody').html(o);
        }, 'json');
    });
    $('.action_prev').live('click',function(){
        keyID = $('#paging');
        var page = parseInt($(keyID).val())-1;
        if (page>0) {
            $.get('catalog/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
        }
    });
    $('.action_next').live('click',function(){
        keyID = $('#paging');
        var page = parseInt($(keyID).val())+1;
        if (page<$('#maxPaging').val()) {
            $.get('catalog/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
        }
        
    });
    
});


