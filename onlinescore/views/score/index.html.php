<div class="hr"></div>
<div class="box-score-check">
    <div class="fl-left box-frame-check">
        <?php
        Form::begin('fScoreCheck', 'score/check', 'post', true);
        ?>
        <table class="frame-form">
            <tr>
                <td><b>Select Semester :</b></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <?php
                    $array = array('201220131' => '2012/2013 - Semester 1', '201220132' => '2012/2013 - Semester 2');
                    Form::create('select', 'semester');
                    Form::option($array);
                    Form::commit();
                    ?>
                </td>
                <td>
                    <?php
                    Form::create('submit', '');
                    Form::value('Check');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
        <?php
        Form::end();
        ?>
    </div>
    <div class="cl">&nbsp;</div>
</div>
