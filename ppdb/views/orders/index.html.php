<div id="box-content">
    <table id="list" title="<?php echo Web::getTitle(); ?>"link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_u="<?php echo $link_u; ?>"  link_d="<?php echo $link_d; ?>">
    </table>
    <div class="cl">&nbsp;</div>
</div>

<div id="box-cart">
    <div style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;">
        <table>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">ID Pesanan</div>
                </td>
                <td>:</td>
                <td id="tbl_order_id"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Nama Pemesan</div>
                </td>
                <td>:</td>
                <td id="tbl_members_name"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Alamat Pengiriman</div>
                </td>
                <td>:</td>
                <td id="tbl_shipping_address"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Biaya Pengiriman</div>
                </td>
                <td>:</td>
                <td id="tbl_shipping_cost"></td>
            </tr>
            <tr>
                <td>
                    <div class="label-ina">Total Tagihan</div>
                </td>
                <td>:</td>
                <td id="tbl_invoice"></td>
            </tr>
        </table>
    </div>

    <?php
    Form::begin('f_list_cart');
    Form::create('hidden', 'hide_order_id');
    Form::commit();
    Form::end();
    ?>

    <table id="list-cart" link_r="<?php echo $link_cart; ?>">
    </table>
    <div class="cl">&nbsp;</div>
</div>

<div id="box-form" style="display: none;">

    <div class="view_message"></div>

    <?php
    Form::begin('frm_members', 'orders/getdatamembers');
    ?>
    <div id="box-search-members" style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;">
        <table>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">ID Reseller</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('text', 'members_id');
                    Form::commit();
                    ?>
                    <button id="btn_search_members">Cari</button>
                </td>
            </tr>
        </table>
    </div>
    <?php
    Form::end();
    ?>

    <div id="box-info-members" style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #f9f9f9;display: none;">
        <table>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">ID Reseller</div>
                </td>
                <td>:</td>
                <td id="tbl_info_members_id"></td>
            </tr>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">Nama</div>
                </td>
                <td>:</td>
                <td id="tbl_info_members_name"></td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid #ccc; padding: 5px;margin: 5px 0 5px 0;background-color: #fff;">
        <table>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">Kode Produk</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('text', 'members_id');
                    Form::commit();
                    ?>
                    <button id="btn_search_product">Cari Produk</button>
                </td>
            </tr>
            <tr>
                <td style="width: 150px;">
                    <div class="label-ina">Jumlah</div>
                </td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('text', 'members_id');
                    Form::size(5);
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>

                    <button id="btn_save_cart">Tambah</button>
                </td>
            </tr>
        </table>
    </div>
    <table id="list-cart-temp" link_r="<?php echo $link_cart; ?>">
    </table>
</div>

<div id="box-filter-product">
    <?php
    Form::begin('frm_filter_product');
    Form::create('hidden', 'id');
    Form::commit();
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
                    Form::create('select', 'members_id');
                    Form::option(array('' => 'Kode Produk', '' => 'Nama Produk'));
                    Form::commit();
                    Form::create('text', 'members_id');
                    Form::commit();
                    ?>
                    <button class="btn_filter">Cari</button>
                </td>
            </tr>
        </table>
    </div>
    <table id="list-product-search" link_r="<?php echo $link_product_search; ?>">
    </table>
    <?php
    Form::end();
    ?>
</div>

