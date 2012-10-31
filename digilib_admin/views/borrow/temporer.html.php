
<div id="box">
    <fieldset>
        <legend>Data Peminjaman</legend>
        <div class="borrowed-info">
            <div class="float-left">
                <?php Form::begin('fSearchInfoMember', 'attendance/read', 'post'); ?>
                <table>
                    <tr>
                        <td style="width: 140px;">
                            <div class="label-ina">Jenis Peminjaman</div>
                            <div class="label-eng">Borrowed Type</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'name');
                            Form::option($borrowTypeOption, 'Pilih', '');
                            Form::validation()->requaired();
                            Form::commit();

                            $nameid = '0';
                            foreach (array() as $key => $value) {
                                $nameid .= ',' . $key;
                            }

                            Form::create('hidden', 'nameid');
                            Form::value($nameid);
                            Form::validation()->requaired();
                            Form::inputType()->numeric();
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="label-ina">Nomor Anggota</div>
                            <div class="label-eng">Member ID</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('text', 'sdate');
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
                            Form::create('submit', 'bSubmit');
                            Form::value('Cari');
                            Form::style('action_search');
                            Form::commit();
                            Form::create('reset', 'bSubmit');
                            Form::value('Reset');
                            Form::style('action_cancel');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php Form::end(); ?>
            </div>
            <div class="float-right">
                <div class="members-info">
                    <div class="float-right">
                        <?php
                        echo Src::image('photo_201210251351133583.jpg', 'http://' . Web::getHost() . '/web/src/' . Web::$webFolder . '/asset/upload/images/members/', array('id'=>'member-photo'));
                        ?>
                    </div>
                    <div class="float-right members-profile">
                        <div><b>Warman Suganda, S.Kom.</b></div>
                        <div>Subang, 24 September 1988</div>
                        <div>Laki-Laki / Male</div>
                        <div>Karyawan</div>
                        <div>Kp. Jawura Ds. SUmbersari Kec. Pagaden Kab. Subang 41252</div>
                    </div>
                </div>
                <div class="cl"></div>
            </div>
            <div class="cl"></div>
        </div>
    </fieldset>
</div>

<table id="list" title="Riwayat Peminjaman" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

