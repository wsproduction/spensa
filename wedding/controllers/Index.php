<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        Src::plugin()->nivoSlider();
        Src::plugin()->jsCountDown();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }

}