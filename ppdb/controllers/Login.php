<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        if ($username == $password) {
            Session::init();
            Session::set('__login_status', true);
            $ket = array(true, $this->content->setLink('dashboard'));
        } else {
            $ket = array(false, $this->message->loginError());
        }
        echo json_encode($ket);
    }

    public function stop() {
        Session::destroy();
        $this->url->redirect($this->content->setLink('index'));
    }

}