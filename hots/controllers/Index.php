<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }
    
    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }

}