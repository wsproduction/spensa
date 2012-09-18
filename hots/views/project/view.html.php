<div class="simple" style="min-height: 800px;">
    <h2><?php echo Web::getTitle(); ?></h2>
    <div class="box-list">
        <?php
        Form::begin('fFollow', 'project/answer', 'post', true);

        Form::create('hidden', 'answer_id');
        Form::value($listData['answer_id']);
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
                    <div>
                        <?php
                        Form::create('textarea', 'text_answer');
                        Form::value($listData['answer_content']);
                        Form::commit();
                        ?>
                    </div>
                    <div style="margin: 10px 0;">
                        <div style="margin: 30px 0 0 0;">File Attachment : </div>
                        <div style="margin: 5px 0 10px 0;font-size: 11px;">Suport file extension: .doc, .docx, .pdf, .ppt, .pptx, .xls, .xlsx </div>
                        <?php
                        if ($listData['answer_file'] != '' && file_exists(Web::path() . '/asset/upload/file/' . $listData['answer_file'])) {
                            ?>
                            <div class="icon-file">
                                <?php
                                list($file_name, $file_ext) = explode('.', $listData['answer_file']);
                                switch ($file_ext) {
                                    case 'doc':
                                        echo Src::image('doc.png');
                                        break;
                                    case 'docx':
                                        echo Src::image('doc.png');
                                        break;
                                    case 'pdf':
                                        echo Src::image('pdf.png');
                                        break;
                                    case 'ppt':
                                        echo Src::image('ppt.png');
                                        break;
                                    case 'xls':
                                        echo Src::image('xls.png');
                                        break;
                                }
                                ?>
                                <div class="info-file">
                                    <?php echo $listData['answer_file']; ?>
                                    <div class="opsi-file">
                                        <?php
                                        URL::link('#view', 'View');
                                        echo ' | ';
                                        URL::link('http://' . Web::$host . '/project/download/' . $listData['answer_file'], 'Download');
                                        if ($listData['answer_status'] == 1) {
                                            echo ' | ';
                                            URL::link('#delete', 'Delete');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="cl">&nbsp;</div>
                            </div>
                            <div class="box-upload" style="display: none;">
                                <?php
                            } else {
                                ?>
                                <div class="box-upload">
                                    <?php
                                }
                                Form::create('file', 'file_answer');
                                Form::validation()->accept('doc|docx|pdf|ppt|pptx|xls|xlsx');
                                Form::commit();
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="cl">&nbsp;</div>
                <div class="box-button">
                    <div class="right">
                        <?php
                        Form::create('submit', 'btnSubmit');
                        Form::value('Save to Project');
                        if ($listData['answer_status'] == 1) {
                            Form::style('optSubmit');
                        } else {
                            Form::style('optFollowDisabled');
                            Form::properties(array('disabled'=>'disabled'));
                        }
                        Form::commit();
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


    <div id="file-view">
        <?php
        /*$link_embed = 'http://docs.google.com/gview?url=http://ampundeh.files.wordpress.com/2012/04/hipotesis-daur-hidup-dan-konsumsi-serta-tabungan-pada-lansia.docx&embedded=true';*/
        $link_embed = 'http://docs.google.com/gview?url=' . 'http://' . Web::$host . '/hots/asset/web/upload/file/' . $listData['answer_file'] . '&embedded=true';
        ?>
        <iframe src="<?php echo $link_embed; ?>" style="width:600px; height:500px;" frameborder="0"></iframe>
    </div>

    <div id="conf-delete" link="<?php echo 'http://' . Web::$host . '/project/deleteFile'; ?>" aid="<?php echo $listData['answer_id']; ?>" file="<?php echo $listData['answer_file']; ?>">
        Are you sure to delete this file?
    </div>

