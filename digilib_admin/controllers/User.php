<?php

class User extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
    }

    public function index() {
        Web::setTitle('Login');
        $this->view->render('index/index');
    }

    public function profile() {
        Web::setTitle('Edit Profile');
        $this->view->list_gender = $this->listGender();
        $user_info = $this->model->selectMyProfile();
        if (count($user_info)) {
            $dataEdit = $user_info[0];
            $this->view->dataEdit = $dataEdit;
        }
        
        $this->view->render('user/profile');
    }

    public function listGender() {
        $list = $this->model->selectAllGender();
        $gender = array();
        foreach ($list as $value) {
            $gender[$value['gender_id']] = $value['gender_title'];
        }
        return $gender;
    }
    
}