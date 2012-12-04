<?php

class Profile extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::title('Profile', true, '|');
        $this->view->render('Profile/index');
    }

}