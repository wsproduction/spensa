<?php

class Account extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('account/index');
    }
}