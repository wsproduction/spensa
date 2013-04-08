<?php

class Orders extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
        Src::plugin()->jsAccounting();
    }

    public function index() {
        Web::setTitle('Daftar Pesanan');

        $this->view->link_c = $this->content->setLink('orders/create');
        $this->view->link_r = $this->content->setLink('orders/read');
        $this->view->link_u = $this->content->setLink('orders/update');
        $this->view->link_d = $this->content->setLink('orders/delete');
        $this->view->link_cart = $this->content->setLink('orders/readcart');
        $this->view->link_members_search = $this->content->setLink('orders/readmembers');
        $this->view->link_product_search = $this->content->setLink('orders/readproduct');
        $this->view->render('orders/index');
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

            $list_data = $this->model->selectAllOrders($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {

                $link_edit = URL::link($this->content->setLink('orders/getdataorder/' . $value['order_id']), 'Edit', false, array('class' => 'edit'));
                $link_detail = URL::link($this->content->setLink('orders/getdataorder/' . $value['order_id']), 'Keranjang Pesanan', false, array('class' => 'cart'));

                $status = 'Tidak Aktif';
                if ($value['order_status'])
                    $status = 'Aktif';

                $payment_status = 'Pending';
                if ($value['payment_status'])
                    $payment_status = 'Lunas';

                $shipping_status = 'Pending';
                if ($value['shipping_status'])
                    $shipping_status = 'Dikirim';

                $shipping_date = '';
                if (!empty($value['shipping_date'])) {
                    $shipping_date = date('d/m/Y', strtotime($value['shipping_date']));
                }

                $xml .= "<row id='" . $value['order_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['order_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['members_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $payment_status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['payment_type_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['payment_note'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['shipping_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $shipping_status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $shipping_date . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['shipping_courier'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['shipping_cost']) . "</span>]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['shipping_cost'] + $value['invoice']) . "</span>]]></cell>";
                $xml .= "<cell><![CDATA[" . $status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['order_note'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['order_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['order_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . ' | ' . $link_detail . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function create() {
        $param = array();
        $param['type'] = $this->request->post('type');
        $param['name'] = $this->request->post('name');
        $param['description'] = $this->request->post('description');
        $param['status'] = $this->request->post('status');

        $res = array(false, $this->message->saveError());
        if ($this->model->saveOrders($param)) {
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
        if ($this->model->updateOrders($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function delete() {
        $param = array();
        $param['id'] = $this->request->post('id');

        $res = false;
        if ($this->model->deleteOrders($param)) {
            $res = true;
        }

        echo json_encode($res);
    }

    public function readCart() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname', 'question_id');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('query', false);
            $param['qtype'] = $this->request->post('qtype', false);
            $param['order_id'] = $this->request->post('hide_order_id', 0);

            $list_data = $this->model->selectAllCart($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {
                
                $total = ($value['detail_price'] - ($value['detail_price'] * ($value['detail_discount']/100))) * $value['detail_order_quantity'];

                $xml .= "<row id='" . $value['detail_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['detail_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['type_code'] . '-' . $value['product_code'] . ' / ' . $value['type_name'] . " <br> <b>" . $value['product_name'] . ', ' . $value['size_description'] . "</b>]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['detail_price']) . "</span>]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['detail_discount'] . "%]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['detail_order_quantity'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($total) . "</span>]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readMembers() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('keyword_text', false);//$this->request->post('query', false);
            $param['qtype'] = $this->request->post('keyword_category', false);//$this->request->post('qtype', false);

            $list_data = $this->model->selectAllMembers($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {
               
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
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readProduct() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('keyword_text', false);//$this->request->post('query', false);
            $param['qtype'] = $this->request->post('keyword_category', false);//$this->request->post('qtype', false);

            $list_data = $this->model->selectAllMembers($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {
               
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
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function getDataOrder($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectOrderById($id);
        if (count($list) > 0) {
            $value = $list[0];

            $data['order_id'] = $value['order_id'];
            $data['order_note'] = $value['order_note'];
            $data['order_status'] = $value['order_status'];
            $data['order_entry'] = $value['order_entry'];
            $data['order_entry_update'] = $value['order_entry_update'];
            $data['payment_status'] = $value['payment_status'];
            $data['payment_note'] = $value['payment_note'];
            $data['shipping_address'] = $value['shipping_address'];
            $data['shipping_date'] = $value['shipping_date'];
            $data['shipping_courier'] = $value['shipping_courier'];
            $data['shipping_cost'] = $value['shipping_cost'];
            $data['members_id'] = $value['members_id'];
            $data['members_name'] = $value['members_name'];
            $data['payment_type_name'] = $value['payment_type_name'];
            $data['payment_type_id'] = $value['payment_type_id'];
            $data['invoice'] = $value['invoice'];
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

    public function getDataMembers() {
        
        $members_id = $this->request->post('members_id');
        
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectMembersById($members_id);
        if (count($list) > 0) {
            $value = $list[0];

            $data['members_id'] = $value['members_id'];
            $data['members_name'] = $value['members_name'];
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

}