<?php

class Contents extends Controller {

    public function __construct() {
        $this->model = Content::loadModel();
        Session::init();
    }
    
    public function accessRight(){
        Session::init();
        if (!Session::get('loginStatus')) {
            Session::destroy();
            $this->url->redirect('index');
            exit;
        }
    }

    public function topMenu() {
        $this->model->tes();

        if (Web::$childStatus) {
            $house = Web::$host . '/' . Web::$webAlias;
        } else {
            $house = Web::$host;
        }

        $html = '<ul id="navigation" class="dropdown">';

        if (Session::get('loginStatus') == true) {
            $html .= '<li>' . URL::link('http://' . $house . '/', 'Dashboard','attach') . '</li>';
            $html .= '  <li>';
            $html .= URL::link('#', 'Data Master','attach');
            $html .= '      <ul style="width: 180px;">';
            $html .= '          <li>' . URL::link('http://' . $house . '/ddc', 'DDC','attach') . '</li>';
            $html .= '          <li>' . URL::link('#', 'Buku','attach');
            $html .= '              <ul style="width: 150px;">';
            $html .= '                  <li>' . URL::link('http://' . $house . '/jenis_buku', 'Jenis Buku','attach') . '</li>';
            $html .= '                  <li>' . URL::link('http://' . $house . '/katalog_buku', 'Katalog Buku','attach') . '</li>';
            $html .= '              </ul>';
            $html .= '          </li>';
            $html .= '      </ul>';
            $html .= '   </li>';
            $html .= '   <li>' . URL::link('http://' . $house . '/login/stop', 'Logout','attach') . '</li>';
        } else {
            $html .= '   <li>' . URL::link('http://' . $house . '/login', 'Login','attach') . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

}