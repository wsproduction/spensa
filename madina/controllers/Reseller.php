<?php

class Reseller extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Reseller');

        $this->view->link_c = $this->content->setLink('reseller/create');
        $this->view->link_r = $this->content->setLink('reseller/read');
        $this->view->link_u = $this->content->setLink('reseller/update');
        $this->view->link_d = $this->content->setLink('reseller/delete');
        $this->view->link_type = $this->content->setLink('reseller/gettype');

        $this->view->option_category = $this->optionCategory();
        $this->view->option_date = $this->content->dayList();
        $this->view->option_moth = $this->content->monthList();
        $this->view->render('reseller/index');
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

            $list_data = $this->model->selectAllReseller($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {

                $link_edit = URL::link($this->content->setLink('reseller/getdatareseller/' . $value['reseller_id']), 'Edit', false, array('class' => 'edit'));

                $gender = 'Perempuan';
                if ($value['reseller_gender'])
                    $gender = 'Laki-Laki';
                
                $status = 'Tidak Aktif';
                if ($value['reseller_status'])
                    $status = 'Aktif';
                
                $contact = '<b>Facebook :</b><br>' . $value['reseller_facebook'];
                $contact .= '<br><b>Twitter :</b><br>' . $value['reseller_twitter'];

                $xml .= "<row id='" . $value['reseller_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['reseller_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_nickname'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $gender . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_birthplace'] . ', ' . date('d-m-Y', strtotime($value['reseller_birthdate'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_last_education'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_jobs'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_phone_number'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_email'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $contact . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['reseller_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['reseller_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function create() {
        $param = array();
        
        $param['fullname'] = $this->request->post('fullname');
        $param['nickname'] = $this->request->post('nickname');
        $param['gender'] = $this->request->post('gender');
        $param['address'] = $this->request->post('address');
        $param['birthplace'] = $this->request->post('birthplace');
        $param['birthdate'] = $this->request->post('year') . '-' . $this->request->post('month') . '-' . $this->request->post('day');
        $param['education'] = $this->request->post('education');
        $param['jobs'] = $this->request->post('jobs');
        $param['phone'] = $this->request->post('phone');
        $param['email'] = $this->request->post('email');
        $param['facebook'] = $this->request->post('facebook');
        $param['twitter'] = $this->request->post('twitter');
        $param['status'] = $this->request->post('status');

        $res = array(false, $this->message->saveError());
        if ($this->model->saveReseller($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }
    
    public function update() {
        $param = array();
        $param['id'] = $this->request->post('id');
        $param['fullname'] = $this->request->post('fullname');
        $param['nickname'] = $this->request->post('nickname');
        $param['gender'] = $this->request->post('gender');
        $param['address'] = $this->request->post('address');
        $param['birthplace'] = $this->request->post('birthplace');
        $param['birthdate'] = $this->request->post('year') . '-' . $this->request->post('month') . '-' . $this->request->post('day');
        $param['education'] = $this->request->post('education');
        $param['jobs'] = $this->request->post('jobs');
        $param['phone'] = $this->request->post('phone');
        $param['email'] = $this->request->post('email');
        $param['facebook'] = $this->request->post('facebook');
        $param['twitter'] = $this->request->post('twitter');
        $param['status'] = $this->request->post('status');

        $res = array(false, $this->message->saveError());
        if ($this->model->updateReseller($param)) {
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

    public function getDataReseller($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectResellerById($id);
        if (count($list) > 0) {
            $value = $list[0];

            $data['reseller_id'] = $value['reseller_id'];
            $data['reseller_name'] = $value['reseller_name'];
            $data['reseller_nickname'] = $value['reseller_nickname'];
            $data['reseller_gender'] = $value['reseller_gender'];
            $data['reseller_address'] = $value['reseller_address'];
            $data['reseller_birthplace'] = $value['reseller_birthplace'];
            $data['reseller_birthdate'] = date('Y-n-j',  strtotime($value['reseller_birthdate']));
            $data['reseller_last_education'] = $value['reseller_last_education'];
            $data['reseller_jobs'] = $value['reseller_jobs'];
            $data['reseller_phone_number'] = $value['reseller_phone_number'];
            $data['reseller_email'] = $value['reseller_email'];
            $data['reseller_facebook'] = $value['reseller_facebook'];
            $data['reseller_twitter'] = $value['reseller_twitter'];
            $data['reseller_status'] = $value['reseller_status'];
            
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

}