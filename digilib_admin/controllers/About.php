<?php

class About extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->elrte();
    }

    public function index() {
        Web::setTitle('Tentang Perpustakaan');
        $list = $this->model->selectAbout();
        if (count($list)) {
            $data = $list[0];
            $this->view->dataEdit = $data;
        }
        $this->view->render('about/index');
    }

    public function update() {
        if ($this->model->updateSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

}