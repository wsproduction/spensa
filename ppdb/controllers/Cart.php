<?php

class Cart extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo 'Hello World!';
    }

    public function create($val = 'No Name') {
        $list = $this->model->selectKategori();
        $html = '';
        foreach ($list as $value) {
            $html .= $value['category_id'] . ' ' . $value['category_name'] . '<br>';
        }
        
        $this->view->html_view = $html;        
        $this->view->render('cart/tampilan');
    }

}