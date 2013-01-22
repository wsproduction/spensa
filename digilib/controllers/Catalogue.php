<?php

class Catalogue extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->view->topMenu = $this->content->topMenu();
        
        Src::plugin()->flexiGrid();
    }
    
    public function detail($id = 0) {
        Web::setTitle('Detail Catalogue');
        $list = $this->model->selectBookById($id);
        if (count($list) > 0) {
            $data = $list[0];
            $author = $this->content->parsingAuthor($id);

            $this->view->id = $id;
            $this->view->data = $data;
            $this->view->language_list = $this->model->selectBookLanguageByBookId($id);
            $this->view->ddc_list = $this->model->selectDdcParent($data['ddc_parent']);
            $this->view->author_list = $author;
            $this->view->callnumber_extention = $this->content->callNumberExtention($author, $data['book_title']);

            $this->view->link_back = $this->content->setLink('index/index');
            $this->view->link_print_barcode = $this->content->setLink('catalogue/printBarcode/' . $id);
            $this->view->link_print_label = $this->content->setLink('catalogue/printLabel/' . $id);
            $this->view->link_r_collection = $this->content->setLink('catalogue/readcollectionbook/' . $id);
            $this->view->link_p_collection = $this->content->setLink('catalogue/addprintbarcode');
            $this->view->link_pl_collection = $this->content->setLink('catalogue/printlistbarcode');
            $this->view->render('index/detail');
        }
    }
    
    public function read() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllCatalogue($page);
            $total = $this->model->countAllCatalogue();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";


            foreach ($listData as $row) {

                $link_detail = $this->content->setLink('catalogue/detail/' . $row['book_id']);

                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);

                $resource = '-';
                if (!empty($row['resource'])) {
                    $resource = $row['resource'];
                }

                $fund = '-';
                if (!empty($row['fund'])) {
                    $fund = $row['fund'];
                }

                $stock = $row['book_quantity'] - $row['count_borrowed'];

                $description  = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';

                $xml .= "<row id='" . $row['book_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . ".]]></cell>";
                $xml .= "<cell><![CDATA[" . $resource . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $fund . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_quantity'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $stock . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrow_count'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<a href='" . $link_detail . "'>Detail</a>]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }
    
    public function readCollectionBook($id = 0) {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllCollection($id, $page);
            $total = $this->model->countAllCollection($id);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {
                $last_borrowed = '-';
                if (!empty($row['last_borrowed']))
                    $last_borrowed = date('d.m.Y', strtotime($row['last_borrowed']));

                $xml .= "<row id='" . $row['book_register_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_register_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_condition'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['total_borrowed'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $last_borrowed . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d.m.Y', strtotime($row['book_entry'])) . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }
}