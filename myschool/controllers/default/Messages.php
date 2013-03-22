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

    public function changePasswordSucces() {
        return Message::render('message/change_password_succes');
    }

    public function changePasswordError() {
        return Message::render('message/change_password_error');
    }

    public function changePasswordNotMach() {
        return Message::render('message/change_password_not_mach');
    }

}