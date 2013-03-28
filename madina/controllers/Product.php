<?php

class Product extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->protection(true);
        Src::plugin()->jQueryValidation();
        Src::plugin()->highChart();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Produk');
        $this->view->link_r = $this->content->setLink('product/read');
        $this->view->link_c = $this->content->setLink('product/add');
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

            foreach ($list_data AS $row) {

                $link_edit = URL::link($this->content->setLink('language/edit/' . $row['product_id']), 'Edit', false);

                $xml .= "<row id='" . $row['product_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['product_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['type_code'] . '-' . $row['product_code'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['product_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['type_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['category_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($row['product_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d/m/Y', strtotime($row['product_entry_update'])) . "]]></cell>";
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
        $param['name'] = $this->request->post('name');
        
        $res = array(false, $this->message->saveError());
        
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

}