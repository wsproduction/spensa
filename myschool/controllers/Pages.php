<?php

class Pages extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::css('style_pages');
        Src::plugin()->flexiGrid();
    }

    public function index() {
        $this->view->render('pages/404');
    }

    /* LOADER PAGES */

    public function load($pa = null) {
        $this->view->page_alias = $pa;
        $this->view->page_info = $this->model->selectPagesByAlias($pa);
        if (count($this->view->page_info) > 0) {
            Src::plugin()->jQuerySelectBox();
            $this->view->page_menu = $this->splitMenu($pa);
            $this->view->render('pages/index');
        } else {
            $this->view->render('pages/404');
        }
    }

    public function splitMenu($pa) {
        $list = $this->model->selectPagesMenuByAlias($pa);
        $level1 = array();
        $level2 = array();
        $level3 = array();
        $level4 = array();
        foreach ($list as $value) {
            switch ($value['menu_level']) {
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
        return array($level1, $level2, $level3, $level4);
    }

}