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
        Form::begin('fAdd', 'author/update/' . $id, 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">First Name</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'first_name');
                        Form::tips('Enter First Name');
                        Form::size(40);
                        Form::value($dataEdit['author_first_name']);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Last Name</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'last_name');
                        Form::tips('Enter Last Name');
                        Form::size(40);
                        Form::value($dataEdit['author_last_name']);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Description</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'profile');
                        Form::tips('Enter Description');
                        Form::value($dataEdit['author_profile']);
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
