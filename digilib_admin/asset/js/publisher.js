/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){  
    
    var form_requaired_validation = function(id,status) {
        $(id).rules("add",{
            required : status
        });
    };
    
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
            name : 'publisher_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama Penerbit',
            name : 'publisher_name',
            width : 250,
            sortable : true,
            align : 'left'
        }, {
            display : 'Keterangan',
            name : 'publisher_description',
            width : 450,
            sortable : true,
            align : 'left',
            hide : true
        }, {
            display : 'Jumlah Kantor',
            name : 'publisher_address',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tanggal Input',
            name : 'publisher_address',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tanggal Update',
            name : 'publisher_address',
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
            name : 'Tambah',
            bclass : 'add',
            onpress : function() {
                window.location = link_c
            }
        }, {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId + ' .trSelected td[abbr=publisher_id] div').each(function() {
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
        searchitems : [{
            display : 'Nama Penerbit',
            name : 'publisher_name'            
        } ],
        nowrap : false,
        sortname : "publisher_id",
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
    
    var listId2 = '#list-office';
    var title2 = $(listId2).attr('title');
    var link_r2 = $(listId2).attr('link_r');
    var link_d2 = $(listId2).attr('link_d');
    
    var option2 = {
        url : link_r2,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'publisher_office_temp_id', 
            width : 50,
            sortable : true,
            align : 'center'
        }, {
            display : 'Keterangan Kantor',
            name : 'publisher_office_department_name',
            width : 90,
            sortable : true,
            align : 'left'
        }, {
            display : 'Alamat',
            name : 'publisher_office_temp_address',
            width : 400,
            sortable : true,
            align : 'left',
            hide : true
        } ],
        buttons : [ {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId2 + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId2 + ' .trSelected td[abbr=publisher_office_temp_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d2, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId2).flexReload();
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
        nowrap : false,
        sortname : "publisher_office_temp_id",
        sortorder : "asc",
        usepager : true,
        title : title2,
        useRp : false,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : 550,
        height : 340
    };
    
    $(listId2).flexigrid(option2);
    
    /* FILTER ADDRESS */
    $('#country').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $('#province').html('<option>Loading...</option>');
        $.get(url, {
            id:id
        }, function(o){
            $('#province').html(o);
        }, 'json');
    });
    $('#province').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $('#city').html('<option>Loading...</option>');
        $.get(url, {
            id:id
        }, function(o){
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
    
    /* BUTTON ACTION */
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    $('#btnAddOffice').live('click',function(){
        var url = $(this).attr('link');
        var data = $('#fAdd').serialize();
        
        form_requaired_validation('#country',true);
        form_requaired_validation('#city',true);
        form_requaired_validation('#province',true);
        
        if ($('#country').valid() && $('#city').valid() && $('#province').valid()) {
            $.post(url, data, function(o){
                if (o) {
                    $('#list-office').flexReload();
                } else {
                    alert('Process tambah failed.');
                }  
            }, 'json');
        }
        
    });
    
});


