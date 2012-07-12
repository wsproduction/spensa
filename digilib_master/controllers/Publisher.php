<?php

class Publisher extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();
        
        Src::plugin()->poshytip();
    }

    public function index() {
        Web::setTitle('List Publisher');
        $this->view->render('publisher/index');
    }

    public function create() {
        $this->model->addSave();
    }

    public function read() {
        $this->model->selectList();
    }

    public function update() {
        $this->model->selectList();
    }

    public function delete() {
        $this->model->delete();
    }

}