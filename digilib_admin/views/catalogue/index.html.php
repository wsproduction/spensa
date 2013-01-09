<table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

<script>
    $(function(){
        /* FLEXYGRID INDEX*/
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
                    name : 'book_id', 
                    width : 70,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Call Number',
                    name : 'classification_number',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Keterangan Buku',
                    name : 'book_title',
                    width : 450,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Asal',
                    name : 'resource_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Sumber',
                    name : 'fund_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Eksemplar',
                    name : 'book_quantity',
                    width : 60,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Stok',
                    name : 'length_borrowed',
                    width : 50,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Tanggal Input',
                    name : 'book_entry_date',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Tanggal Update',
                    name : 'book_entry_date',
                    width : 80,
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
                                $(listId + ' .trSelected td[abbr=book_id] div').each(function() {
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
                    name : 'book_id',
                    isdefault : true
                }, {
                    display : 'Judul Buku',
                    name : 'book_title'
                }, {
                    display : 'Pengarang',
                    name : 'ddc_title'
                }, {
                    display : 'Penerbit',
                    name : 'ddc_title'
                }, {
                    display : 'Asal',
                    name : 'ddc_title'
                }, {
                    display : 'Sumber',
                    name : 'ddc_level'
                } ],
            nowrap : false,
            sortname : "book_id",
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
    });
</script>

