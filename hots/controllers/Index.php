<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('index/index');
    }

    public function cobabaca() {
        $file_handle = fopen("myfile", "r");
        while (!feof($file_handle)) {
            echo fgetss($file_handle);
        }
        fclose($file_handle);
    }

}