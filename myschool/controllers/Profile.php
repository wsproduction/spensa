<?php

class Profile extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function me() {
        if ($this->method->isAjax()) {
            Session::init();
            Session::get('user_id');
            
            $profile = $this->model->selectMyProfile();
            
            $json = array('name' => 'Warman Suganda',
                'first_name' => 'Warman',
                'last_name' => 'Suganda',
                'thumbnail' => array('small' => 'default-thumbnail-small.jpg', 'big' => 'default-thumbnail-big.png'));
            echo json_encode($json);
        }
    }

}