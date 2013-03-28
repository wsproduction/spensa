<div id="box-content">
    <table id="list" title="<?php echo Web::getTitle(); ?>"link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_u="<?php echo $link_u; ?>"  link_d="<?php echo $link_d; ?>">
    </table>
    <div class="cl">&nbsp;</div>
</div>

<div id="box-form" style="display: none;">
    <?php
    Form::begin('frm_data');
    Form::create('hidden', 'id');
    Form::commit();
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
        
        var form_status = 'add';
        var data;
        var set_form = function(data) {
            $('#id').val(data['product_id']);
            $('#category').val(data['aggregation_category']);
            $('#type').html(data['option_product_type']).val(data['product_type']);
            $('#name').val(data['product_name']);
            $('#description').val(data['product_description']);
            $('#status').val(data['product_status']);
            $('#box-form').dialog('open');  
        };
        
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
                    width : 40,
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
                    width : 100,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Kategori',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Keterangan',
                    name : 'category_name',
                    width : 200,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Status',
                    name : 'language_entry',
                    width : 60,
                    sortable : true,
                    align : 'center'
                },  {
                    display : 'Tanggal Input',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Tanggal Update',
                    name : 'language_entry_update',
                    width : 80,
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
                        
                form_status = 'add';
                $('#frm_data .view_message').html('');
                $('#frm_data')[0].reset();
                $('#box-form').dialog('open');
                        
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
                        $('#list .trSelected td[abbr=product_id] div').each(function() {
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
                                alert('Proses hapus gagal.');
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
        
$('.edit').live('click', function(){
            
    form_status = 'edit';
    $('#frm_data .view_message').html('');
    $('#frm_data')[0].reset();
            
    $(this).loadingProgress('start');
            
    var url = $(this).attr('href');
    $.post(url, function(o){
        $(this).loadingProgress('stop');
                
        if (o[0]) {
            data = o[1];
            set_form(data);                
        } else {
            alert('Maaf, data tidak ditemukan.');
        }
    }, 'json');            
            
    return false;
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
    if (form_status == 'add') {
        $('#frm_data')[0].reset();
    } else {
        set_form(data   );
    }
    return false;
});
        
$('#box-form').dialog({
    title : 'Tambah Data Produk',
    closeOnEscape: false,
    autoOpen: false,
    height: 400,
    width: 500,
    modal: false,
    resizable: false,
    draggable: true,
    open : function() {
        if (form_status == 'add') {
            $('#category').removeAttr('disabled');
            $('#type').removeAttr('disabled');
            $('#box-form').dialog('option', 'title', 'Tambah Data Produk');
        } else {
            $('#category').attr('disabled','disabled');
            $('#type').attr('disabled','disabled');
            $('#box-form').dialog('option', 'title', 'Edit Data Produk');
        }
    }
});
        
$('#category').live('change', function() {
    var url = $(this).attr('link');
    var id = $(this).val();
    var target = $('#type');
    target.html('<option>Loading...</option>');
    $.post(url, { data : id }, function(o){
        target.html(o);
    }, 'json');
});
        
$('#frm_data').live('submit', function() {
    var parent = $(this);
    var url;
    var data = parent.serialize();
            
    url = $('#list').attr('link_c');
    if (form_status == 'edit') {
        url = $('#list').attr('link_u');                
    }
            
    $.post(url, data, function(o){
        $('.view_message', parent).html(o[1]);
    }, 'json');
    return false;
});
        
});
</script>