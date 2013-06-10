<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'about/update', 'post');
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
                            Form::value($dataEdit['digilib_name']);
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
                            Form::create('text', 'email');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->email();
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_email']);
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
                            Form::create('text', 'website');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_website']);
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
                            Form::create('text', 'agency_name');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_agency_name']);
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
                            Form::value($dataEdit['digilib_address']);
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
                            Form::create('text', 'head_of_library');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_head_of_library']);
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
                            Form::create('text', 'nip');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_nip']);
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
                            Form::create('textarea', 'vision');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(60, 6);
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_vision']);
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
                            Form::create('textarea', 'mission');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(60, 6);
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_mision']);
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <div class="label-ina">Aturan Peminjaman Buku</div>
                            <div class="label-eng">Rule Borrowing</div>
                        </td>
                        <td valign="top">:</td>
                        <td>
                            <?php
                            Form::create('textarea', 'rule_borrowing');
                            Form::tips("<div class='tips-ina'>Masukan Alamat</div><div class='tips-eng'>Enter Address</div>");
                            Form::size(80, 4);
                            Form::style('form-grey');
                            Form::value($dataEdit['digilib_rule_borrowing']);
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
        
        /* WYSIWYG elRTE */
        elRTE.prototype.options.panels.web2pyPanel = [
            'bold', 'italic', 'underline', 'insertorderedlist', 'insertunorderedlist'
        ];
        elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel'];

        var opts = {
            cssClass: 'el-rte',
            height: 180,
            width: 600,
            toolbar: 'web2pyToolbar',
            cssfiles: ['css/elrte-inner.css']
        };

        $('#rule_borrowing').elrte(opts);

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
                        /* $(frmID)[0].reset(); */
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
