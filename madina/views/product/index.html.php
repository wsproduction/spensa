<div id="box-content">
    <table id="list" title="<?php echo Web::getTitle(); ?>" link_r="<?php echo $link_r; ?>" link_c="<?php echo $link_c; ?>" link_d="<?php echo $link_d; ?>">
    </table>
    <div class="cl">&nbsp;</div>
</div>

<div id="box-login" style="display: none;">
    <?php
    Form::begin('frm_data', 'product/create', 'post');
    ?>
    <div class="view_message"></div>
    <table style="margin: 5px 0 0 0;">
        <tr>
            <td style="width: 150px;">
                <div class="label-ina">Kategori</div>
                <div class="label-eng">Category</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'category');
                Form::option($option_category, ' ');
                Form::validation()->requaired('*');
                Form::properties(array('link' => $link_type, 'style' => 'min-width:100px;max-width:300px;'));
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Tipe</div>
                <div class="label-eng">Type</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'type');
                Form::validation()->requaired('*');
                Form::properties(array('style' => 'min-width:100px;max-width:300px;'));
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Nama Produk</div>
                <div class="label-eng">Product Name</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'name');
                Form::size(40);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td valign="top" style="padding-top: 10px;">
                <div class="label-ina">Keterangan</div>
                <div class="label-eng">Description</div>
            </td>
            <td valign="top" style="padding-top: 10px;">:</td>
            <td>
                <?php
                Form::create('textarea', 'description');
                Form::size(40, 4);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 150px;">
                <div class="label-ina">Status</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'status');
                Form::option(array(0 => 'Tidak Aktif', 1 => 'Aktif'));
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <button id="btn_save">Simpan</button>
                <button id="btn_reset">Reset</button>
            </td>
        </tr>
    </table>
    <?php
    Form::end();
    ?>
</div>

<script>
    $(function() {
        var y = screen.height * 0.70;
        $('#box-content').css('min-height',  y + "px");
        
        /* Index */
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'product_id', 
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Kode', 
                    name : 'product_code', 
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Produk',
                    name : 'product_name',
                    width : 200,
                    sortable : true,
                    align : 'left'
                },  {
                    display : 'Type',
                    name : 'category_name',
                    width : 120,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Kategori',
                    name : 'category_name',
                    width : 150,
                    sortable : true,
                    align : 'left',
                    hide : true
                },{
                    display : 'Tanggal Input',
                    name : 'language_entry',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Tanggal Update',
                    name : 'language_entry_update',
                    width : 100,
                    sortable : true,
                    align : 'center'
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
                        /* window.location = $('#list').attr('link_c');*/
                        $('#box-login').dialog('open');
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
                                $('#list .trSelected td[abbr=language_id] div').each(function() {
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
                } ],
            searchitems : [ {
                    display : 'ID',
                    name : 'product_id',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
                } ],
            nowrap : false,
            sortname : "product_id",
            sortorder : "asc",
            usepager : true,
            title : $('#list').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.55
        });
        
        /* Form Data */
        $('#btn_save').button({
            icons: {
                primary: "ui-icon-disk"
            }
        });
        
        $('#btn_reset').button({
            icons: {
                primary: "ui-icon-refresh"
            }
        }).live('click', function(){
            alert('heseweleh');
            return false;
        });
        
        $('#box-login').dialog({
            title : 'Tambah Data Produk',
            closeOnEscape: false,
            autoOpen: false,
            height: 400,
            width: 500,
            modal: false,
            resizable: false,
            draggable: true,
            open : function() {
                
            }
        });
        
        $('#category').live('change', function() {
            var url = $(this).attr('link');
            var id = $(this).val();
            var target = $('#type');
            $.post(url, { data : id }, function(o){
                $('#type').html(o);
            }, 'json');
        });
        
        $('#frm_data').live('submit', function() {
            var parent = $(this);
            var url = parent.attr('action');
            var data = parent.serialize();
            $.post(url, data, function(o){
                if (o[0]) {
                    window.location = o[1];
                } else {
                    $('.view_message', parent).html(o[1]);
                }
            }, 'json');
            return false;
        });
        
    });
</script>