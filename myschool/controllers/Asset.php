<?php

class Asset extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function app() {
        if ($this->method->isAjax()) {
            $json = array('name' => Web::$webName,
                'folder' => Web::$webFolder,
                'alias' => Web::$webAlias,
                'template' => array('name' => Web::$webTemplate, 'css' => 'layout.css'));
            echo json_encode($json);
        }
    }

}