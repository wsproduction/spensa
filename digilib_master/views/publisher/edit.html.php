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
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'ddc/update/' . $id, 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Call Number</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'callNumber');
                        Form::tips('Enter Call Number');
                        Form::value($dataEdit['ddc_call_number']);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td>Level</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'level');
                        Form::tips('Chose Level DDC');
                        Form::validation()->requaired();
                        Form::option($ddcLevel, ' ', $dataEdit['ddc_level']);
                        Form::properties(array('link'=>'#'));
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr class="sub1" style="display: none;">
                    <td>Main Class</td>
                    <td>:</td>
                    <td class="sub1">
                        <?php
                        Form::create('select', 'sub1');
                        Form::tips('Chose Level DDC');
                        Form::option($listSub1[0],'',$listSub1[1]);
                        Form::properties(array('link'=>$link_sub2));
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr class="sub2" style="display: none;">
                    <td>Sub Class</td>
                    <td>:</td>
                    <td class="sub2">
                        <?php
                        Form::create('select', 'sub2');
                        Form::tips('Chose Level DDC');
                        Form::option($listSub2[0],'',$listSub2[1]);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'title');
                        Form::tips('Enter titel DDC');
                        Form::size(40,4);
                        Form::validation()->requaired();
                        Form::value($dataEdit['ddc_title']);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Description</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'description');
                        Form::tips('Enter Description');
                        Form::value($dataEdit['ddc_description']);
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
