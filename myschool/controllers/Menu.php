<?php

class Menu extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function pages() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $data = $this->model->selectPage();
            $list = array();
            $host = 'http://' . Web::getHost() . '/pages/load/';
            //$host = '#!/pages/load/';
            //$host = '';
            foreach ($data as $value) {
                $list[] = array(
                    'title' => $value['page_name'],
                    'url' => $host . $value['page_alias']
                );
            }
            echo json_encode($list);
        }
    }

}