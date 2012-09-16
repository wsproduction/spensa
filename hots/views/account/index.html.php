<div class="simple" style="height: 600px;">
    <h2><?php echo Web::getTitle(); ?></h2>
    <div style="margin-top: 20px;">

        <div id="tabs" style="width: 598px;">
            <ul>
                <li><?php URL::link('#fragment-1', 'Project') ?></li>
                <li><?php URL::link('#fragment-2', 'Profile') ?></li>
                <li><?php URL::link('#fragment-3', 'Change Password') ?></li>
            </ul>
            <div id="fragment-1">
                <table class="my-grid" cellspacing="0" cellpadding="0" style="width: 570px;">
                    <thead>
                        <tr>
                            <th class="first">Subject</th>
                            <th style="width: 150px;">Periode</th>
                            <th style="width: 80px;">Last Update</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 50px;">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $listProject; ?>
                    </tbody>
                </table>
            </div>
            <div id="fragment-2">
                <div style="float: left;">
                    <a href="#"><?php echo Src::image('face.gif', null, array('style'=>'border:1px solid #ccc;padding:4px;max-width:200px;')); ?></a>
                </div>
                <div style="float: left;margin-left: 10px;">
                    <?php
                    Form::begin('fChangeAvatar', 'account/changeAvatar', 'post', true);
                    
                    Form::create('file','avatar');
                    Form::size(20);
                    Form::commit();
                    echo '<br><br>';
                    Form::create('submit','bSubmit');
                    Form::value('Upload');
                    Form::commit();
                    
                    Form::end();
                    ?>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <div id="fragment-3">
                <?php
                Form::begin('fChangePassword', 'account/changePassword', 'post', true);
                ?>
                <div id="msg_change_password"></div>
                <table>
                    <tr>
                        <td>Old Password</td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('password', 'old_password');
                            Form::validation()->requaired();
                            /*Form::validation()->remote('account/cp', 'post');*/
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Password</td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('password', 'new_password');
                            Form::validation()->requaired();
                            Form::validation()->minLength(6);
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm New Password</td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('password', 'conf_password');
                            Form::validation()->requaired();
                            Form::validation()->equalTo('#new_password');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            Form::create('submit', 'btnSubmit');
                            Form::value('Submit');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
                Form::end();
                ?>
            </div>
        </div>
        <div class="cl">&nbsp;</div>
    </div>

</div>
