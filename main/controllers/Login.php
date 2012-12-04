<?php

class Login extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();
        $this->view->title = 'WSFramework | Login';
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
    }
    
    public function index() {
        
        Web::title('Login', true, '|');
        
        if (Session::get('statusLogin') == true) {
            $this->url->redirect('dashboard');
            exit;
        }
        $this->view->render('Login/index');
    }
    
    public function run(){
        $this->model->login();
    }
    
    public function stop(){
        Session::destroy();
        header('location:../login');
    }
    
    public function cekemail() {
        
        echo json_encode($_POST['username']);
    }

}