<?php

class Recapitulation extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('recapitulation/index');
    }

}