<?php

class Signin extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Session::init();
        Src::plugin()->poshytip();
    }

    public function index() {
        if (Session::get('statusLogin') == true) {
            $this->url->redirect('dashboard');
            exit;
        }

        Web::setTitle('Sign In');
        $this->view->render('signin/index');
    }

    public function run() {
        $this->model->login();
    }

    public function stop() {
        Session::destroy();
        header('location:../login');
    }

}