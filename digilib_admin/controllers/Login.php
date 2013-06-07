<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        $login = $this->model->login();
        if ($login[0]) {
            $data_user = $login[1];
            $data_user = $data_user[0];
            Session::init();
            Session::set('loginStatus', 1);
            Session::set('user_id', $data_user['user_id']);
            Session::set('user_full_name', $data_user['full_name']);
            Session::set('user_photo', $data_user['photo']);
            Session::set('user_group', $data_user['user_group_name']);
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