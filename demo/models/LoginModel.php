<?php

class LoginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {

        $sth = $this->db->prepare('SELECT * FROM users WHERE username = :username AND password = MD5(:password)');
        $sth->execute(array(':username' => $_POST['username'], ':password' => $_POST['password']));

        $count = $sth->rowCount();
        if ($count > 0) {

            Session::init();
            Session::set('statusLogin', true);

            $this->url->redirect('../dashboard');
        } else {
            $this->url->redirect('../login');
        }
    }

}