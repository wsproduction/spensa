<?php

class User extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
        Src::plugin()->jQueryAlphaNumeric();
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

    public function account() {
        Web::setTitle('Account Setting');        
        $this->view->render('user/account');
    }

    public function listGender() {
        $list = $this->model->selectAllGender();
        $gender = array();
        foreach ($list as $value) {
            $gender[$value['gender_id']] = $value['gender_title'];
        }
        return $gender;
    }
    
    public function updateProfile() {
        if ($this->model->updateProfileSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }
    
    public function updateAccount() {
        if ($this->model->updateAccountSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }
    
    public function cekCurentPassword() {
        $res = false;
        if (count($this->model->selectCurentPasswrod()) == 1) {
            $res = true;
        }
        echo json_encode($res);
    }
    
}