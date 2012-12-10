/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    
    $('#sdate').datepicker({
        changeMonth: true,
        changeYear: true
    });
    
    $('#fdate').datepicker({
        changeMonth: true,
        changeYear: true
    });
    
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
            name : 'USERID', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'NIP',
            name : 'ddc_classification_number',
            width : 110,
            sortable : true,
            align : 'center'
        }, {
            display : 'NUPTK',
            name : 'ddc_classification_number',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama',
            name : 'ddc_title',
            width : 250,
            sortable : true,
            align : 'left'
        }, {
            display : 'Jenis Kelamin',
            name : 'ddc_title',
            width : 80,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tanggal',
            name : 'ddc_classification_number',
            width : 80,
            sortable : true,
            align : 'center'
        }, {
            display : 'Jam Datang',
            name : 'ddc_level',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Jam Pulang',
            name : 'option',
            width : 80,
            align : 'center'
        }, {
            display : 'Keterangan',
            name : 'option',
            width : 80,
            align : 'center'
        }, {
            display : 'Option',
            name : 'ddc_classification_number',
            width : 80,
            sortable : true,
            align : 'left'
        }],
        buttons : [ {
            name : 'Lupa Check In / Out',
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
        nowrap : false,
        sortname : "ddc_id",
        sortorder : "asc",
        usepager : true,
        title : title,
        useRp : false,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 350,
        onSubmit: function() {
            var dt = $('#fFilter').serializeArray();
            $(listId).flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $('#fFilter').live('submit',function(){
        $(listId).flexOptions({
            newp: 999
        }).flexReload();
        return false;
    });
    
    $(listId).flexigrid(option);   
    
    
    $('#fTReport').live('submit');
        
    /* BUTTON ACTION */
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    
});


