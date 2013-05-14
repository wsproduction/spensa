<?php

class Un extends Controller {

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
        Web::setTitle('Beranda');
        $this->view->render('index/index');
    }

    public function jadwalPengawas() {
        Web::setTitle('Beranda');
        $this->view->render('un/jadwalpengawas');
    }

}