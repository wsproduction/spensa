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

                $link_edit = URL::link($this->content->setLink('schoolprofile/getdataschoolprofile/' . $value['school_id']), 'Edit', false, array('class' => 'edit'));

                $xml .= "<row id='" . $value['school_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['school_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['school_nss'] . "]]></cell>";
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
        $param['nss'] = $this->request->post('nss');
        $param['school_name'] = $this->request->post('school_name');
        $param['address'] = $this->request->post('address');
        $param['rt'] = $this->request->post('rt');
        $param['rw'] = $this->request->post('rw');
        $param['village'] = $this->request->post('village');
        $param['sub_distric'] = $this->request->post('sub_distric');
        $param['distric'] = $this->request->post('distric');
        $param['province'] = $this->request->post('province');
        $param['zip_code'] = $this->request->post('zip_code');
        $param['phone'] = $this->request->post('phone');

        $res = array(false, $this->message->saveError());
        if ($this->model->saveSchoolProfile($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }
    
    public function update() {
        $param = array();
        $param['id'] = $this->request->post('id');
        $param['nss'] = $this->request->post('nss');
        $param['school_name'] = $this->request->post('school_name');
        $param['address'] = $this->request->post('address');
        $param['rt'] = $this->request->post('rt');
        $param['rw'] = $this->request->post('rw');
        $param['village'] = $this->request->post('village');
        $param['sub_distric'] = $this->request->post('sub_distric');
        $param['distric'] = $this->request->post('distric');
        $param['province'] = $this->request->post('province');
        $param['zip_code'] = $this->request->post('zip_code');
        $param['phone'] = $this->request->post('phone');

        $res = array(false, $this->message->saveError());
        if ($this->model->updateSchoolProfile($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function delete() {
        $param = array();
        $param['id'] = $this->request->post('id');

        $res = false;
        if ($this->model->deleteSchoolProfile($param)) {
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

    public function getDataSchoolProfile($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectSchoolProfileById($id);
        if (count($list) > 0) {
            $value = $list[0];
            $data['school_id'] = $value['school_id'];
            $data['school_nss'] = $value['school_nss'];
            $data['school_name'] = $value['school_name'];
            $data['school_address'] = $value['school_address'];
            $data['school_rt'] = $value['school_rt'];
            $data['school_rw'] = $value['school_rw'];
            $data['school_village'] = $value['school_village'];
            $data['school_subdistric'] = $value['school_subdistric'];
            $data['school_distric'] = $value['school_distric'];
            $data['school_province'] = $value['school_province'];
            $data['school_zipcode'] = $value['school_zipcode'];
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

}