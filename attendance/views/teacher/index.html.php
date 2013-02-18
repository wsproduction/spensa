
<fieldset>
    <legend>Data Filter</legend>
    <div>
        <?php Form::begin('fFilter', 'attendance/read', 'post'); ?>

        <table>
            <tr>
                <td style="width: 80px;"><?php Form::label('Nama', 'sdate'); ?></td>
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
                    Form::value('Filter');
                    Form::style('action_search');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>

        <?php Form::end(); ?>
    </div>
</fieldset>

<br>

<table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>
