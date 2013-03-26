<?php

class Product extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
    }

    public function index() {
        Web::setTitle('Login');
        $this->view->render('product/index');
    }

}