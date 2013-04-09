<div id="box-content">
    <table id="list" title="<?php echo Web::getTitle(); ?>"link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_u="<?php echo $link_u; ?>"  link_d="<?php echo $link_d; ?>">
    </table>
    <div class="cl">&nbsp;</div>
</div>

<div id="box-form" style="display: none;">
    <div class="view_message"></div>
    <?php
    Form::begin('frm_data');
    Form::create('hidden', 'id');
    Form::commit();
    ?>
    <div class="view_message"></div>
    <table style="margin: 5px 0 0 0;">
        <tr>
            <td style="width: 150px;">
                <div class="label-ina">Asal Sekolah</div>
                <div class="label-eng">Originally School</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'originally_school');
                Form::size(15);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
                <button id="btn_search_school">Cari</button>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Nama Pelamar</div>
                <div class="label-eng">Applicant Name</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'applicant_name');
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
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Golongan Darah</div>
                <div class="label-eng">Blood Group</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'gender');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Agama</div>
                <div class="label-eng">Religion</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'religion');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
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
            <td>
                <div class="label-ina">Tinggi Badan</div>
                <div class="label-eng">Height</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'height');
                Form::size(30);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Berat Badan</div>
                <div class="label-eng">Weight</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'weight');
                Form::size(5);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Penyakit yang pernah diderita</div>
                <div class="label-eng">Had suffered</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'suffered');
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

<div id="box-filter">
    <?php
    Form::begin('frm_filter_members');
    ?>
    <div style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;">
        <table>
            <tr>
                <td style="width: 80px;">
                    <div class="label-ina">Kata Kunci</div>
                    <div class="label-eng">Keyword</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('select', 'keyword_category');
                    Form::option(array('members_name' => 'Nama Reseller'));
                    Form::commit();
                    Form::create('text', 'keyword_text');
                    Form::commit();
                    ?>
                    <button class="btn_filter">Cari</button>
                </td>
            </tr>
        </table>
    </div>
    <table id="list-school" link_r="<?php echo $link_members_search; ?>">
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
        };
        
        /* Index */
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'order_id', 
                    width : 60,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Pemesan',
                    name : 'product_name',
                    width : 120,
                    sortable : true,
                    align : 'left'
                },{
                    display : 'Status Pembayaran',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Tipe Pembayaran',
                    name : 'category_name',
                    width : 85,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Info Pembayaran',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Alamat Pengiriman',
                    name : 'category_name',
                    width : 200,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Status Pengiriman',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Tanggal Kirim',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Jasa Pengiriman',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'Biaya Pengiriman',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Total Tagihan',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Status Pesanan',
                    name : 'category_name',
                    width : 80,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Catatan',
                    name : 'category_name',
                    width : 200,
                    sortable : true,
                    align : 'left',
                    hide : true
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
                    width : 130,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        /*
                        form_status = 'add';
                        $('#frm_data .view_message').html('');
                        $('#frm_data')[0].reset();
                         */
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
                                $('#list .trSelected td[abbr=oder_id] div').each(function() {
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
                    name : 'order_id',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
                } ],
            nowrap : false,
            sortname : "order_id",
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
        
        $('#box-form').dialog({
            title : '',
            closeOnEscape: false,
            autoOpen: false,
            height: 500,
            width: 620,
            modal: false,
            resizable: false,
            draggable: true,
            open : function() {
                if (form_status == 'add') {
                    $('#box-form').dialog('option', 'title', 'Tambah Data Pesanan');
                } else {
                    $('#box-form').dialog('option', 'title', 'Edit Data Pesanan');
                }
            }
        });        
        
        $('#box-filter').dialog({
            title : 'Filter Sekolah Asal',
            closeOnEscape: false,
            autoOpen: false,
            height: 400,
            width: 550,
            modal: false,
            resizable: false,
            draggable: true
        });  
        
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
        
        $('#btn_search_school').button({
            icons: {
                primary: "ui-icon-search"
            },
            text: false
        }).live('click', function(){
            $('#box-filter').dialog('open');/*$('#btn_search_members').attr('disabled','disabled');*/
            return false;
        });
        
        
        $('.btn_filter').button({
            icons: {
                primary: "ui-icon-search"
            }
        });
    });
</script>