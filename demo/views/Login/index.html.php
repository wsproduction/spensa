<h3>Login</h3>
<?php
Form::begin('login', 'login/run', 'post');

Form::create('text', 'username');
Form::tips('Please enter username');
Form::commit();

Form::create('password', 'password');
Form::tips('Please enter password');
Form::commit();

Form::create('submit');
Form::value('Login');
Form::commit();

Form::end();
?>