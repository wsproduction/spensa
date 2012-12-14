<?php

class Home extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('home/index');
    }
}