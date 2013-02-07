<?php

class Contents extends Controller {

    private $prevId = 'prevPaging';
    private $pageId = 'pagePaging';
    private $nextId = 'nextPaging';
    private $maxId = 'maxPaging';

    public function __construct() {
        $this->model = Content::loadModel();
        $this->url = new URL();
        Session::init();
    }

    public function accessRight() {
        Session::init();
        if (!Session::get('loginStatus')) {
            Session::destroy();
            $url = $this->setLink('index');
            $this->url->redirect($url);
            exit;
        }
    }

    public function topMenu() {
        $html = '<ul id="navigation" class="dropdown">';

        $menu = $this->model->selectMenu(1, 1);
        $level1 = array();
        $level2 = array();
        $level3 = array();
        $level4 = array();
        foreach ($menu as $value) {
            if (Session::get('loginStatus')) {
                if ($value['is_protect']) {
                    switch ($value['level']) {
                        case 1 :$level1[] = $value;
                            break;
                        case 2 :$level2[] = $value;
                            break;
                        case 3 :$level3[] = $value;
                            break;
                        case 4 :$level4[] = $value;
                            break;
                    }
                }
            } else {
                if (!$value['is_protect']) {
                    switch ($value['level']) {
                        case 1 :$level1[] = $value;
                            break;
                        case 2 :$level2[] = $value;
                            break;
                        case 3 :$level3[] = $value;
                            break;
                        case 4 :$level4[] = $value;
                            break;
                    }
                }
            }
        }

        foreach ($level1 as $val_level1) {
            $html .= '<li>' . URL::link($this->setLink($val_level1['menu_link']), $val_level1['menu_title'], 'attach');

            // View Menu Level 2
            if ($this->countChildMenu($level2, $val_level1['menu_id']) > 0) {
                $html .= '<ul style="width: 285px;">';
                foreach ($level2 as $val_level2) {
                    if ($val_level2['menu_parent'] == $val_level1['menu_id']) {
                        $html .= '<li>' . URL::link($this->setLink($val_level2['menu_link']), $val_level2['menu_title'], 'attach');

                        // View Menu Leve 3
                        if ($this->countChildMenu($level3, $val_level2['menu_id']) > 0) {
                            $html .= '<ul style="width: 150px;">';
                            foreach ($level3 as $val_level3) {
                                if ($val_level3['menu_parent'] == $val_level2['menu_id']) {
                                    $html .= '<li>' . URL::link($this->setLink($val_level3['menu_link']), $val_level3['menu_title'], 'attach');

                                    // View Menu Leve 3
                                    if ($this->countChildMenu($level4, $val_level3['menu_id']) > 0) {
                                        $html .= '<ul style="width: 150px;">';
                                        foreach ($level4 as $val_level4) {
                                            if ($val_level4['menu_parent'] == $val_level3['menu_id']) {
                                                $html .= '<li>' . URL::link($this->setLink($val_level4['menu_link']), $val_level4['menu_title'], 'attach') . '</li>';
                                            }
                                        }
                                        $html .= '</ul>';
                                    }
                                    $html .= '</li>';
                                }
                            }
                            $html .= '</ul>';
                        }
                        $html .= '</li>';
                    }
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        /*
          $html .= '<li>';
          $html .= URL::link('#', 'Data Master', 'attach');
          $html .= '  <ul style="width: 180px;">';
          $html .= '      <li>' . URL::link('http://' . $house . '/ddc', 'DDC', 'attach') . '</li>';
          $html .= '      <li>' . URL::link('#', 'Buku', 'attach');
          $html .= '          <ul style="width: 150px;">';
          $html .= '              <li>' . URL::link('http://' . $house . '/jenis_buku', 'Jenis Buku', 'attach') . '</li>';
          $html .= '              <li>' . URL::link('http://' . $house . '/katalog_buku', 'Katalog Buku', 'attach') . '</li>';
          $html .= '          </ul>';
          $html .= '      </li>';
          $html .= '  </ul>';
          $html .= '</li>';
          $html .= '<li>' . URL::link('http://' . $house . '/login/stop', 'Logout', 'attach') . '</li>';
         */
        $html .= '</ul>';

        return $html;
    }

    public function countChildMenu($list, $parent) {
        $count = 0;
        foreach ($list as $value) {
            if ($value['menu_parent'] == $parent) {
                $count++;
            }
        }
        return $count;
    }

    public function setLink($val = '', $ssl = false) {

        if (Web::$childStatus) {
            $house = Web::$host . '/' . Web::$webAlias;
        } else {
            $house = Web::$host;
        }

        $protocol = 'http://';
        if ($ssl) {
            $protocol = 'https://';
        }
        $link = $protocol . $house . '/' . $val;
        if ($val == '#') {
            $link = '#';
        }
        return $link;
    }

    public function setParentLink($val = '', $ssl = false) {

        if (Web::$childStatus) {
            $house = Web::$host . '/apps/load/' . Web::$webAlias;
        } else {
            $house = Web::$host;
        }

        $protocol = 'http://';
        if ($ssl) {
            $protocol = 'https://';
        }
        $link = $protocol . $house . '/' . $val;
        if ($val == '#') {
            $link = '#';
        }
        return $link;
    }

    public function numberFormat($number = 0) {
        return number_format($number, 0, ',', '.');
    }

    public function monthList() {
        $list = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
        return $list;
    }

    public function monthName($id) {
        $list = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        return $list[$id - 1];
    }

    public function descProgressLearning($score, $mlc) {
        $desc = '';
        if (!is_null($score)) {
            if ($score > $mlc) {
                $desc = 'terlamapaui';
            } else if ($score == $mlc) {
                $desc = 'tercapai';
            } else if ($score < $mlc) {
                $desc = 'belum tercapai';
            }
        }
        return $desc;
    }

}