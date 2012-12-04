<div class="box">
    <fieldset>
        <legend>Data Filter Laporan</legend>
        <div>
            <?php Form::begin('fTReport', 'teacher/rreportprint', 'post', true, 'viewreport'); ?>

            <table>
                <tr>
                    <td style="width: 120px;"><?php Form::label('Nama', 'sdate'); ?></td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'name');
                        Form::option($option_name, 'Pilih Semua', '');

                        Form::commit();

                        $nameid = '0';
                        foreach ($option_name as $key => $value) {
                            $nameid .= ',' . $key;
                        }

                        Form::create('hidden', 'nameid');
                        Form::value($nameid);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 120px;"><?php Form::label('Jenis Rekap', 'sdate'); ?></td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'recap_type');
                        Form::option($option_recap_type, 'Pilih', '');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php Form::label('Bulan ', 'month'); ?></td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'month');
                        Form::option($option_month_name, 'Pilih');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php Form::label('Tahun ', 'years'); ?></td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'years');
                        Form::option($option_years, 'Pilih');
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
                        Form::value('Cetak');
                        Form::style('action_print');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>

            <?php Form::end(); ?>
        </div>
    </fieldset>
</div>

<div class="box">
    <div class="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
    </div>
    <div style="text-align: center;">
        <iframe id="viewreport" frameborder="0" class="v-repots"></iframe>
    </div>
</div>