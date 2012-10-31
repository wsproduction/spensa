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
        Form::begin('fAdd', 'booksource/update/' . $id, 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Keterangan Sumber</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'title');
                        Form::tips('Masukan keterangan sumber');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::value($dataEdit['book_fund_title']);
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'status');
                        Form::tips('Pilih status');
                        Form::option(array('0'=>'Disabled', '1'=>'Enabled'),null,$dataEdit['book_fund_status']);
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