<?php

class Publisher extends Controller {

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
        Web::setTitle('List of Publishers');
        $this->view->link_r = $this->content->setLink('publisher/read');
        $this->view->link_c = $this->content->setLink('publisher/add');
        $this->view->link_d = $this->content->setLink('publisher/delete');
        $this->view->render('publisher/index');
    }

    public function add() {
        Web::setTitle('Add Data Publisher');
        $this->view->link_back = $this->content->setLink('publisher');
        $this->view->render('publisher/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Data Publisher');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('publisher');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('publisher/edit');
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
            $listData = $this->model->selectAllPublisher($page);
            $total = $this->model->countAllPublisher();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $link_detail = URL::link($this->content->setLink('publisher/detail/' . $row['publisher_id']), 'Detail', 'attach');
                $link_edit = URL::link($this->content->setLink('publisher/edit/' . $row['publisher_id']), 'Edit', 'attach');

                $xml .= "<row id='" . $row['publisher_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['publisher_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_description'] . "]]></cell>";
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

}