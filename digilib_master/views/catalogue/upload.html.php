<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php            
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link'=>$link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="pesan"></div>
        <?php
        /*echo base64_encode('<b style="text-align">aku</b>');*/
        Form::begin('fUpload', 'catalogue/postUpload', 'post', true);
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Gambar</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('file', 'gambar');
                        Form::tips('Enter Book Title');
                        Form::validation()->accept('jpg|jpeg');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">File</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('file', 'file');
                        Form::tips('Enter Book Title');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php
                        Form::create('submit', 'btnUpload');
                        Form::value('Save');
                        Form::style('action_save');
                        Form::commit();
                        Form::create('reset', 'btnReset');
                        Form::value('Reset');
                        Form::style('action_cancel');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        Form::end();
        ?>
    </div>
</div>
