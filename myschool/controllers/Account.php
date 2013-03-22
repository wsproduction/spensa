<?php

class Account extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->passwordMeter();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('account/index');
    }

    public function changePassword() {
        if ($this->model->checkOldPassword()) {
            if ($this->model->savePassword()) {
                $res = array(1, $this->message->changePasswordSucces());
            } else {
                $res = array(0, $this->message->changePasswordError());
            }
        } else {
            $res = array(0, $this->message->changePasswordNotMach());
        }
        echo json_encode($res);
    }

}