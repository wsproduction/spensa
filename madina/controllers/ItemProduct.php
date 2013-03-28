<?php

class ItemProduct extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Item Produk');

        $this->view->link_c = $this->content->setLink('product/create');
        $this->view->link_r = $this->content->setLink('product/read');
        $this->view->link_u = $this->content->setLink('product/update');
        $this->view->link_d = $this->content->setLink('product/delete');
        $this->view->link_type = $this->content->setLink('product/gettype');

        $this->view->option_category = $this->optionCategory();
        $this->view->render('product/index');
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

                $link_edit = URL::link($this->content->setLink('product/getdataproduct/' . $value['product_id']), 'Edit', false, array('class' => 'edit'));

                $status = 'Tidak Aktif';
                if ($value['product_status'])
                    $status = 'Aktif';

                $xml .= "<row id='" . $value['product_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $value['product_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['type_code'] . '-' . $value['product_code'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['product_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['type_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['category_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $value['product_description'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $status . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['product_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($value['product_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_edit . "]]></cell>";
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