<?php

class Signin extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Session::init();
        
        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryBase64();
    }

    public function index() {
        if (Session::get('loginStatus')) {
            $this->url->redirect('http://' . Web::$host . '/index');
            exit;
        }
        Web::setTitle('Sign In');
        $this->view->render('signin/index');
    }

    public function run() {
        $login = $this->model->login();
        if ($login[0]) {
            $data_user = $login[1];
            $data_user = $data_user[0];
            Session::init();
            Session::set('loginStatus', 1);
            Session::set('id', $data_user['student_id']);
            Session::set('nis', $data_user['student_register_number']);
            Session::set('name', $data_user['student_first_name'] . ' ' . $data_user['student_last_name']);
            $ket = '{s:1, msg:"' . base64_encode($this->content->setLink('index')) . '"}';
        } else {
            $ket = '{s:0, msg:"' . base64_encode($this->message->loginError()) . '"}';
        }
        echo $ket;
    }

    public function stop() {
        Session::destroy();
        $this->url->redirect($this->content->setLink('index'));
    }

}