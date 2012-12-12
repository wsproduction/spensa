<?php

class Profile extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function me() {
        if ($this->method->isAjax()) {
            Session::init();
            $profile = $this->model->selectUserProfile(Session::get('user_id'));
            $photo_root = URL::getService() . '://' . Web::getHost() . '/web/src/' . Web::$webFolder . '/asset/upload/images/';

            $name = '-';
            $photo = '';
            
            if ($profile) {
                $myprofile = $profile[0];
                $photo = $myprofile['user_photo_profile'];

                if ($myprofile['isa_dbroot'] == 'employees') {
                    $employees_list = $this->model->selectEmployeesById($myprofile['user_references']);
                    $employees = $employees_list[0];
                    $name = $employees['employess_name'];
                } 
                
            }

            $json = array(
                'name' => $name,
                'thumbnail' => array(
                    'small' => $photo_root . 'thumbnail-small/' . $photo,
                    'big' => $photo_root . 'thumbnail-big/' . $photo)
            );

            echo json_encode($json);
        }
    }

}