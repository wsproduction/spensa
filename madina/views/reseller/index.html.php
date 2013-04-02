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
                <div class="label-ina">Nama Lengkap</div>
                <div class="label-eng">Full Name</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'fullname');
                Form::size(50);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Nama Panggilan</div>
                <div class="label-eng">Nickname</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'nickname');
                Form::size(40);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Jenis Kelamin</div>
                <div class="label-eng">Gender</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'gender');
                Form::option(array(0 => 'Perempuan', 1 => 'Laki-Laki'));
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
                Form::validation()->requaired('*');
                Form::size(40, 4);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Tempat, Tanggal Lahir</div>
                <div class="label-eng">Place, Birth of date</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'birthplace');
                Form::size(20);
                Form::validation()->requaired('*');
                Form::commit();
                echo ', ';
                Form::create('select', 'day');
                Form::option($option_date);
                Form::validation()->requaired('*');
                Form::commit();
                Form::create('select', 'month');
                Form::option($option_moth);
                Form::validation()->requaired('*');
                Form::commit();
                Form::create('text', 'year');
                Form::size(5);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Pendidikan</div>
                <div class="label-eng">Education</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'education');
                Form::size(40);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Pekerjaan</div>
                <div class="label-eng">Jobs</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'jobs');
                Form::size(40);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">No. Telpon</div>
                <div class="label-eng">Phone Number</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'phone');
                Form::size(20);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Email</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'email');
                Form::size(40);
                Form::validation()->email();
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Facebook</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'facebook');
                Form::size(30);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Twitter</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'twitter');
                Form::size(30);
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
            
            var birthdate = data['members_birthdate'];
            var pasingdate = birthdate.split('-');
            
            $('#id').val(data['members_id']);
            $('#fullname').val(data['members_name']);
            $('#nickname').val(data['members_nickname']);
            $('#gender').val(data['members_gender']);
            $('#address').val(data['members_address']);
            $('#birthplace').val(data['members_birthplace']);
            $('#day').val(pasingdate[2]);
            $('#month').val(pasingdate[1]);
            $('#year').val(pasingdate[0]);
            $('#education').val(data['members_last_education']);
            $('#jobs').val(data['members_jobs']);
            $('#phone').val(data['members_phone_number']);
            $('#email').val(data['members_email']);
            $('#facebook').val(data['members_facebook']);
            $('#twitter').val(data['members_twitter']);
            $('#status').val(data['members_status']);
        };
        
        /* Index */
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
                    name : 'product_name',
                    width : 120,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Nama Panggilan',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Jenis Kelamin',
                    name : 'category_name',
                    width : 70,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Alamat',
                    name : 'category_name',
                    width : 180,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Tempat Tanggal Lahir',
                    name : 'language_entry',
                    width : 110,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Pendidikan',
                    name : 'language_entry',
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Pekerjaan',
                    name : 'language_entry',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Telepon',
                    name : 'language_entry',
                    width : 80,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Email',
                    name : 'language_entry',
                    width : 150,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Social Network',
                    name : 'language_entry',
                    width : 150,
                    sortable : true,
                    align : 'left'
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
                                $('#list .trSelected td[abbr=members_id] div').each(function() {
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
                    name : 'members_id',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
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
            height: 640,
            width: 600,
            modal: false,
            resizable: false,
            draggable: true,
            open : function() {
                if (form_status == 'add') {
                    $('#category').removeAttr('disabled');
                    $('#type').removeAttr('disabled');
                    $('#box-form').dialog('option', 'title', 'Tambah Data Reseller');
                } else {
                    $('#category').attr('disabled','disabled');
                    $('#type').attr('disabled','disabled');
                    $('#box-form').dialog('option', 'title', 'Edit Data Reseller');
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