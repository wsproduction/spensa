<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        /*
        $login = $this->model->login();
        if ($login[0]) {
            $data_user = $login[1];
            $data_user = $data_user[0];
            Session::init();
            Session::set('login_status', 1);
            Session::set('name', $data_user['FULL_NAME']);
            $ket = array(1,$this->content->setLink('dashboard'));
        } else {
            $ket = array(0,$this->message->loginError());
        }*/
        
        $username = $this->method->post('username');
        $password = $this->method->post('password');
        
        if ($username == 'admin' && $password = 'password') {
            Session::init();
            Session::set('login_status', 1);
            Session::set('name', 'admin');
            $ket = array(1,$this->content->setLink('dashboard'));
        } else {
            $ket = array(0,$this->message->loginError());
        }
        
        echo json_encode($ket);
    }

    public function stop() {
        Session::destroy();
        $this->url->redirect($this->content->setLink('index'));
    }

}