<div id="box-filter-members">
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
    <table id="list-members-search" link_r="<?php echo $link_members_search; ?>">
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
        
        var set_text_detail = function(data) {
            
            var invoice = parseInt(data['shipping_cost']) + parseInt(data['invoice']);
            
            $('#hide_order_id').val(data['order_id']);
            $('#tbl_order_id').text(data['order_id']);
            $('#tbl_members_name').text(data['members_name']);
            $('#tbl_shipping_address').text(data['shipping_address']);
            $('#tbl_shipping_cost').text('Rp. ' + accounting.formatNumber(data['shipping_cost']));
            $('#tbl_invoice').text('Rp. ' + accounting.formatNumber(invoice));
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
        
        $('.cart').live('click', function() {
            
            $(this).loadingProgress('start');
            
            var url = $(this).attr('href');
            $.post(url, function(o){
                $(this).loadingProgress('stop');
                
                if (o[0]) {
                    data = o[1];
                    set_text_detail(data);
                    $('#box-cart').dialog('open');              
                } else {
                    alert('Maaf, data tidak ditemukan.');
                }
            }, 'json');  
            return false;
        });
        
        /* Form Members */
        $('#members_id').keypress(function(event){
 
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                $('#btn_search_members').button("disable");
                $('#frm_members').submit();	
                return false;
            }
 
        });
        
        $('#btn_search_members').button({
            icons: {
                primary: "ui-icon-search"
            },
            text: false
        }).live('click', function(){
            $('#box-filter-members').dialog('open');/*$('#btn_search_members').attr('disabled','disabled');*/
            return false;
        });
        
        $('#frm_members').live('submit', function() {
            var parent = $(this);
            var url;
            var data = parent.serialize();
            
            url = parent.attr('action');
            
            $.post(url, data, function(o){
                $('#btn_search_members').button("enable");
                if (o[0]) {
                    var val = o[1];
                    
                    $('#tbl_info_members_id').html(val['members_id'] + ' (<a href="#changeid" style="color:#0073ea;">Ganti</a>)');
                    $('#tbl_info_members_name').html(val['members_name']);
                    
                    $('#box-search-members').fadeOut('fast', function(){
                        $('#box-info-members').fadeIn('fast');
                    });
                } else {
                    alert('ID Reseller tidak ditemukan');
                    $('#members_id').focus().select();
                }
            }, 'json');
            return false;
        });
        
        $('a[href=#changeid]').live('click', function(){
            $('#frm_members')[0].reset();
            $('#box-info-members').fadeOut('fast', function(){
                $('#box-search-members').fadeIn('fast');
            });
            return false;
        });
                
        /* Form Data */
        $('#btn_save').button({
            icons: {
                primary: "ui-icon-disk"
            }
        });
        
        $('#btn_search_product').button({
            icons: {
                primary: "ui-icon-search"
            },
            text: false
        }).live('click',function(){
            $('#box-filter-product').dialog('open');
            return false;
        });
        
        $('.btn_filter').button({
            icons: {
                primary: "ui-icon-search"
            }
        });
        
        $('#btn_save_cart').button({
            icons: {
                primary: "ui-icon-cart"
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
            height: 650,
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
        
        $('#box-filter-product').dialog({
            title : 'Cari Produk',
            closeOnEscape: false,
            autoOpen: false,
            height: 350,
            width: 530,
            modal: false,
            resizable: false,
            draggable: true
        });
        
        $('#box-filter-members').dialog({
            title : 'Cari Reseller',
            closeOnEscape: false,
            autoOpen: false,
            height: 375,
            width: 530,
            modal: false,
            resizable: false,
            draggable: true
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
        
        $('#list-cart-temp').flexigrid({
            url : $('#list-cart').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'oder_id', 
                    width : 75,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Produk',
                    name : 'product_name',
                    width : 200,
                    sortable : true,
                    align : 'left'
                },  {
                    display : 'Harga',
                    name : 'category_name',
                    width : 70,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Diskon',
                    name : 'category_name',
                    width : 35,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Jumlah',
                    name : 'category_name',
                    width : 40,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Total',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }],
            buttons : [ {
                    name : 'Cetak Faktur',
                    bclass : 'print',
                    onpress : function() {
                        
                    }
                }, {
                    name : 'Cetak Label Pengiriman',
                    bclass : 'print',
                    onpress : function() {
                        
                    }
                } ],
            searchitems : [ {
                    display : 'ID',
                    name : 'oder_id',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
                } ],
            nowrap : false,
            sortname : "oder_id",
            sortorder : "asc",
            usepager : true,
            title : 'Daftar Barang',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : 240,
            onSubmit: function() {
                var dt = $('#f_list_cart').serializeArray();
                $('#list-cart').flexOptions({
                    params: dt
                });
                return true;
            }
        });
        
        $('#list-product-search').flexigrid({
            url : $('#list-product-search').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'oder_id', 
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
                    display : 'Harga',
                    name : 'category_name',
                    width : 70,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Diskon',
                    name : 'category_name',
                    width : 35,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Pilihan',
                    name : 'category_name',
                    width : 50,
                    sortable : true,
                    align : 'center',
                    hide : true
                }],
            nowrap : false,
            sortname : "oder_id",
            sortorder : "asc",
            usepager : true,
            title : 'Daftar Barang',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : 145,
            onSubmit: function() {
                var dt = $('#f_list_cart').serializeArray();
                $('#list-cart').flexOptions({
                    params: dt
                });
                return true;
            }
        });
        
        $('#list-members-search').flexigrid({
            url : $('#list-members-search').attr('link_r'),
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
                }],
            buttons : [{
                    name : 'Pilih',
                    bclass : 'tick',
                    onpress : function() {
                        var leng = $('#list-members-search .trSelected').length;
                        if (leng > 0) {
                            var tempId;
                            $('#list-members-search .trSelected td[abbr=members_id] div').each(function() {
                                tempId = parseInt($(this).text());
                            });
                            $('#members_id').val(tempId).focus();
                            $('#box-filter-members').dialog('close');
                            $('#btn_search_members').button("disable");
                            $('#frm_members').submit();
                        } else {
                            alert('Belum ada reseller yang dipilih.');
                        }
                    }
                } ],
            nowrap : false,
            sortname : "members_id",
            sortorder : "asc",
            usepager : true,
            title : 'Daftar Reseller',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : 140,
            singleSelect:true,
            onSubmit: function() {
                var dt = $('#frm_filter_members').serializeArray();
                $('#list-members-search').flexOptions({
                    params: dt
                });
                return true;
            }
        });
        
        $('#frm_filter_members').live('submit', function(){
            $('#list-members-search').flexOptions({
                newp: 1
            }).flexReload();
            return false;
        });
        
        /* Cart */
        $('#box-cart').dialog({
            title : 'Keranjang Pesanan',
            closeOnEscape: false,
            autoOpen: false,
            height: 600,
            width: 620,
            modal: false,
            resizable: false,
            draggable: true,
            open : function() {
                $('#list-cart').flexOptions({
                    newp: 1
                }).flexReload();
            }
        });
        
        $('#list-cart').flexigrid({
            url : $('#list-cart').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'oder_id', 
                    width : 75,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama Produk',
                    name : 'product_name',
                    width : 200,
                    sortable : true,
                    align : 'left'
                },  {
                    display : 'Harga',
                    name : 'category_name',
                    width : 70,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Diskon',
                    name : 'category_name',
                    width : 35,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Jumlah',
                    name : 'category_name',
                    width : 40,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Total',
                    name : 'category_name',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }],
            buttons : [ {
                    name : 'Cetak Faktur',
                    bclass : 'print',
                    onpress : function() {
                        
                    }
                }, {
                    name : 'Cetak Label Pengiriman',
                    bclass : 'print',
                    onpress : function() {
                        
                    }
                } ],
            searchitems : [ {
                    display : 'ID',
                    name : 'oder_id',
                    isdefault : true
                }, {
                    display : 'Nama Produk',
                    name : 'product_name'            
                } ],
            nowrap : false,
            sortname : "oder_id",
            sortorder : "asc",
            usepager : true,
            title : 'Daftar Barang',
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : 260,
            onSubmit: function() {
                var dt = $('#f_list_cart').serializeArray();
                $('#list-cart').flexOptions({
                    params: dt
                });
                return true;
            }
        });
        
    });
</script>