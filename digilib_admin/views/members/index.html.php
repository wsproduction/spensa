<table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" link_pl="<?php echo $link_pl; ?>" link_apl="<?php echo $link_apl; ?>" style="display: none;">
</table>

<script>
    $(function(){
        var listId = '#list';
        var title = $(listId).attr('title');
        var link_r = $(listId).attr('link_r');
        var link_c = $(listId).attr('link_c');
        var link_d = $(listId).attr('link_d');
        var link_pl = $(listId).attr('link_pl');
        var link_apl = $(listId).attr('link_apl');
    
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
                    width : 150,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Jenis Kelamin',
                    name : 'members_name',
                    width : 65,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Alamat',
                    name : 'members_address',
                    width : 300,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Jabatan',
                    name : 'publisher_description',
                    width : 50,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Keterangan',
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
                },  {
                    display : 'Peminjaman Terakhir',
                    name : 'publisher_description',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Kunjungan',
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
                                        alert(leng + ' Item has deleted.');
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
                }, {
                    name : 'Add Print List',
                    bclass : 'issue',
                    onpress : function() {
                        var leng = $(listId + ' .trSelected').length;
                        var conf = confirm('Add Print List ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $(listId + ' .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post(link_apl, {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        alert(leng + ' Item has saved.');
                                        $(listId).flexReload();
                                    } else {
                                        alert('No Item Saved.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name : 'Print List Preview',
                    bclass : 'card',
                    onpress : function() {
                        window.location = link_pl
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
    });
</script>

