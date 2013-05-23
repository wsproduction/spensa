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
            Form::begin('fAdd', 'members/update/' . $id, 'post', true);
            ?>
            <div>
                <table>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Nama Lengkap</div>
                            <div class="label-eng">Full Name</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'full_name');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::value($dataEdit['members_name']);
                            Form::style('form-grey');
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
                            Form::tips("<div class='tips-ina'>Pilih Jenis Kelamin</div><div class='tips-eng'>Select Gender</div>");
                            Form::option($list_gender, ' ', $dataEdit['members_gender']);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Tempat/Tgl. Lahir</div>
                            <div class="label-eng">Place/Birthdate</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'birthplace');
                            Form::tips("<div class='tips-ina'>Masukan Kota Kelahiran</div><div class='tips-eng'>Enter Birth Place</div>");
                            Form::size(40);
                            Form::value($dataEdit['members_birthplace']);
                            Form::style('form-grey');
                            Form::commit();

                            for ($i = 1; $i <= 31; $i++) {
                                $date[$i] = $i;
                            }
                            Form::create('select', 'birth_day');
                            Form::tips("<div class='tips-ina'>Pilih Tanggal Lahir</div><div class='tips-eng'>Select Birth Day</div>");
                            Form::option($date, ' ', date('d', strtotime($dataEdit['members_birthdate'])));
                            Form::style('form-grey');
                            Form::commit();

                            $month = array(
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember'
                            );
                            Form::create('select', 'birth_month');
                            Form::tips("<div class='tips-ina'>Pilih Bulan Lahir</div><div class='tips-eng'>Select Birth Month</div>");
                            Form::option($month, ' ', date('m', strtotime($dataEdit['members_birthdate'])));
                            Form::style('form-grey');
                            Form::commit();

                            for ($i = 1950; $i <= date('Y'); $i++)
                                $years[$i] = $i;
                            Form::create('select', 'birth_years');
                            Form::tips("<div class='tips-ina'>Pilih Tahun Lahir</div><div class='tips-eng'>Select Birth Year</div>");
                            Form::option($years, ' ', date('Y', strtotime($dataEdit['members_birthdate'])));
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
                            Form::value($dataEdit['members_address']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">No. Telepon</div>
                            <div class="label-eng">Phone Number</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'phone1');
                            Form::tips("<div class='tips-ina'>Masukan No. Telepon</div><div class='tips-eng'>Enter Phone Number</div>");
                            Form::size(40);
                            Form::value($dataEdit['members_phone1']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">No. Handphone</div>
                            <div class="label-eng">Handphone Number</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'phone2');
                            Form::tips("<div class='tips-ina'>Masukan No. Handphone</div><div class='tips-eng'>Enter Handphone Number</div>");
                            Form::size(40);
                            Form::value($dataEdit['members_phone2']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;"><div class="label-ina">Email</div></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'email');
                            Form::tips("<div class='tips-ina'>Masukan Email</div><div class='tips-eng'>Enter Email</div><div>Cth./Exam. : account@mail.com</div>");
                            Form::validation()->email();
                            Form::size(40);
                            Form::value($dataEdit['members_email']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding-top: 2px;"><div class="label-ina">Photo</div></td>
                        <td valign="top" style="padding-top: 2px;">:</td>
                        <td>
                            <div style="margin-left: 2px;" id="photopreview">
                                <?php
                                if ($dataEdit['members_photo'] != '') {
                                    echo Src::image($dataEdit['members_photo'], 'http://' . Web::getHost() . '/web/src/digilib_admin/asset/upload/images/members/', array('style' => 'width:100px;border:1px solid #ccc;padding:4px;'));
                                }
                                ?>
                            </div>
                            <?php
                            Form::create('file', 'photo');
                            Form::size(40);
                            Form::validation()->accept('jpg|jpeg|png');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Golongan</div>
                            <div class="label-eng">Group</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'isa');
                            Form::tips("<div class='tips-ina'>Pilih Status Members</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::option($list_isa, ' ', $dataEdit['members_isa']);
                            Form::validation()->requaired();
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Keterangan</div>
                            <div class="label-eng">Description</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'desc');
                            Form::tips("<div class='tips-ina'>Masukan Keterangan</div><div class='tips-eng'>Enter Description</div>");
                            Form::size(40);
                            Form::value($dataEdit['members_desc']);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;"><div class="label-ina">Status</div></td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'status');
                            Form::tips("<div class='tips-ina'>Pilih Status Members</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::option(array(1 => 'Enabled', 0 => 'Disabled'), null, $dataEdit['members_status']);
                            Form::validation()->requaired();
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
            $(this).loadingProgress('start');
            $(frmID).ajaxSubmit({
                success: function(o) {
                    $(this).loadingProgress('stop');
                    var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>', '');
                    if (parOut) {
                        var obj = eval('(' + parOut + ')');
                        if (obj[0]) {
                            if (obj[1]) {
                                $(frmID)[0].reset();
                            }

                            if (obj[3] != '') {
                                $('#photopreview').html($.base64.decode(obj[3]));
                            }

                        }
                        $(msgID).html($.base64.decode(obj[2])).fadeIn('slow');
                    }
                }
            });
            return false;
        });

        /* BUTTON ACTION */
        $('#btnBack').live('click', function() {
            window.location = $(this).attr('link');
        });

    });
</script>
