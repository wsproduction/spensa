<?php

class Help extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }
    
    public function index() {
        Web::setTitle('Hots Help');
        $this->view->render('help/index');
    }

}