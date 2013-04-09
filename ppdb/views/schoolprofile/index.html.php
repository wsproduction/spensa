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
            <td>
                <div class="label-ina">NSS</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'nss');
                Form::size(15);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Nama Sekolah</div>
                <div class="label-eng">School Name</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'school_name');
                Form::size(40);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td valign="top" style="padding-top: 10px;">
                <div class="label-ina">Alamat</div>
                <div class="label-eng">Address</div>
            </td>
            <td valign="top" style="padding-top: 10px;">:</td>
            <td>
                <?php
                Form::create('textarea', 'address');
                Form::size(40, 2);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">RT / RW</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'rt');
                Form::size(2);
                Form::commit();
                echo ' / ';
                Form::create('text', 'rw');
                Form::size(2);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Kelurahan</div>
                <div class="label-eng">Village</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'village');
                Form::size(30);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Kecamatan</div>
                <div class="label-eng">Sub-distric</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'sub_distric');
                Form::size(30);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Kabupaten</div>
                <div class="label-eng">Distric</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'distric');
                Form::size(30);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Prpovinsi</div>
                <div class="label-eng">Province</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'province');
                Form::size(30);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Kode Pos</div>
                <div class="label-eng">Zip Code</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'zip_code');
                Form::size(5);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Telepon</div>
                <div class="label-eng">Telephone</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'phone');
                Form::size(15);
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
            $('#id').val(data['school_id']);
            $('#nss').val(data['school_nss']);
            $('#school_name').val(data['school_name']);
            $('#address').val(data['school_address']);
            $('#rt').val(data['school_rt']); 
            $('#rw').val(data['school_rw']); 
            $('#village').val(data['school_village']); 
            $('#sub_distric').val(data['school_subdistric']); 
            $('#distric').val(data['school_distric']); 
            $('#province').val(data['school_province']); 
            $('#zip_code').val(data['school_zipcode']); 
        };
        
        /* Index */
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'school_id', 
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'NSS', 
                    name : 'school_npsn', 
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Sekolah', 
                    name : 'product_code', 
                    width : 120,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Alamat', 
                    name : 'product_code', 
                    width : 150,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'RT',
                    name : 'language_entry',
                    width : 15,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'RW',
                    name : 'language_entry',
                    width : 15,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Kelurahan',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Kecamatan',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Kabupaten',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Kode POS',
                    name : 'language_entry',
                    width : 50,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Telephon',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
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
                    width : 50,
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
                                $('#list .trSelected td[abbr=school_id] div').each(function() {
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
                    name : 'school_npsn',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
                } ],
            nowrap : false,
            sortname : "school_id",
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
                    $('#box-form').dialog('open');                 
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
            title : '',
            closeOnEscape: false,
            autoOpen: false,
            height: 550,
            width: 500,
            modal: false,
            resizable: false,
            draggable: true,
            open : function() {
                if (form_status == 'add') {
                    $('#category').removeAttr('disabled');
                    $('#type').removeAttr('disabled');
                    $('#box-form').dialog('option', 'title', 'Tambah Data Profile Sekolah');
                } else {
                    $('#category').attr('disabled','disabled');
                    $('#type').attr('disabled','disabled');
                    $('#box-form').dialog('option', 'title', 'Edit Data Profile Sekolah');
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