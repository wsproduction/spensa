<div style="width: 900px;">
    
<table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" link_pl="<?php echo $link_pl; ?>" link_apl="<?php echo $link_apl; ?>" style="display: none;">
</table>
    
</div>

<script>
    $(function(){
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
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
                    name : 'gender_title',
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
                    name : 'isa_title',
                    width : 50,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Keterangan',
                    name : 'members_desc',
                    width : 60,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Peminjaman',
                    name : 'borrow_count',
                    width : 60,
                    sortable : true,
                    align : 'center',
                    hide : true
                },  {
                    display : 'Peminjaman Terakhir',
                    name : 'last_borrow',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Kunjungan',
                    width : 60,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Kunjungan Terakhir',
                    width : 100,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Status',
                    name : 'members_status',
                    width : 60,
                    sortable : true,
                    align : 'center',
                    hide : true
                },  {
                    display : 'Option',
                    width : 80,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        window.location = $('#list').attr('link_c');
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
                                $('#list .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                                
                                $(this).loadingProgress('start');
                                $.post($('#list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    $(this).loadingProgress('stop');
                                    if (o) {
                                        alert(leng + ' Item Telah Dihapus.');
                                        $('#list').flexReload();
                                    } else {
                                        alert('Process Hapus Gagal.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    separator : true
                }, {
                    name : 'Tambah Ke Daftar Print',
                    bclass : 'issue',
                    onpress : function() {
                        var leng = $('#list .trSelected').length;
                        var conf = confirm('Tambah Daftar Print ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                                
                                $(this).loadingProgress('start');
                                $.post($('#list').attr('link_apl'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    $(this).loadingProgress('stop');
                                    if (o) {
                                        alert(leng + ' Item Telah Disimpan.');
                                        /* $('#list').flexReload(); */
                                    } else {
                                        alert('Proses Tambah Gagal.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name : 'Lihat Daftar Print',
                    bclass : 'card',
                    onpress : function() {
                        window.location = $('#list').attr('link_pl');
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
            title : $('#list').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.60
        });
    });
</script>

