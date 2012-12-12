<?php

class Apps extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
    }

    public function index() {
        $this->view->render('apps/404');
    }

    /* LOADER Apps */

    public function load($apps_alias = null) {
        
        Src::css('style_apps');
        Src::plugin()->jQueryAddress();
        Src::plugin()->flexiGrid();
        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->jQueryBase64();
        
        $this->view->apps_alias = $apps_alias;
        $apps_info = $this->model->selectAppsByAlias($apps_alias);
        if (count($apps_info) > 0) {
            Src::plugin()->jQuerySelectBox();
            $this->view->apps_info = $apps_info;
            $this->view->apps_menu = $this->splitMenu($apps_info[0]['apps_id']);
            $this->view->render('apps/index');
        } else {
            $this->view->render('apps/404');
        }
    }

    public function splitMenu($pa) {
        $list = $this->model->selectAppsMenuByAlias($pa);
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