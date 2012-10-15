<div class="myBox">
    <div class="title"><?php echo Web::$title; ?></div>
    <div class="content">
        <table style="width: 100%">
            <tr>
                <th style="width: 200px;">ID</th>
                <th style="width: 10px;">:</th>
                <td>
                    <?php 
                    echo $tempId; 
                    Form::create('hidden','qid');
                    Form::value($tempId);
                    Form::commit();
                    Form::create('hidden','linkPrint');
                    Form::value($link_print);
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th>Subject</th>
                <th>:</th>
                <td><?php echo $subject['subject_title']; ?></td>
            </tr>
            <tr>
                <th>Question Title</th>
                <th>:</th>
                <td><?php echo $subject['question_title']; ?></td>
            </tr>
            <tr>
                <th>Question Description</th>
                <th>:</th>
                <td><?php echo $subject['question_description']; ?></td>
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
                    <div id="view-answer">
                        <div id="tabs">
                            <ul>
                                <li><?php URL::link('#fragment-1', 'Plain Text') ?></li>
                                <li><?php URL::link('#fragment-1', 'File Attachment') ?></li>
                            </ul>
                            <div id="fragment-1">ssss</div>
                        </div>
                        <div>
                            <?php
                            Form::begin('fRating','data/score','post');
                            Form::create('text','score');
                            Form::commit();
                            Form::create('button','score');
                            Form::value('Save');
                            Form::commit();
                            Form::end();
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>