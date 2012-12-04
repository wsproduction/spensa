
<div id="box">
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

