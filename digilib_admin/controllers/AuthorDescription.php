<?php

class AuthorDescription extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Keterangan Pengarang');
        $this->view->link_r = $this->content->setLink('authordescription/read');
        $this->view->link_c = $this->content->setLink('authordescription/add');
        $this->view->link_d = $this->content->setLink('authordescription/delete');
        $this->view->render('authordescription/index');
    }

    public function add() {
        Web::setTitle('Tambah Keterangan Pengarang');
        $this->view->link_back = $this->content->setLink('authordescription');
        $this->view->render('authordescription/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Keterangan Pengarang');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('authordescription');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('authordescription/edit');
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
            $listData = $this->model->selectAllAuthorDescription($page);
            $total = $this->model->countAllAuthorDescription();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $link_edit = URL::link($this->content->setLink('authordescription/edit/' . $row['author_description_id']), 'Edit',false);

                $xml .= "<row id='" . $row['author_description_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['author_description_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['author_description_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['author_description_level'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($row['author_description_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($row['author_description_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . "]]></cell>";
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