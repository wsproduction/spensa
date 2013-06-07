<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'language/create', 'post');
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
                            Form::value($dataEdit['full_name']);
                            Form::validation()->requaired();
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
                            Form::option($list_gender, ' ', $dataEdit['gender']);
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
                            Form::style('form-grey');
                            Form::commit();

                            for ($i = 1; $i <= 31; $i++) {
                                $date[$i] = $i;
                            }
                            Form::create('select', 'birth_day');
                            Form::tips("<div class='tips-ina'>Pilih Tanggal Lahir</div><div class='tips-eng'>Select Birth Day</div>");
                            Form::option($date, ' ');
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
                            Form::option($month, ' ');
                            Form::style('form-grey');
                            Form::commit();

                            for ($i = 1950; $i <= date('Y'); $i++)
                                $years[$i] = $i;
                            Form::create('select', 'birth_years');
                            Form::tips("<div class='tips-ina'>Pilih Tahun Lahir</div><div class='tips-eng'>Select Birth Year</div>");
                            Form::option($years, ' ');
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
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;"><div class="label-ina">Photo</div></td>
                        <td>:</td>
                        <td>
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
