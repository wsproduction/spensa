<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->topMenu = $this->content->topMenu();
        
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Data Buku');
        
        $this->view->link_r = $this->content->setLink('catalogue/read');        
        $this->view->render('index/index');
    }

}