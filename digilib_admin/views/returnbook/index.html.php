<table id="return-list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

<script>
    $(function(){
        $('#return-list').flexigrid({
            url : $('#return-list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'borrowed_history_id', 
                    width : 40,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nomor Induk Buku',
                    name : 'borrowed_history_book',
                    width : 85,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Keterangan Buku',
                    name : 'book_title',
                    width : 350,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Nama Peminjam',
                    name : 'language_status',
                    width : 180,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Jenis Peminjaman',
                    name : 'language_status',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Waktu Peminjaman',
                    name : 'language_status',
                    width : 150,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Denda',
                    name : 'language_status',
                    width : 150,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Option',
                    name : 'option',
                    width : 80,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Tambah Pengembalian ',
                    bclass : 'add',
                    onpress : function() {
                        window.location = $('#return-list').attr('link_c');
                    }
                }, {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#return-list .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#return-list .trSelected td[abbr=language_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#return-list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        $('#return-list').flexReload();
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
                    name : 'borrowed_history_id',
                    isdefault : true
                }, {
                    display : 'Nama Bahasa',
                    name : 'language_name'            
                } ],
            nowrap : false,
            sortname : "borrowed_history_id",
            sortorder : "asc",
            usepager : true,
            title : $('#return-list').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height - 350
        });
    });
</script>

