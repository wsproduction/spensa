<div class="myBox">
    <div class="title"><?php echo Web::$title; ?></div>
    <div class="content">
        <table style="width: 100%">
            <tr>
                <td style="width: 200px;">ID</td>
                <td style="width: 10px;">:</td>
                <td><?php echo $tempId; ?></td>
            </tr>
            <tr>
                <td>Question Title</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Question Description</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php
                    Form::begin('frmFilter');
                    Form::create('hidden', 'tempQuestionId');
                    Form::value($tempId);
                    Form::commit();
                    Form::end();
                    ?>
                    <table class="flexme4" link="<?php echo $link; ?>" style="display: none;"></table>
                </td>
            </tr>
        </table>
    </div>
</div>