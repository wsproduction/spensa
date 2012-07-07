<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->topMenu = $this->content->topMenu();

        Session::init();
        if (Session::get('loginStatus')) {
            $this->url->redirect('dashboard');
            exit;
        }
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
    }

    public function index() {
        Web::title('Beranda', true, '|');
        $this->view->render('Index/index');
    }

    public function login() {
        
    }

}