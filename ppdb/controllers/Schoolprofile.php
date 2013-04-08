<?php

class Schoolprofile extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Profile Sekolah');

        $this->view->link_c = $this->content->setLink('schoolprofile/create');
        $this->view->link_r = $this->content->setLink('schoolprofile/read');
        $this->view->link_u = $this->content->setLink('schoolprofile/update');
        $this->view->link_d = $this->content->setLink('schoolprofile/delete');
        $this->view->link_type = $this->content->setLink('schoolprofile/gettype');
        $this->view->render('schoolprofile/index');
    }

    public function read() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname', 'question_id');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('query', false);
            $param['qtype'] = $this->request->post('qtype', false);

            $list_data = $this->model->selectAllSchool($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {

                $link_edit = URL::link($this->content->setLink('schoolprofile/getdataschoolprofile/' . $value['school_npsn']), 'Edit', false, array('class' => 'edit'));

                $xml .= "<row id='" . $value['school_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['school_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_npsn'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_rt'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_rw'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_village'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_subdistric'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_distric'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_zipcode'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_phone'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['school_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['school_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function create() {
        $param = array();
        $param['npsn'] = $this->request->post('npsn');
        $param['school_name'] = $this->request->post('school_name');
        $param['address'] = $this->request->post('address');
        $param['rt'] = $this->request->post('rt');
        $param['rw'] = $this->request->post('rw');
        $param['vilage'] = $this->request->post('vilage');
        $param['sub_distric'] = $this->request->post('sub_distric');
        $param['distric'] = $this->request->post('distric');
        $param['province'] = $this->request->post('province');
        $param['zip_code'] = $this->request->post('zip_code');

        $res = array(false, $this->message->saveError());
        if ($this->model->saveSchoolProfile($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }
    
    public function update() {
        $param = array();
        $param['id'] = $this->request->post('id');
        $param['type'] = $this->request->post('type');
        $param['name'] = $this->request->post('name');
        $param['description'] = $this->request->post('description');
        $param['status'] = $this->request->post('status');

        $res = array(false, $this->message->saveError());
        if ($this->model->updateProduct($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function delete() {
        $param = array();
        $param['id'] = $this->request->post('id');

        $res = false;
        if ($this->model->deleteProduct($param)) {
            $res = true;
        }

        echo json_encode($res);
    }

    public function optionCategory() {
        $option = array();
        $list = $this->model->selectAllCategory();
        foreach ($list as $value) {
            $option[$value['category_id']] = $value['category_name'];
        }
        return $option;
    }

    public function optionType($category_id) {
        $option = array();
        $list = $this->model->selectTypeByCategory($category_id);
        foreach ($list as $value) {
            $option[$value['aggregation_id']] = $value['type_code'] . ' - ' . $value['type_name'];
        }
        return $option;
    }

    public function getType() {
        $category_id = $this->request->post('data');
        $option = $this->optionType($category_id);
        $result = '<option></option>';
        foreach ($option as $key => $value) {
            $result .= '<option value="' . $key . '">' . $value . '</option>';
        }
        echo json_encode($result);
    }

    public function getDataProduct($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectProductById($id);
        if (count($list) > 0) {
            $value = $list[0];

            $option_product_type = '<option></option>';
            foreach ($this->optionType($value['aggregation_category']) as $k => $v) {
                $option_product_type .= '<option value="' . $k . '">' . $v . '</option>';
            }

            $data['product_id'] = $value['product_id'];
            $data['product_type'] = $value['product_type'];
            $data['option_product_type'] = $option_product_type;
            $data['product_code'] = $value['product_code'];
            $data['product_name'] = $value['product_name'];
            $data['product_description'] = $value['product_description'];
            $data['product_status'] = $value['product_status'];
            $data['aggregation_category'] = $value['aggregation_category'];
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

}