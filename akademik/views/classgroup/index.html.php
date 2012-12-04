<div class="box">
    <fieldset>
        <legend>Data Filter</legend>
        <div>
            <?php Form::begin('fFilter', 'classgroup/read', 'post'); ?>

            <table>
                <tr>
                    <td style="width: 120px;">Kelas</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'class');
                        Form::option($option_class, '');
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
</div>

<table id="list" title="<?php echo Web::getTitle(false); ?>" link_r="<?php echo $link_r; ?>"  link_d="<?php echo $link_d; ?>"></table>
