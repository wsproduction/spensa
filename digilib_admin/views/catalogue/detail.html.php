<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        
        <div style="border: 1px solid #ccc;margin-bottom: 5px;">
            <?php
            /*
              Form::create('button', 'btnPrintLabel');
              Form::value('Print Label');
              Form::style('action_print');
              Form::properties(array('link' => $link_print_label));
              Form::commit();
             * 
             */
            ?>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 150px;">
                        <div class="label-ina">ID Buku</div>
                        <div class="label-eng">Book ID</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php echo $data['book_id']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Judul Buku</div>
                        <div class="label-eng">Book Title</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php echo $data['book_title']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Judul Bahasa Lain</div>
                        <div class="label-eng">Foreign Title</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php echo $data['book_foreign_title']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Bahasa</div>
                        <div class="label-eng">Language</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Edisi / Centakan</div>
                        <div class="label-eng">Edition / Copies</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">ISBN</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Halaman Angka / Halaman Romawi</div>
                        <div class="label-eng">Page Number / Page Romance</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Bibliografi</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Ilustrasi / Index</div>
                        <div class="label-eng">Ilustration / Index</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Ukuran / Berat</div>
                        <div class="label-eng">Size / Weight</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label-ina">Ukuran / Berat</div>
                        <div class="label-eng">Size / Weight</div>
                    </td>
                    <td>:</td>
                    <td>
                        ??
                    </td>
                </tr>
            </table>
        </div>
        <table id="list-collection" link_r="<?php echo $link_r_collection; ?>"></table>
    </div>
</div>
</div>

<script>
    $(function(){
        $('#list-collection').flexigrid({
            url : $('#list-collection').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'Nomor Induk Buku', 
                    name : 'book_register_id', 
                    width : 170,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Kondisi Buku',
                    name : 'language_name',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Jumlah Pemipinjam',
                    name : 'language_name',
                    width : 150,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Terakhir Dipinjam',
                    name : 'language_name',
                    width : 200,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Opsi',
                    width : 150,
                    sortable : false,
                    align : 'center'
                }],
            buttons : [{
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        
                    }
                }, {
                    name : 'Delete',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#list-collection .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list-collection .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#list-collection').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        alert(leng + ' Item has deleted.');
                                        $('#list-collection').flexReload();
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
                        var leng = $('#list-collection .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list-collection .trSelected td[abbr=members_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#list-collection').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        alert(leng + ' Item has deleted.');
                                        $('#list-collection').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }, {
                    name : 'Print List Preview',
                    bclass : 'card',
                    onpress : function() {
                        window.location = $('#list-collection').attr('link_pl');
                    }
                }],searchitems : [ {
                    display : 'Nomor Induk',
                    name : 'book_register_id',
                    isdefault : true
                }],
            nowrap : false,
            sortname : "book_register_id",
            sortorder : "asc",
            usepager : true,
            title : 'Daftar Koleksi Buku',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height - 450
        });
    });
</script>
