<?php

class Messages extends Controller {

    public function __construct() {
        $this->model = Message::loadModel();
    }
    
    public function pageNotFound() {
        return Message::render('message/pnf');
    }
    
    public function saveError() {
        return Message::render('message/save_error');
    }
    
    public function saveSucces() {
        return Message::render('message/save_succes');
    }
    
    public function loginError() {
        return Message::render('message/login_error');
    }
    
    public function dataNotFound() {
        return Message::render('message/data_not_found');
    }
    
    public function tesModel() {
        $this->model->tes();
    }
}