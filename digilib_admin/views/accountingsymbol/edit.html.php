<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="btn-group">
                <a href="#" class="dropdown">Aksi</a>
                <ul>
                    <li><a href="<?php echo $link_back; ?>">Kembali</a></li>
                    <li><a href="#">Hapus</a></li>
                </ul>
            </div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'accountingsymbol/update/' . $id, 'post');
            ?>
            <div>
                <table>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Nama Mata Uang</div>
                            <div class="label-eng">Currency Name</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'title');
                            Form::tips('Masukan nama mata uang');
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::value($dataEdit['accounting_symbol_title']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>        
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Simbol</div>
                            <div class="label-eng">Symbol</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'symbol');
                            Form::tips('Masukan symbol');
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::value($dataEdit['accounting_symbol']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>        
                    <tr>
                        <td>
                            <div class="label-ina">Status</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'status');
                            Form::tips('Pilih status');
                            Form::option(array('0' => 'Disabled', '1' => 'Enabled'), null, $dataEdit['accounting_symbol_status']);
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
    });
</script>
