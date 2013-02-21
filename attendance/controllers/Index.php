<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();
        if (Session::get('login_status')) {
            $this->url->redirect($this->content->setLink('dashboard'));
            exit;
        }
                
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
    }

    public function index() {
        Web::setTitle('Beranda');
        $this->view->render('index/index');
    }

    public function login() {
        
    }

}