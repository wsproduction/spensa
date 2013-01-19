<?php

class Catalogue extends Controller {

    private $dataAuthorDescriptionID;
    private $dataAuthorDescription;
    private $dataAuthor;
    private $dataAuthorTempDescriptionID;
    private $dataAuthorTempDescription;
    private $dataAuthorTemp;

    public function __construct() {
        parent::__construct();
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

                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];

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
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';

                $xml .= "<row id='" . $row['book_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . ".]]></cell>";
                $xml .= "<cell><![CDATA[" . $resource . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $fund . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_quantity'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $stock . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d.m.Y', strtotime($row['book_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d.m.Y', strtotime($row['book_entry_update'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[<a href='" . $link_detail . "'>Detail</a>]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }
}