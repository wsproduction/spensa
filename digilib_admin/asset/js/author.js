/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($) {

     $.fn.serialize = function (options) {
         return $.param(this.serializeArray(options));
     };

     $.fn.serializeArray = function (options) {
         var o = $.extend({
         checkboxesAsBools: false
     }, options || {});

     var rselectTextarea = /select|textarea/i;
     var rinput = /text|hidden|password|search/i;

     return this.map(function () {
         return this.elements ? $.makeArray(this.elements) : this;
     })
     .filter(function () {
         return this.name && !this.disabled &&
             (this.checked
             || (o.checkboxesAsBools && this.type === 'checkbox')
             || rselectTextarea.test(this.nodeName)
             || rinput.test(this.type));
         })
         .map(function (i, elem) {
             var val = $(this).val();
             return val == null ?
             null :
             $.isArray(val) ?
             $.map(val, function (val, i) {
                 return { name: elem.name, value: val };
             }) :
             {
                 name: elem.name,
                 value: (o.checkboxesAsBools && this.type === 'checkbox') ? //moar ternaries!
                        (this.checked ? 'true' : 'false') :
                        val
             };
         }).get();
     };

})(jQuery);

$(function(){    
    
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
    
    /* SUBMIT ACTIONS */    
    $('#fAdd').live('submit',function(){
        frmID = $(this);
        msgID = $('#message');
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize({ checkboxesAsBools: true });
        
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
                $.post('author/delete', {
                    val:arrayID
                }, function(o){
                    $.get('author/read', {
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
    $('#pagePaging').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        $.get('author/read', {
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
            $.get('author/read', {
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
            $.get('author/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
            
        }
        
    });
    
});


