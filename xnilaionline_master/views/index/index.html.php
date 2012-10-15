<div id="#message"></div>
<?php
Form::begin('fLogin', 'login/run', 'post', true);

Form::create('text', 'username');
Form::commit();

Form::create('password', 'password');
Form::commit();

Form::create('submit', 'btnSubmit');
Form::value('Login');
Form::commit();

Form::end();
?>