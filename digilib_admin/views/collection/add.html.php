<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="btn-group">
                <a href="#" class="dropdown">Aksi</a>
                <ul>
                    <li><a href="<?php echo $link_back; ?>">Kembali</a></li>
                </ul>
            </div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'collection/create', 'post');
            ?>
            <div>
                <table style="width: 100%;" class="table-form">
                    <tr>
                        <td style="width: 250px;">
                            <div class="label-ina">ID Buku</div>
                            <div class="label-eng">Book ID</div>
                        </td>
                        <td style="width: 10px;">:</td>
                        <td>
                            <?php
                            Form::create('text', 'book_id');
                            Form::tips('Masukan nama bahasa');
                            Form::size(30);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::commit();
                            Form::create('button', 'btn_select_book');
                            Form::value('Cari');
                            Form::style('button-mid-solid-orange');
                            Form::commit();
                            ?>
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            <div class="label-ina">Eksemplar</div>
                            <div class="label-eng">Quantity</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'quantity');
                            Form::tips('Masukan jumlah eksemplar.');
                            Form::size(10);
                            Form::inputType()->numeric();
                            Form::validation()->requaired('* Jumlah eksemplar harus diisi.');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Kondisi Buku</div>
                            <div class="label-eng">Book Condition</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'book_condition');
                            Form::tips('Pilih status');
                            Form::option($option_book_condition, ' ');
                            Form::validation()->requaired('* Kondisi buku harus diisi.');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            Form::create('submit', 'btnSave');
                            Form::value('Save');
                            Form::style('button-mid-solid-blue');
                            Form::commit();
                            Form::create('reset', 'btnReset');
                            Form::value('Reset');
                            Form::style('button-mid-solid-red');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            Form::end();
            ?>
        </div>
    </div>
</div>

<div id="select-book">
    <?php
    Form::begin('frm_filter');
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
                    Form::style('form-grey');
                    Form::commit();
                    Form::create('text', 'members_id');
                    Form::style('form-grey');
                    Form::commit();
                    Form::create('button', 'btn_filter');
                    Form::style('button-mid-solid-orange');
                    Form::value('Cari');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <table id="list" link_r="<?php echo $link_filter; ?>">
    </table>
    <?php
    Form::end();
    ?>
</div>

<script>
    $(function() {

        /* SUBMIT ACTIONS */
        $('#fAdd').live('submit', function() {
            frmID = $(this);
            msgID = $('#message');
            var url = $(frmID).attr('action');
            var data = $(frmID).serialize();

            $(msgID).fadeOut('slow');
            $(this).loadingProgress('start');
            $.post(url, data, function(o) {
                $(this).loadingProgress('stop');
                if (o[0]) {
                    if (o[1]) {
                        $(frmID)[0].reset();
                    }
                }
                $(msgID).html(o[2]).fadeIn('slow');
            }, 'json');

            return false;
        });

        /* BUTTON ACTION */
        $('#btnBack').live('click', function() {
            window.location = $(this).attr('link');
        });
        
        $('#list').flexigrid({
            url: $('#list').attr('link_r'),
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'book_id',
                    width: 70,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Keterangan Buku',
                    name: 'book_title',
                    width: 450,
                    sortable: true,
                    align: 'left'
                }],
            buttons: [{
                    name: 'Pilih',
                    bclass: 'tick',
                    onpress: function() {
                        var leng = $('#list .trSelected').length;
                        if (leng > 0) {
                            var tempId;
                            $('#list .trSelected td[abbr=book_id] div').each(function() {
                                tempId = parseInt($(this).text());
                            });
                            $('#book_id').val(tempId).focus();
                            $('#select-book').dialog('close');
                        } else {
                            alert('Belum data buku yang dipilih.');
                        }
                    }
                }],
            nowrap: false,
            sortname: "book_id",
            sortorder: "asc",
            usepager: true,
            useRp: true,
            rp: 20,
            showTableToggleBtn: false,
            resizable: false,
            width: 595,
            height: 200,
            singleSelect:true,
            onSubmit: function() {
                var dt = $('#frm_filter').serializeArray();
                $('#list').flexOptions({
                    params: dt
                });
                return true;
            }
        });

        $('#select-book').dialog({
            title: 'Pilih Buku',
            closeOnEscape: false,
            autoOpen: false,
            height: 400,
            width: 620,
            modal: false,
            resizable: false,
            draggable: true
        });

        $('#btn_select_book').live('click', function() {
            $('#select-book').dialog('open');
        });

    });
</script>
