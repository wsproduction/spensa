<?php

class Ddc extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar DDC (Dewey Decimal Classification Edition 22)');
        $this->view->link_r = $this->content->setLink('ddc/read');
        $this->view->link_c = $this->content->setLink('ddc/add');
        $this->view->link_d = $this->content->setLink('ddc/delete');
        $this->view->render('ddc/index');
    }

    public function add() {
        Web::setTitle('Add DDC');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $this->view->link_back = $this->content->setLink('ddc');
        $this->view->link_sub1 = $this->content->setLink('ddc/getSub1');
        $this->view->render('ddc/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit DDC');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('ddc');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;

            switch ($listData['ddc_level']) {
                case 2:
                    foreach ($this->model->selectSub1() as $value) {
                        $listSub1[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub1 = array($listSub1, $listData['ddc_main_parent']);
                    $this->view->link_sub2 = $this->content->setLink('ddc/getSub2');
                    break;
                case 3:
                    $this->view->link_sub2 = $this->content->setLink('ddc/getSub2');
                    foreach ($this->model->selectSub1() as $value) {
                        $listSub1[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub1 = array($listSub1, $listData['ddc_temp_parent']);

                    foreach ($this->model->selectSub2($listData['ddc_temp_parent']) as $value) {
                        $listSub2[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub2 = array($listSub2, $listData['ddc_main_parent']);
                    break;
            }
            $this->view->render('ddc/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
    }

    public function create() {
        if ($this->model->createSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

    public function read() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllDdc($page);
            $total = $this->model->countAllDdc();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $link_detail = URL::link($this->content->setLink('ddc/detail/' . $row['ddc_id']), 'Detail', false);
                $link_edit = URL::link($this->content->setLink('ddc/edit/' . $row['ddc_id']), 'Edit', false);

                $xml .= "<row id='" . $row['ddc_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['ddc_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['ddc_classification_number'] . "]]></cell>";
                
                if ($row['ddc_description'] == "") {
                    $xml .= "<cell><![CDATA[" . $row['ddc_title'] . "</div>]]></cell>";
                } else {
                    $xml .= "<cell><![CDATA[<div><b>" . $row['ddc_title'] . "</b></div><div>" . $row['ddc_description'] . "</div>]]></cell>";
                }
                
                $xml .= "<cell><![CDATA[" . $row['ddc_level'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_detail . " | " . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function update($id = 0) {
        if ($this->model->updateSave($id)) {
            $ket = array(1, 0, $this->message->saveSucces());
        } else {
            $ket = array(0, 0, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    public function delete() {
        $res = false;
        if ($this->model->delete()) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function getSub1() {
        $list = array();
        foreach ($this->model->selectSub1() as $value) {
            $list[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
        }

        Form::create('select', 'sub1');
        Form::tips('Chose Level DDC');
        Form::validation()->requaired();
        Form::option($list, ' ');
        Form::properties(array('link' => $this->content->setLink('ddc/getSub2')));
        $html = Form::commit('attach');

        echo json_encode($html);
    }

    public function getSub2() {
        $list = array();
        foreach ($this->model->selectSub2($_GET['id']) as $value) {
            $list[$value['ddc_id']] = $value['ddc_classification_number'] . ' ' . $value['ddc_title'];
        }

        Form::create('select', 'sub2');
        Form::tips('Chose Level DDC');
        Form::validation()->requaired();
        Form::option($list, ' ');
        $html = Form::commit('attach');

        echo json_encode($html);
    }

}