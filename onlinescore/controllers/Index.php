<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Src::css('dumy');
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }

}