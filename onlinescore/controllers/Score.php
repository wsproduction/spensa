<?php

class Score extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('score/index');
    }

}