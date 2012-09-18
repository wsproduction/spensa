<div class="simple" style="min-height: 800px;">
    <h2><?php echo Web::getTitle(); ?></h2>
    <div class="box-list">
        <?php
        Form::begin('fFollow', 'subject/answer', 'post', true);

        Form::create('hidden', 'question_id');
        Form::value($questionID);
        Form::commit();
        ?>
        <div class="box-content">
            <div class="box-main">
                <div class="box-time">
                    <div class="count-down">
                        <div>
                            <?php
                            $cd = 0;
                            if ($listDataQuestion['range_date'] > 0)
                                $cd = $listDataQuestion['range_date'];
                            echo $cd;
                            ?>
                        </div>
                        Days a go
                    </div>
                    <div class="box-info">
                        <table>
                            <tr>
                                <th>Periode</th>
                                <td><?php echo date('d/m/Y', strtotime($listDataQuestion['question_start_date'])) . ' - ' . date('d/m/Y', strtotime($listDataQuestion['question_end_date'])); ?></td>
                            </tr>
                            <tr>
                                <th>Follower</th>
                                <td><?php echo $countFollower; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="cl">&nbsp;</div>
                </div>
                <div class="box-qustion">
                    <fieldset>
                        <legend>Question</legend>
                        <?php echo $listDataQuestion['question_description']; ?>
                    </fieldset>
                    <div style="height: 20px"></div>
                    <?php
                    if ($cd) {
                        ?>
                        <div>
                            <?php
                            Form::create('textarea', 'text_answer');
                            Form::commit();
                            ?>
                        </div>
                        <div style="margin: 10px 0;">
                            <div style="margin: 30px 0 0 0;">File Attachment : </div>
                            <div style="margin: 5px 0 10px 0;font-size: 11px;">Suport file extension: .doc, .docx, .pdf, .ppt, .pptx, .xls, .xlsx </div>
                            <?php
                            Form::create('file', 'file_answer');
                            Form::validation()->accept('doc|docx|pdf|ppt|pptx|xls|xlsx');
                            Form::commit();
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
            <div class="cl">&nbsp;</div>
            <div class="box-button">
                <div class="right">
                    <?php
                    if ($cd) {
                        Form::create('submit', 'btnSubmit');
                        Form::value('Save to Project');
                        Form::style('optSubmit');
                        Form::commit();
                    } else {
                        echo '<span style="color:red;">Expired&nbsp;</span>';
                    }
                    ?>
                </div>
            </div>
            <div class="cl">&nbsp;</div>
        </div>
        <?php
        Form::end();
        ?>
    </div>
    <div class="cl">&nbsp;</div>
    <!--<iframe src="http://docs.google.com/gview?url=http://ampundeh.files.wordpress.com/2012/04/hipotesis-daur-hidup-dan-konsumsi-serta-tabungan-pada-lansia.docx&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>-->
</div>
