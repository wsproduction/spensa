<table id="borrow-list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

<script>
    $(function(){    
        $('#borrow-list').flexigrid({
            url : $('#borrow-list').attr('link_r'),
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
                    name : 'members_name',
                    width : 180,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Jenis Peminjaman',
                    name : 'borrowed_type_title',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Waktu Peminjaman',
                    name : 'borrowed_history_star',
                    width : 150,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Option',
                    width : 80,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Tambah Peminjaman ',
                    bclass : 'add',
                    onpress : function() {
                        window.location = $('#borrow-list').attr('link_c');
                    }
                }, {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#borrow-list .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#borrow-list .trSelected td[abbr=language_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#borrow-list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        $('#borrow-list').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    separator : true
                }, {
                    name : 'Laporan Peminjaman',
                    bclass : 'report',
                    onpress : function() {
                        window.location = $('#borrow-list').attr('link_c');
                    }
                }],
            searchitems : [ {
                    display : 'Nomor Induk Buku',
                    name : 'borrowed_history_book',
                    isdefault : true
                }, {
                    display : 'Judul Buku',
                    name : 'book_title'            
                } ],
            nowrap : false,
            sortname : "borrowed_history_id",
            sortorder : "asc",
            usepager : true,
            title : $('#borrow-list').attr('title'),
            useRp : true,
            rp : 20,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.60
        });
    });
</script>

