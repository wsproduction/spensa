<?php

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();

        Session::init();
        /*if (Session::get('statusLogin') == false) {
            Session::destroy();
            $this->url->redirect('login');
            exit;
        }*/

        Src::plugin()->poshytip();
        Src::javascript('default.js');
    }

    public function index() {
        Web::title('Dashboard', true, '|');
        $this->view->render('Dashboard/index');
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