<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
    </div>

    <div style="margin: 10px 0;">
        <fieldset>
            <legend>Filter Data</legend>
            <?php Form::begin('fChartFilter', 'chart/chart', 'post'); ?>
            <table>
                <tr>
                    <td width="150">
                        <div class="label-ina">Tahun Ajaran</div>
                        <div class="label-eng">Academic Period</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'period');
                        Form::properties(array('style' => 'width:120px;'));
                        Form::option($option_period);
                        Form::commit();
                        echo ' ';
                        Form::create('submit', 'bSubmit');
                        Form::value('Cari');
                        Form::style('action_search');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
            <?php Form::end(); ?>
        </fieldset>
    </div>

    <div id="container" style="min-width: 400px; margin: 10px 9px 0 0">
        <iframe style="width: 100%" frameborder="0"></iframe>
    </div>
</div>

<script>
    $(function(){
        $('#container iframe').css('height',screen.height * 0.55);
        
    });
</script>