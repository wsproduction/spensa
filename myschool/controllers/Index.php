<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(false);
        Src::plugin()->jQueryValidation();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }
}