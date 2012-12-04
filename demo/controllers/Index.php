<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        Web::title('Beranda', true, '|');
        $this->view->render('Index/index');
    }

}