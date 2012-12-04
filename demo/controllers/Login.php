<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();

        Session::init();
        Src::plugin()->poshytip();
    }

    public function index() {
        if (Session::get('statusLogin') == true) {
            $this->url->redirect('dashboard');
            exit;
        }

        Web::title('Login', true, '|');
        $this->view->render('Login/index');
    }

    public function run() {
        $this->model->login();
    }

    public function stop() {
        Session::destroy();
        header('location:../login');
    }

}