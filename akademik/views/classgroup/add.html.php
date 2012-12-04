<div class="box">
    <div class="box_title">
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
        Form::begin('fAdd', 'classgroup/create', 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Tahun Akademik</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'period');
                        Form::validation()->requaired();
                        Form::option($option_period,' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td style="width: 200px;">Kelas</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'class');
                        Form::validation()->requaired();
                        Form::option($option_class,' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td style="width: 200px;">Wali Kelas</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'guardian');
                        Form::validation()->requaired();
                        Form::option($option_guardian,' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td style="width: 200px;">Nama Bahasa</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'title');
                        Form::tips('Masukan nama bahasa');
                        Form::size(40);
                        Form::validation()->requaired();
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
                        Form::option(array('0'=>'Disabled', '1'=>'Enabled'));
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
