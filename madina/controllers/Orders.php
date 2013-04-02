<?php

class Orders extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Pesanan');

        $this->view->link_c = $this->content->setLink('orders/create');
        $this->view->link_r = $this->content->setLink('orders/read');
        $this->view->link_u = $this->content->setLink('orders/update');
        $this->view->link_d = $this->content->setLink('orders/delete');
        $this->view->link_cart = $this->content->setLink('orders/readcart');
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

            $list_data = $this->model->selectAllProduct($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {

                $link_edit = URL::link($this->content->setLink('orders/getdataorder/' . $value['oder_id']), 'Edit', false, array('class' => 'edit'));
                $link_detail = URL::link($this->content->setLink('orders/getcart/' . $value['oder_id']), 'Keranjang Pesanan', false, array('class' => 'cart'));

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

                $xml .= "<row id='" . $value['oder_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['oder_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $payment_status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['payment_type_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['payment_note'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['shipping_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $shipping_status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $shipping_date . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['shipping_courier'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['shipping_cost']) . "</span>]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['shipping_cost']) . "</span>]]></cell>";
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
        if ($this->model->saveProduct($param)) {
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
    
    public function readcart() {
        if ($this->method->isAjax()) {

            $param = array();
            $param['page'] = $this->request->post('page', 1);
            $param['rp'] = $this->request->post('rp', 10);
            $param['sortname'] = $this->request->post('sortname', 'question_id');
            $param['sortorder'] = $this->request->post('sortorder', 'desc');
            $param['query'] = $this->request->post('query', false);
            $param['qtype'] = $this->request->post('qtype', false);

            $list_data = $this->model->selectAllCart($param);
            $total = count($list_data);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>" . $param['page'] . "</page>";
            $xml .= "<total>" . $total . "</total>";

            foreach ($list_data AS $value) {

                $link_edit = URL::link($this->content->setLink('orders/getdataorder/' . $value['oder_id']), 'Edit', false, array('class' => 'edit'));
                $link_detail = URL::link($this->content->setLink('orders/getcart/' . $value['oder_id']), 'Keranjang Pesanan', false, array('class' => 'cart'));

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

                $xml .= "<row id='" . $value['oder_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['oder_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['reseller_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $payment_status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['payment_type_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['payment_note'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['shipping_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $shipping_status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $shipping_date . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['shipping_courier'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['shipping_cost']) . "</span>]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['shipping_cost']) . "</span>]]></cell>";
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
}