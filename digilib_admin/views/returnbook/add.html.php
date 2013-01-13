
<div style="margin-bottom: 10px;">
    <fieldset>
        <legend>Data Anggota</legend>
        <div class="borrowed-info">
            <div class="float-left">
                <?php Form::begin('fSearchInfoMember', 'returnbook/readmemberinfo', 'post'); ?>
                <table>
                    <tr>
                        <td width="150">
                            <div class="label-ina">Identitas Anggota</div>
                            <div class="label-eng">Member ID</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'memberid');
                            Form::size(30);
                            Form::validation()->requaired();
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <?php
                            Form::create('button', 'bSubmit');
                            Form::value('Cari');
                            Form::style('action_search');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php Form::end(); ?>
            </div>
            <div class="float-right">
                <div class="members-info"></div>
                <div class="cl"></div>
            </div>
            <div class="cl"></div>
        </div>
    </fieldset>
</div>

<table id="return-history-list" title="Riwayat Peminjaman" link_r="<?php echo $link_rbh; ?>" link_d="<?php echo $link_dbh; ?>" style="display: none;">
</table>

<div id="borrowed-cart">
    <div id="view-cart">
        <fieldset>
            <legend>Data Buku</legend>
            <?php
            Form::begin('fSearchBookInfo', 'returnbook/readbookinfo', 'post');

            Form::create('hidden', 'borrowedtype');
            Form::value(0);
            Form::commit();
            Form::create('hidden', 'memberidtemp');
            Form::value(0);
            Form::commit();
            ?>
            <table>
                <tr>
                    <td width="150">
                        <div class="label-ina">Nomor Indux Buku</div>
                        <div class="label-eng">Book Register</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'bookregister');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <?php
                        Form::create('submit', 'bSubmit');
                        Form::value('Tambah');
                        Form::style('action_add');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
            <?php Form::end(); ?>
        </fieldset>

        <div class="view-cart-list">
            <table id="return-cart-temporer-list" title="" link_r="<?php echo $link_rct; ?>" link_d="<?php echo $link_dct; ?>" style="display: none;">
            </table>
        </div>
        <div align="right">
            <?php
            Form::create('button', 'bSimpanCart');
            Form::value('Simpan');
            Form::style('action_save');
            Form::properties(array('link' => $link_checkout, 'link_invoice' => $link_invoice));
            Form::commit();
            Form::create('button', 'bCancelCart');
            Form::value('Batal');
            Form::style('action_cancel');
            Form::commit();
            ?>
        </div>
    </div>
    <div id="view-invoice">
        <iframe frameborder="0"></iframe>
    </div>
</div>

