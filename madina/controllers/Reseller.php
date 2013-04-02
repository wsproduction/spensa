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

                $link_edit = URL::link($this->content->setLink('reseller/getdatareseller/' . $value['members_id']), 'Edit', false, array('class' => 'edit'));

                $gender = 'Perempuan';
                if ($value['members_gender'])
                    $gender = 'Laki-Laki';
                
                $status = 'Tidak Aktif';
                if ($value['members_status'])
                    $status = 'Aktif';
                
                $contact = '<b>Facebook :</b><br>' . $value['members_facebook'];
                $contact .= '<br><b>Twitter :</b><br>' . $value['members_twitter'];

                $xml .= "<row id='" . $value['members_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['members_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_nickname'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $gender . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_birthplace'] . ', ' . date('d-m-Y', strtotime($value['members_birthdate'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_last_education'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_jobs'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_phone_number'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_email'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $contact . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['members_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['members_entry_update'])) . "]]></cell>";
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

    public function getDataReseller($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectResellerById($id);
        if (count($list) > 0) {
            $value = $list[0];

            $data['members_id'] = $value['members_id'];
            $data['members_name'] = $value['members_name'];
            $data['members_nickname'] = $value['members_nickname'];
            $data['members_gender'] = $value['members_gender'];
            $data['members_address'] = $value['members_address'];
            $data['members_birthplace'] = $value['members_birthplace'];
            $data['members_birthdate'] = date('Y-n-j',  strtotime($value['members_birthdate']));
            $data['members_last_education'] = $value['members_last_education'];
            $data['members_jobs'] = $value['members_jobs'];
            $data['members_phone_number'] = $value['members_phone_number'];
            $data['members_email'] = $value['members_email'];
            $data['members_facebook'] = $value['members_facebook'];
            $data['members_twitter'] = $value['members_twitter'];
            $data['members_status'] = $value['members_status'];
            
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

}