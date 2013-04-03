<?php

class Itemproduct extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Item Produk');

        $this->view->link_c = $this->content->setLink('itemproduct/create');
        $this->view->link_r = $this->content->setLink('itemproduct/read');
        $this->view->link_u = $this->content->setLink('itemproduct/update');
        $this->view->link_d = $this->content->setLink('itemproduct/delete');
        $this->view->link_option = $this->content->setLink('itemproduct/getoption');

        $this->view->option_category = $this->optionCategory();
        $this->view->render('itemproduct/index');
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

                $link_edit = URL::link($this->content->setLink('itemproduct/getdataitemproduct/' . $value['item_id']), 'Edit', false, array('class' => 'edit'));
                
                $status = 'Tidak Aktif';
                if ($value['item_status'])
                    $status = 'Aktif';
                
                $xml .= "<row id='" . $value['item_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['item_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['type_code'] . '-' . $value['product_code'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['product_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['type_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['category_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['size_description'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['item_stock'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<span style='float:left;'>Rp</span><span style='float:right;'>" . $this->content->numberFormat($value['item_price']) . "</span>]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['item_discount'] . "%]]></cell>";
                $xml .= "<cell><![CDATA[" . $status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['item_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['item_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function create() {
        $param = array();
        
        $param['product'] = $this->request->post('name');
        $param['size'] = $this->request->post('size');
        $param['stock'] = $this->request->post('stock');
        $param['price'] = $this->request->post('price');
        $param['discount'] = $this->request->post('discount');
        $param['status'] = $this->request->post('status');

        $res = array(false, $this->message->saveError());
        if ($this->model->saveItemProduct($param)) {
            $res = array(true, $this->message->saveSucces());
        }

        echo json_encode($res);
    }

    public function update() {
        $param = array();
        
        $param['id'] = $this->request->post('id');
        $param['product'] = $this->request->post('name');
        $param['size'] = $this->request->post('size');
        $param['stock'] = $this->request->post('stock');
        $param['price'] = $this->request->post('price');
        $param['discount'] = $this->request->post('discount');
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
        if ($this->model->deleteItemProduct($param)) {
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

    public function optionSize($category_id) {
        $option = array();
        $list = $this->model->selectSizeByCategory($category_id);
        foreach ($list as $value) {
            $option[$value['aggregation_id']] = $value['size_description'];
        }
        return $option;
    }

    public function optionProduct($type_id) {
        $option = array();
        $list = $this->model->selectProductByType($type_id);
        foreach ($list as $value) {
            $option[$value['product_id']] = $value['type_code'] . '-' . $value['product_code'] . ' ' . $value['product_name'];
        }
        return $option;
    }
    
    public function getOption() {
        $data_id = $this->request->post('data');
        $get = $this->request->post('get');
        if ($get == 'type') {
            $option = $this->optionType($data_id);
        } else if ($get == 'size') {
            $option = $this->optionSize($data_id);
        } else if ($get == 'product') {
            $option = $this->optionProduct($data_id);
        }
        
        $result = '<option></option>';
        foreach ($option as $key => $value) {
            $result .= '<option value="' . $key . '">' . $value . '</option>';
        }
        echo json_encode($result);
    }
    
    public function getDataItemProduct($id) {
        $data = array();
        $result = array(false, $data);

        $list = $this->model->selectItemProductById($id);
        if (count($list) > 0) {
            $value = $list[0];

            $option_product_type = '<option></option>';
            foreach ($this->optionType($value['category_id']) as $k => $v) {
                $option_product_type .= '<option value="' . $k . '">' . $v . '</option>';
            }

            $option_product_size = '<option></option>';
            foreach ($this->optionSize($value['category_id']) as $k => $v) {
                $option_product_size .= '<option value="' . $k . '">' . $v . '</option>';
            }

            $option_product = '<option></option>';
            foreach ($this->optionProduct($value['product_type']) as $k => $v) {
                $option_product .= '<option value="' . $k . '">' . $v . '</option>';
            }

            $data['item_id'] = $value['item_id'];
            $data['product_type'] = $value['product_type'];
            $data['option_product_type'] = $option_product_type;
            $data['size_id'] = $value['size_id'];
            $data['option_product_size'] = $option_product_size;
            $data['product_id'] = $value['product_id'];
            $data['option_product'] = $option_product;
            $data['category_id'] = $value['category_id'];
            $data['item_stock'] = $value['item_stock'];
            $data['item_price'] = $value['item_price'];
            $data['item_discount'] = $value['item_discount'];
            $data['item_status'] = $value['item_status'];
            
            $result = array(true, $data);
        }
        echo json_encode($result);
    }

}