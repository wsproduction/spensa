<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function run() {
        if ($this->method->isAjax()) {
            header('Content-type: text/xml');
            $xml = '<?xml version="1.0" encoding="utf-8"?>';
            $xml .= '<data>';
            $login = $this->model->login();
            if ($login[0]) {
                $data_user = $login[1];
                $data_user = $data_user[0];
                Session::init();
                Session::set('login_status', 1);
                Session::set('user_id', $data_user['user_id']);
                $xml .= '<status>1</status>';
                $xml .= '<direct><![CDATA[' . $this->content->setLink('home') . ']]></direct>';
            } else {
                $xml .= '<status>0</status>';
                $xml .= '<message><![CDATA[' . $this->message->loginError() . ']]></message>';
            }
            $xml .= '</data>';

            echo $xml;
        }
    }

    public function stop() {
        Session::destroy();
        $this->url->redirect($this->content->setLink('index'));
    }

}