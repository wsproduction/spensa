<table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

<script>
    $(function(){    
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
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
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        window.location = $('#list').attr('link_c')
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
                                
                                $(this).loadingProgress('start');                        
                                $.post($('#list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    $(this).loadingProgress('stop');
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
            title : $('#list').attr('title'),
            useRp : true,
            rp : 20,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.60
        });
    });
</script>
