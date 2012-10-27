<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php            
            Form::create('button', 'btnBack');
            Form::value('Kembali');
            Form::style('action_back');
            Form::properties(array('link'=>$link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'authordescription/update/' . $id, 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Keterangan Pengarang</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'title');
                        Form::tips('Masukan keterangan pengarang');
                        Form::size(40);
                        Form::value($dataEdit['author_description_title']);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td>Tingkatan</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'level');
                        Form::tips('Masukan tingkatan keterangan pengarang');
                        Form::size(10);
                        Form::value($dataEdit['author_description_level']);
                        Form::validation()->requaired();
                        Form::inputType()->numeric();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php
                        Form::create('submit', 'btnSave');
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
