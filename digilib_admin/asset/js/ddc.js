/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){  
    var listId = '#list';
    var title = $(listId).attr('title');
    var link_r = $(listId).attr('link_r');
    var link_c = $(listId).attr('link_c');
    var link_d = $(listId).attr('link_d');
    
    var option = {
        url : link_r,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'ddc_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nomor Kelasifikasi',
            name : 'ddc_classification_number',
            width : 100,
            sortable : true,
            align : 'left'
        }, {
            display : 'Keterangan',
            name : 'ddc_title',
            width : 700,
            sortable : true,
            align : 'left'
        }, {
            display : 'Level',
            name : 'ddc_level',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        },  {
            display : 'Option',
            name : 'option',
            width : 80,
            align : 'center'
        }],
        buttons : [ {
            name : 'Add',
            bclass : 'add',
            onpress : function() {
                window.location = link_c
            }
        }, {
            name : 'Delete',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId + ' .trSelected td[abbr=ddc_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId).flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }, {
            separator : true
        } ],
        searchitems : [ {
            display : 'ID',
            name : 'ddc_id',
            isdefault : true
        }, {
            display : 'Nomor Klasifikasi',
            name : 'ddc_classification_number'
        }, {
            display : 'Keterangan',
            name : 'ddc_title'
        }, {
            display : 'Level',
            name : 'ddc_level'
        } ],
        nowrap : false,
        sortname : "ddc_id",
        sortorder : "asc",
        usepager : true,
        title : title,
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 350
    };
    
    $(listId).flexigrid(option);    
    
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


