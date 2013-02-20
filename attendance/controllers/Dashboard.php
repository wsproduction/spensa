<?php

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        
        Src::plugin()->poshytip();
        Src::plugin()->highChart();
    }

    public function index() {
        Web::setTitle('Beranda');
        $this->view->render('dashboard/index');
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