<script>
    $(function(){
        var memberStatus = false;
        var getInfoMembers = function() {
            frmID = $('#fSearchInfoMember');
            var url =  $(frmID).attr('action');
            var data =  $(frmID).serialize();
        
            $('#memberid').focus().select();
            
            $(this).loadingProgress('start');
            
            $.post(url, data, function(o){
                $(this).loadingProgress('stop');
                var view;
                if (o[0]) {
                    var profile = o[1];
                    view  = '<div class="float-right">' + profile['photo'] + '</div>';
                    view += '<div class="float-right members-profile">';
                    view += '   <div><b>' + profile['name'] + '</b></div>';
                    view += '   <div>' + profile['birthinfo'] + '</div>';
                    view += '   <div>' + profile['gender'] + '</div>';
                    view += '   <div>' + profile['isa'] + '</div>';
                    view += '   <div>' + profile['address'] + '</div>';
                    view += '</div>';
                    $('#memberidtemp').val(profile['memberid']);
                    memberStatus = true;
                } else {
                    view = '<div class="float-right members-profile-not-found">Identias anggota tidak ditemukan.</div>';
                    memberStatus = false;
                }
            
                $('.members-info').html(view).fadeIn('slow');
            
                $('#return-history-list').flexOptions({
                    newp: 1
                }).flexReload();
            }, 'json');
        };
        
        /* BEGIN : Borrowed History List */
        $('#return-history-list').flexigrid({
            url : $('#return-history-list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'borrowed_history_id', 
                    width : 40,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nomor Induk Buku',
                    name : 'borrowed_history_book',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Keterangan Buku',
                    name : 'book_title',
                    width : 400,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Jenis Peminjaman',
                    name : 'language_status',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Waktu Peminjaman',
                    name : 'borrowed_history_star',
                    width : 150,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Status',
                    name : 'language_entry',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Tanggal Pengembalian',
                    name : 'language_entry_update',
                    width : 150,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Option',
                    name : 'option',
                    width : 80,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Pengembalian Temporer',
                    bclass : 'add',
                    onpress : function() {
                        if (memberStatus) {
                            $('#view-cart').css('display','block');
                            $('#view-invoice').css('display','none');
                            $("#borrowed-cart").dialog('option', 'title', 'Keranjang Pengambalian Temporer');
                            $("#borrowed-cart").dialog( "open" );
                            $('#borrowedtype').val(1);
                            $('#bookregister').val('');
                            $('#return-cart-temporer-list').flexReload();
                            $('#bookregister').focus();
                        }
                    }
                }, {
                    name : 'Pengembalian Individu',
                    bclass : 'add',
                    onpress : function() {
                        if (memberStatus) {
                            $('#view-cart').css('display','block');
                            $('#view-invoice').css('display','none');
                            $("#borrowed-cart").dialog('option', 'title', 'Keranjang Pengambalian Individu');
                            $("#borrowed-cart").dialog( "open" );
                            $('#borrowedtype').val(2);
                            $('#bookregister').val('');
                            $('#return-cart-temporer-list').flexReload();
                            $('#bookregister').focus();
                        }
                    }
                }, {
                    name : 'Pengembalian Klasikal',
                    bclass : 'add',
                    onpress : function() {
                        if (memberStatus) {
                            $('#view-cart').css('display','block');
                            $('#view-invoice').css('display','none');
                            $("#borrowed-cart").dialog('option', 'title', 'Keranjang Pengambalian Klasikal');
                            $("#borrowed-cart").dialog( "open" );
                            $('#borrowedtype').val(3);
                            $('#bookregister').val('');
                            $('#return-cart-temporer-list').flexReload();
                            $('#bookregister').focus();
                        }
                    }
                }, {
                    separator : true
                }, {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#return-history-list .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#return-history-list .trSelected td[abbr=borrowed_history_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#return-history-list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        $('#return-history-list').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                } ],
            searchitems : [ {
                    display : 'No Induk Buku',
                    name : 'borrowed_history_book',
                    isdefault : true
                }, {
                    display : 'Judul Buku',
                    name : 'book_title'            
                } ],
            nowrap : false,
            sortname : "borrowed_history_id",
            sortorder : "desc",
            usepager : true,
            title : $('#return-history-list').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height - 550,
            onSubmit: function() {
                var dt = $('#fSearchInfoMember').serializeArray();
                $('#return-history-list').flexOptions({
                    params: dt
                });
                return true;
            }
        });
      
        $('#memberid').focus().live('click',function(){
            $(this).select();
        });
    
        $('#fSearchInfoMember').live('submit',function(){
            return false;
        });
    
        $('#memberid').live('change',function(){       
            getInfoMembers();
        });
        /* END : Borrowed History List */
    
        /* BEGIN : Borrowed Cart Temporer List */    
        $('#return-cart-temporer-list').flexigrid({
            url : $('#return-cart-temporer-list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID',
                    name : 'borrowed_temp_id',
                    width : 32,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Nomor Induk Buku',
                    name : 'borrowed_temp_book',
                    width : 85,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Keterangan Buku',
                    name : 'book_title',
                    width : 250,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Waktu Peminjaman',
                    name : 'borrowed_temp_book',
                    width : 150,
                    sortable : false,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Denda',
                    name : 'borrowed_temp_book',
                    width : 80,
                    sortable : false,
                    align : 'center',
                    hide : true
                }],
            buttons : [ {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#return-cart-temporer-list .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#return-cart-temporer-list .trSelected td[abbr=borrowed_temp_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#return-cart-temporer-list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        $('#return-cart-temporer-list').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                } ],
            searchitems : [ {
                    display : 'No Indux Buku',
                    name : 'borrowed_temp_book',
                    isdefault : true
                }, {
                    display : 'Nama Bahasa',
                    name : 'book_title'            
                } ],
            nowrap : false,
            sortname : "borrowed_return_temp_id",
            sortorder : "asc",
            usepager : true,
            title : $('#return-cart-temporer-list').attr('title'),
            useRp : true,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height - 550,
            onSubmit: function() {
                var dt = $('#fSearchBookInfo').serializeArray();
                $('#return-cart-temporer-list').flexOptions({
                    params: dt
                });
                return true;
            }
        });
    
        $('#fSearchBookInfo').live('submit',function(){
                
            frmID = $(this);
            var url =  $(frmID).attr('action');
            var data =  $(frmID).serialize();
        
            $.post(url, data, function(o){
                if (o) {  
                    $('#return-cart-temporer-list').flexOptions({
                        newp: 1
                    }).flexReload();
                } else {
                    alert('Informasi buku tidak ditemukan');
                }
                $('#bookregister').focus().select();
            }, 'json');
            return false;
        });
    
        $('#bookregister').live('click',function(){
            $(this).focus().select();
        });
    
        /* END : Borrowed Cart Temporer List */
    
        $('#borrowed-cart').dialog({
            closeOnEscape: false,
            autoOpen: false,
            height: screen.height - 200,
            width: 700,
            modal: true,
            resizable: false,
            draggable: false,
            open : function() {
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            }
        });
    
        $('#bSimpanCart').live('click',function(){
            var conf =  confirm('Anda yakin akan menyimpan?');
            if (conf) {
                var url =  $(this).attr('link');
                var invoice =  $(this).attr('link_invoice');
                var memberidtemp =  $('#memberidtemp').val();
        
                $.post(url, {
                    memberid : memberidtemp
                }, function(o){
                    if (o) {  
                        $('#view-cart').slideUp('slow',function(){
                            $('#view-invoice').slideDown('slow');
                        });
                        $('#borrowed-cart #view-invoice iframe').attr('src', invoice + '/' + memberidtemp);
                        $('#borrowed-cart').parent().children().children('.ui-dialog-titlebar-close').show();
                    } else {
                        alert('Data Peminjaman Gagal disimpan.');
                    }
                }, 'json');
            }
        });
    
        $('#bCancelCart').live('click',function(){
            $('#borrowed-cart').dialog('close');
        });
    
        $('#borrowed-cart #view-invoice iframe').height(screen.height - 260);
    
    
    });
</script>