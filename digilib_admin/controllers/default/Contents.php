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
            $html .= '<li>' . URL::link($this->setLink($val_level1['menu_link']), $val_level1['menu_title'], false);

            // View Menu Level 2
            if ($this->countChildMenu($level2, $val_level1['menu_id']) > 0) {
                $html .= '<ul style="width: 285px;">';
                foreach ($level2 as $val_level2) {
                    if ($val_level2['menu_parent'] == $val_level1['menu_id']) {
                        $html .= '<li>' . URL::link($this->setLink($val_level2['menu_link']), $val_level2['menu_title'], false);

                        // View Menu Leve 3
                        if ($this->countChildMenu($level3, $val_level2['menu_id']) > 0) {
                            $html .= '<ul style="width: 150px;">';
                            foreach ($level3 as $val_level3) {
                                if ($val_level3['menu_parent'] == $val_level2['menu_id']) {
                                    $html .= '<li>' . URL::link($this->setLink($val_level3['menu_link']), $val_level3['menu_title'], false);

                                    // View Menu Leve 3
                                    if ($this->countChildMenu($level4, $val_level3['menu_id']) > 0) {
                                        $html .= '<ul style="width: 150px;">';
                                        foreach ($level4 as $val_level4) {
                                            if ($val_level4['menu_parent'] == $val_level3['menu_id']) {
                                                $html .= '<li>' . URL::link($this->setLink($val_level4['menu_link']), $val_level4['menu_title'], false) . '</li>';
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
          $html .= URL::link('#', 'Data Master', false);
          $html .= '  <ul style="width: 180px;">';
          $html .= '      <li>' . URL::link('http://' . $house . '/ddc', 'DDC', false) . '</li>';
          $html .= '      <li>' . URL::link('#', 'Buku', false);
          $html .= '          <ul style="width: 150px;">';
          $html .= '              <li>' . URL::link('http://' . $house . '/jenis_buku', 'Jenis Buku', false) . '</li>';
          $html .= '              <li>' . URL::link('http://' . $house . '/katalog_buku', 'Katalog Buku', false) . '</li>';
          $html .= '          </ul>';
          $html .= '      </li>';
          $html .= '  </ul>';
          $html .= '</li>';
          $html .= '<li>' . URL::link('http://' . $house . '/login/stop', 'Logout', false) . '</li>';
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

    public function customPagingId($prevId = '', $pageId = '', $nextId = '', $maxId = '') {
        if ($prevId != '')
            $this->prevId = $prevId;
        if ($pageId != '')
            $this->pageId = $pageId;
        if ($nextId != '')
            $this->nextId = $nextId;
        if ($maxId != '')
            $this->maxId = $maxId;
    }

    public function paging($colspan = 1, $count = 1, $current = 1) {
        $html = '<tr class="paging">';
        $html .= '  <td colspan="' . $colspan . '" class="first">';
        $html .= '      <div class="left">';

        Form::create('button', $this->prevId);
        Form::value('Prev');
        Form::style('action_prev');
        $html .= Form::commit(false);

        $num = array();
        for ($i = 1; $i <= $count; $i++) {
            $num[$i] = $i;
        }

        Form::create('select', $this->pageId);
        Form::option($num, '', $current);
        $html .= Form::commit(false);

        Form::create('hidden', $this->maxId);
        Form::value($i);
        $html .= Form::commit(false);

        Form::create('button', $this->nextId);
        Form::value('Next');
        Form::style('action_next');
        $html .= Form::commit(false);

        $html .= '      </div>';
        $html .= '      <div class="right">';
        $html .= '          Page ' . $current . ' of ' . $count;
        $html .= '      </div>';
        $html .= '  </td>';
        $html .= '</tr>';
        return $html;
    }

    public function numberFormat($number = 0) {
        return number_format($number, 0, ',', '.');
    }
    
    public function monthName($id) {
        $list = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        return $list[$id - 1];
    }
    
    public function parsingAuthor($bookid) {
        $authorlist = $this->model->selectAuthorByBookId($bookid);
        $data = array();
        foreach ($authorlist as $row) {
            $data[$row['author_description_id']]['title'] = $row['author_description_title'];
            $data[$row['author_description_id']]['name'][] = array('first_name' => $row['author_firstname'], 'last_name' => $row['author_lastname']);
        }
        return $data;
    }

    public function callNumberExtention($author, $title) {

        if (count($author) > 0) {
            if (isset($author[1]['name'])) {
                if (count($author[1]['name']) > 3) {
                    $isuse = 'title';
                } else {
                    $isuse = 'name';
                }
            } else {
                $isuse = 'title';
            }
        } else {
            $isuse = 'title';
        }


        $extendtion = ' / ';
        if ($isuse == 'title') {
            $extendtion .= strtoupper(substr($title, 0, 3));
        } else {
            $extendtion .= strtoupper(substr($author[1]['name'][0]['first_name'], 0, 3));
            $extendtion .= ' / ' . strtolower(substr($title, 0, 1));
        }

        return $extendtion;
    }

}