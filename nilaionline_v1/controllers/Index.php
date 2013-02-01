<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->link_score = $this->content->setParentLink('score');
        $this->view->render('index/index');
    }

}