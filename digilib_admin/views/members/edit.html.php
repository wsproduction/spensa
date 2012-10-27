<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
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
                        Form::commit();

                        for ($i = 1; $i <= 31; $i++) {
                            $date[$i] = $i;
                        }
                        Form::create('select', 'birth_day');
                        Form::tips("<div class='tips-ina'>Pilih Tanggal Lahir</div><div class='tips-eng'>Select Birth Day</div>");
                        Form::option($date, ' ', date('d', strtotime($dataEdit['members_birthdate'])));
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
                        Form::commit();

                        for ($i = 1950; $i <= date('Y'); $i++)
                            $years[$i] = $i;
                        Form::create('select', 'birth_years');
                        Form::tips("<div class='tips-ina'>Pilih Tahun Lahir</div><div class='tips-eng'>Select Birth Year</div>");
                        Form::option($years, ' ', date('Y', strtotime($dataEdit['members_birthdate'])));
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
                        Form::style('action_save');
                        Form::commit();
                        Form::create('reset', 'btnReset');
                        Form::value('Reset');
                        Form::style('action_cancel');
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
