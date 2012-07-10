<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();
        if (Session::get('loginStatus')) {
            $this->url->redirect('http://' . Web::$host . '/' . Web::$webAlias . '/dashboard');
            exit;
        }
        
        $this->view->topMenu = $this->content->topMenu();
        
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