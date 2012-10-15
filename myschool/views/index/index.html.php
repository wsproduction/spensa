<?php Form::begin('form_login', 'login/run', 'post', false); ?>
<div class="box-login">
    <div class="message"></div>
    <?php Form::label('Username :', 'username'); ?>
    <div>
        <?php
        Form::create('text', 'username');
        Form::commit();
        ?>
    </div>
    <?php Form::label('Password :', 'password'); ?>
    <div>
        <?php
        Form::create('password', 'password');
        Form::commit();
        ?>
    </div>
    <div>
        <?php
        Form::create('submit', 'button_login');
        Form::value('Login');
        Form::commit();
        ?>
    </div>
</div>
<?php Form::end(); ?>