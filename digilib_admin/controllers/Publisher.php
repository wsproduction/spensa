<?php

class Publisher extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Penerbit');
        $this->view->link_r = $this->content->setLink('publisher/read');
        $this->view->link_c = $this->content->setLink('publisher/add');
        $this->view->link_d = $this->content->setLink('publisher/delete');
        $this->view->render('publisher/index');
    }

    public function add() {
        Web::setTitle('Tambah Data Penerbit');
        $this->view->link_back = $this->content->setLink('publisher');
        $this->view->option_department = $this->optionDepartment();
        $this->view->option_country = $this->optionCountry();
        $this->view->link_province = $this->content->setLink('publisher/getprovince');
        $this->view->link_city = $this->content->setLink('publisher/getcity');
        $this->view->link_r_office = $this->content->setLink('publisher/readoffice');
        $this->view->link_d_office = $this->content->setLink('publisher/deleteoffice');
        $this->view->link_add_office = $this->content->setLink('publisher/addofficetemp');
        $this->view->render('publisher/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Data Penerbit');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('publisher');
        $this->view->option_department = $this->optionDepartment();
        $this->view->option_country = $this->optionCountry();
        $this->view->link_province = $this->content->setLink('publisher/getprovince');
        $this->view->link_city = $this->content->setLink('publisher/getcity');
        $this->view->link_r_office = $this->content->setLink('publisher/readoffice');
        $this->view->link_d_office = $this->content->setLink('publisher/deleteoffice');
        $this->view->link_add_office = $this->content->setLink('publisher/addofficetemp');

        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->model->loadPublisherOfficeTemp($id);
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

                $link_detail = URL::link($this->content->setLink('publisher/detail/' . $row['publisher_id']), 'Detail', false);
                $link_edit = URL::link($this->content->setLink('publisher/edit/' . $row['publisher_id']), 'Edit', false);

                $xml .= "<row id='" . $row['publisher_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['publisher_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_description'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($row['publisher_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($row['publisher_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_detail . " | " . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readOffice() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllOffice($page);
            $total = $this->model->countAllOffice();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {
                $xml .= "<row id='" . $row['publisher_office_temp_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office_temp_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office_department_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office_temp_address'] . "]]></cell>";
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
        $id = $this->method->post('id', 0);
        if ($this->model->delete($id)) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function deleteOffice() {
        $res = false;
        $id = $this->method->post('id', 0);
        if ($this->model->deleteOffice($id)) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function optionDepartment() {
        $option = array();
        $list = $this->model->selectDepartment();
        foreach ($list as $row) {
            $option[$row['publisher_office_department_id']] = $row['publisher_office_department_name'];
        }
        return $option;
    }

    public function optionCountry() {
        $option = array();
        $list = $this->model->selectCountry();
        foreach ($list as $row) {
            $option[$row['country_id']] = $row['country_name'];
        }
        return $option;
    }

    public function optionProvince($id) {
        $option = array();
        $list = $this->model->selectProvinceByCountryId($id);
        foreach ($list as $row) {
            $option[$row['province_id']] = $row['province_name'];
        }
        return $option;
    }

    public function getProvince() {
        $countryid = $this->method->get('id');
        $list = $this->optionProvince($countryid);
        $option = '<option value=""></option>';
        foreach ($list as $key => $value) {
            $option .= '<option value="' . $key . '">' . $value . '</option>';
        }
        echo json_encode($option);
    }

    public function optionCity($id) {
        $option = array();
        $list = $this->model->selectCityByProvinceId($id);
        foreach ($list as $row) {
            $option[$row['city_id']] = $row['city_name'];
        }
        return $option;
    }

    public function getCity() {
        $provinceid = $this->method->get('id');
        $list = $this->optionCity($provinceid);
        $option = '<option value=""></option>';
        foreach ($list as $key => $value) {
            $option .= '<option value="' . $key . '">' . $value . '</option>';
        }
        echo json_encode($option);
    }

    public function addOfficeTemp() {
        if ($this->model->saveOfficeTemp()) {
            $res = true;
        } else {
            $res = false;
        }
        echo json_encode($res);
    }

}