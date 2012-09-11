<?php

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        Web::setTitle('Dashboard');
        $this->view->render('dashboard/index');
    }

}