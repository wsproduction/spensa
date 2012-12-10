<?php

class Menu extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function Apps() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $data = $this->model->selectPage();
            $list = array();
            $host = 'http://' . Web::getHost() . '/apps/load/';
            //$host = '#!/pages/load/';
            //$host = '';
            foreach ($data as $value) {
                $list[] = array(
                    'title' => $value['apps_name'],
                    'url' => $host . $value['apps_alias']
                );
            }
            echo json_encode($list);
        }
    }

}