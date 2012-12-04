<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Kembali');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'publisher/create', 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">
                        <div class="label-ina">Nama</div>
                        <div class="label-eng">Name</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'name');
                        Form::tips('Masukan nama penerbit');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <div class="label-ina">Keterangan</div>
                        <div class="label-eng">Description</div>
                    </td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'description');
                        Form::tips('Masukan keterangan.');
                        Form::size(80, 4);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <fieldset>
                            <legend>Keterangan Kantor</legend>
                            <div class="float-left" style="width: 600">
                                <table>
                                    <tr>
                                        <td style="width: 185px;" valign="top">
                                            <div class="label-ina">Keterangan kantor</div>
                                            <div class="label-eng">Office Description</div>
                                        </td>
                                        <td style="width: 10px;" valign="top">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'office_description');
                                            Form::option($option_department);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;" valign="top">
                                            <div class="label-ina">Alamat</div>
                                            <div class="label-eng">Address</div>
                                        </td>
                                        <td style="width: 10px;" valign="top">:</td>
                                        <td>
                                            <?php
                                            Form::create('textarea', 'address');
                                            Form::size(75, 3);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Negara</div>
                                            <div class="label-eng">Country</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'country');
                                            Form::option($option_country, ' ');
                                            Form::properties(array('link' => $link_province));
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Provinsi</div>
                                            <div class="label-eng">Province</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'province');
                                            Form::properties(array('link' => $link_city));
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Kota</div>
                                            <div class="label-eng">City</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'city');
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Kode Pos</div>
                                            <div class="label-eng">Zip Code</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'zipcode');
                                            Form::size(10);
                                            Form::inputType()->numeric();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">No. Telepon</div>
                                            <div class="label-eng">Phone Number</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'phone');
                                            Form::size(20);
                                            Form::inputType()->numeric();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Fax.</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'fax');
                                            Form::size(20);
                                            Form::inputType()->numeric();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Email</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'email');
                                            Form::size(30);
                                            Form::validation()->email();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 185px;">
                                            <div class="label-ina">Website</div>
                                        </td>
                                        <td style="width: 10px;">:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'website');
                                            Form::size(30);
                                            Form::validation()->url();
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <?php
                                            Form::create('button', 'btnAddOffice');
                                            Form::value('Tambah');
                                            Form::style('action_add');
                                            Form::properties(array('link'=>$link_add_office));
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="float-left">
                                <table title="Daftar Alamat Kantor" id="list-office" link_r="<?php echo $link_r_office; ?>" link_d="<?php echo $link_d_office; ?>"></table>
                            </div>
                            <div class="cl"></div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="right">
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
