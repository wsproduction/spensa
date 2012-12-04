<?php

class Registration extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        if (Session::get('statusLogin') == true) {
            $this->url->redirect('dashboard');
            exit;
        }

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->passwordMeter();
        Src::css('registration.css');
    }

    public function index() {
        Web::title('Registration', true, '|');
        $this->view->render('Registration/index');
    }

    public function store() {
        Web::title('Store Registration', true, '|');
        $this->view->render('Registration/store');
    }

    public function customer($param = null) {
        if (isset($param)) {
            if ($param == 'run') {
                print_r($this->model->runCustomer());
            }
        } else {
            Web::title('Customer Registration', true, '|');
            $this->view->genderList = $this->model->getGender();
            $this->view->countryList = $this->model->dsCountry();
            $this->view->render('Registration/customer');
        }
    }

    public function cekEmail() {
        echo json_encode($this->model->getEmail());
    }

    public function getDistrict() {
        $dataList = $this->model->getDistrict($_GET['id']);
        $out = '<option value="">-- Pilih --</option>';
        foreach ($dataList as $value) {
            $out .= '<option value="' . $value->district_id . '">' . $value->district_name . '</option>';
        }
        echo json_encode($out);
    }

}