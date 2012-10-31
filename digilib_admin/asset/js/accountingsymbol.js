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
            name : 'accounting_symbol_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama Mata Uang',
            name : 'accounting_symbol_title',
            width : 450,
            sortable : true,
            align : 'left'
        }, {
            display : 'Symbol',
            name : 'accounting_symbol',
            width : 80,
            sortable : true,
            align : 'center'
        }, {
            display : 'Status',
            name : 'accounting_symbol_status',
            width : 60,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Tanggal Input',
            name : 'accounting_symbol_entry',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tanggal Update',
            name : 'accounting_symbol_entry_update',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
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
                        $(listId + ' .trSelected td[abbr=accounting_symbol_id] div').each(function() {
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
            name : 'accounting_symbol_id',
            isdefault : true
        }, {
            display : 'Nama Mata Uang',
            name : 'accounting_symbol_title'            
        }, {
            display : 'Symbol',
            name : 'accounting_symbol'            
        } ],
        nowrap : false,
        sortname : "accounting_symbol_id",
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
    
    /* BUTTON ACTION */
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    
});

