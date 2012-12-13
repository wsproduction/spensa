$(function () {
    $('#list').flexigrid({
        url : $('#list').attr('link_r'),
        dataType : 'xml',
        colModel : [ {
            display : 'Kelas', 
            name : 'USERID', 
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Wali Kelas',
            name : 'ddc_classification_number',
            width : 300,
            sortable : true,
            align : 'left'
        }, {
            display : 'Tanggal Input',
            name : 'ddc_classification_number',
            width : 150,
            sortable : true,
            align : 'left'
        }, {
            display : 'Tanggal Edit',
            name : 'ddc_classification_number',
            width : 150,
            sortable : true,
            align : 'left'
        }, {
            display : 'Option',
            name : 'ddc_classification_number',
            width : 80,
            sortable : true,
            align : 'left'
        }],
        buttons : [ {
            name : 'Tambah',
            bclass : 'add',
            onpress : function() {
                window.location = $('#list').attr('link_r')
            }
        }, {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $('#list .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $('#list .trSelected td[abbr=ddc_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post($('#list').attr('link_r'), {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $('#list').flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }],
        nowrap : false,
        sortname : "ddc_id",
        sortorder : "asc",
        usepager : true,
        title : $('#list').attr('title'),
        useRp : false,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 350,
        onSubmit: function() {
            var dt = $('#fFilter').serializeArray();
            $('#list').flexOptions({
                params: dt
            });
            return true;
        }
    });
    
    /* SUBMIT ACTIONS */    
    $('#fAdd').live('submit',function(){
        frmID = $(this);
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        
        $.post(url, data, function(o){
            if (o[0]) {
                if (o[1]) {
                    $(frmID)[0].reset();
                }
                alert('Data berhasil disimpan');
            } else {
                alert('Data gagal disimpan');
            }
        }, 'json');
        
        return false;
    });
    
});