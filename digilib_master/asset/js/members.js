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
            name : 'members_id', 
            width : 60,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama Lengkap',
            name : 'members_name',
            width : 180,
            sortable : true,
            align : 'left'
        }, {
            display : 'Alamat',
            name : 'members_address',
            width : 400,
            sortable : true,
            align : 'left'
        }, {
            display : 'Kunjungan',
            name : 'publisher_description',
            width : 60,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Peminjaman',
            name : 'publisher_description',
            width : 60,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Kunjungan Terakhir',
            name : 'publisher_description',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Peminjaman Terakhir',
            name : 'publisher_description',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Status',
            name : 'publisher_description',
            width : 60,
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
                        $(listId + ' .trSelected td[abbr=members_id] div').each(function() {
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
            name : 'members_id',
            isdefault : true
        }, {
            display : 'Nama Anggota',
            name : 'members_name'            
        } ],
        nowrap : false,
        sortname : "members_id",
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
                $.post('members/delete', {
                    val:arrayID
                }, function(o){
                    $.get('members/read', {
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
        $.get('members/read', {
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
            $.get('members/read', {
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
            $.get('members/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
            
        }
        
    });
    
});


