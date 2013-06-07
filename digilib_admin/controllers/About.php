<?php

class About extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
        Src::plugin()->jQueryAlphaNumeric();
    }

    public function index() {
        Web::setTitle('About');
        $this->view->render('about/index');
    }

    public function updateProfile() {
        if ($this->model->updateProfileSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

}