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
        <div id="detailTab">
            <ul>
                <li><?php URL::link('#fragment-1', 'Detail Buku'); ?></li>
                <li><?php URL::link('#fragment-2', 'Katalog'); ?></li>
                <li><?php URL::link('#fragment-3', 'Koleksi Buku'); ?></li>
            </ul>
            <div id="fragment-1">
                <?php
                Form::create('button', 'btnPrintLabel');
                Form::value('Print Label');
                Form::style('action_print');
                Form::properties(array('link' => $link_print_label));
                Form::commit();
                ?>
                <br><br>
                Underconstruction!!!
            </div>
            <div id="fragment-2">
                Underconstruction!!!
            </div>
            <div id="fragment-3">
                <table id="list-collection" link_r="<?php echo $link_r_collection; ?>"></table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#detailTab').tabs();
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
                    display : 'Total Dipinjam',
                    name : 'language_name',
                    width : 200,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Terakhir Pinjam',
                    name : 'language_name',
                    width : 200,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Opsi',
                    name : 'language_name',
                    width : 200,
                    sortable : true,
                    align : 'left'
                }],
            buttons : [{
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        
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
