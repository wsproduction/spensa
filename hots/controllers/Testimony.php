<?php

class Testimony extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }
    
    public function index() {
        Web::setTitle('Testimony');
        $this->view->render('testimony/index');
    }

}