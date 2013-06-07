<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'user/updateaccount', 'post');
            ?>
            <div>
                <table>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Nama Perpustakaan</div>
                            <div class="label-eng">Library Name</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'library_name');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->remote('cekcurentpassword', 'post');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Email</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'confirm_new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::validation()->equalTo('#new_password');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Website</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'confirm_new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::validation()->equalTo('#new_password');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Nama Instansi</div>
                            <div class="label-eng">Agency Name</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'confirm_new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::validation()->equalTo('#new_password');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Alamat</div>
                            <div class="label-eng">Address</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            Form::create('textarea', 'address');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(80, 4);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Kepala Perpustakaan</div>
                            <div class="label-eng">Head of Library</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'confirm_new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::validation()->equalTo('#new_password');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">NIP</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'confirm_new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::validation()->equalTo('#new_password');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Visi</div>
                            <div class="label-eng">Vision</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            Form::create('textarea', 'address');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(60, 6);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Misi</div>
                            <div class="label-eng">Mission</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            Form::create('textarea', 'address');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(60, 6);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Aturan Peminjaman Buku</div>
                            <div class="label-eng">Borrowing Rule Book</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            Form::create('textarea', 'address');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(80, 4);
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
