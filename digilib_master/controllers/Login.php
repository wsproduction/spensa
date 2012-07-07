<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();

        Session::init();
        Src::plugin()->poshytip();
    }

    public function index() {
        $this->url->redirect('index');
    }

    public function run() {
        $login = $this->model->login();
        if ($login[0]) {
            $data_user = $login[1];
            $data_user = $data_user[0];
            Session::init();
            Session::set('loginStatus', 1);
            Session::set('userName', $data_user['full_name']);
            Session::set('userGroup', $data_user['user_group_name']);
            $ket = array(1,'http://' . Web::$host . '/' . Web::$webAlias . '/dashboard');
        } else {
            $ket = array(0,null);
        }
        echo json_encode($ket);
    }

    public function stop() {
        Session::destroy();
        $this->url->redirect('../index');
    }

}