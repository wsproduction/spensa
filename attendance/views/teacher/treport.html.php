<div class="box">
    <fieldset>
        <legend>Data Filter Laporan</legend>
        <div>
            <?php Form::begin('fTReport', 'teacher/treportprint', 'post', true, 'viewreport'); ?>

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
                    <td><?php Form::label('Tanggal ', 'sdate'); ?></td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'sdate');
                        Form::validation()->requaired();
                        Form::commit();

                        Form::label(' s.d ', 'fdate');

                        Form::create('text', 'fdate');
                        Form::validation()->requaired();
                        Form::validation()->largerDateFrom('#sdate');
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
        <iframe id="viewreport" frameborder="0" style="width: 100%;height: 400px;"></iframe>
    </div>
</div>