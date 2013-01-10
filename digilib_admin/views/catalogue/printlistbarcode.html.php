<table id="printlist" title="<?php echo Web::getTitle(); ?>" link_r="<?php echo $link_r; ?>" link_p="<?php echo $link_p; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

<script>
    $(function(){
    
        $('#printlist').flexigrid({
            url : $('#printlist').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'book_temp_barcodeprint', 
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nomor Induk Buku',
                    name : 'members_name',
                    width : 180,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Keterangan Buku',
                    name : 'gender_title',
                    width : 300,
                    sortable : true,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Delete',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#printlist .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#printlist .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post('', {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        alert(leng + ' Item has deleted.');
                                        $('#printlist').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name : 'Delete All',
                    bclass : 'earse',
                    onpress : function() {
                        var conf = confirm('Are you delete all items?');
                        if (conf) {
                            $.post('', {
                                action : 'all'
                            }, function(o){
                                if (o) {
                                    alert('All Item has deleted.');
                                    $('#printlist').flexReload();
                                } else {
                                    alert('Process delete failed.');
                                }                            
                            }, 'json');
                        }
                    }
                }, {
                    separator : true
                }, {
                    name : 'Print Card',
                    bclass : 'print',
                    onpress : function() {
                        window.location = '';
                    }
                }],
            searchitems : [ {
                    display : 'ID',
                    name : 'members_id',
                    isdefault : true
                }, {
                    display : 'Nama Anggota',
                    name : 'members_name'            
                } ],
            nowrap : false,
            sortname : "book_temp_barcodeprint",
            sortorder : "asc",
            usepager : true,
            title : $('#printlist').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height - 350
        });
    });
</script>