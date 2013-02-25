<?php

class Holidays extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
        Src::plugin()->jQueryMultiSelect();
    }

    public function index() {
        Web::setTitle('Daftar Hari Libur');
        $this->view->link_r = $this->content->setLink('holidays/read');
        $this->view->link_c = $this->content->setLink('holidays/add');
        $this->view->link_d = $this->content->setLink('holidays/delete');
        $this->view->option_month = $this->optionMonth();
        $this->view->option_year = $this->content->getYearsList(2011, date('Y'));
        $this->view->render('holidays/index');
    }

    public function create() {
        if ($this->model->createSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

    public function read() {
        if ($this->method->isAjax()) {

            $action = $this->method->post('page', 0);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";

            if ($action == 999) {

                $listView = $this->model->selectHolidays();

                $page = 1;
                $total = count($listView);

                $xml .= "<page>$page</page>";
                $xml .= "<total>$total</total>";

                foreach ($listView as $row) {
                    $start_date = date('m/d/Y', strtotime($row['STARTTIME']));
                    $end_date = date('m/d/Y', strtotime($row['INTERVAL']));
                    $date = '<span class="start_date">' . $start_date . ' </span> <span class="finish_date" style="display:none;">' . $end_date . '</span>';
                    if ($start_date != $end_date)
                        $date = '<span class="start_date">' . $start_date . ' </span> <span style="color:blue;">s.d.</span> <span class="finish_date">' . $end_date . '</span>';

                    $btn_edit = Src::image('edit.gif', null, array('rel' => $row['HOLIDAYID'], 'title' => 'Perbaharui Keterangan', 'class' => 'edit', 'style' => 'cursor:pointer'));

                    $xml .= "<row id='" . $row['HOLIDAYID'] . "'>";
                    $xml .= "<cell><![CDATA[" . $row['HOLIDAYID'] . "]]></cell>";
                    $xml .= "<cell><![CDATA[" . $row['HOLIDAYNAME'] . "]]></cell>";
                    $xml .= "<cell><![CDATA[" . $date . "]]></cell>";
                    $xml .= "<cell><![CDATA[" . $btn_edit . "]]></cell>";
                    $xml .= "</row>";
                }
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function update($id = 0) {
        if ($this->model->updateSave($id)) {
            $ket = array(1, 0, $this->message->saveSucces());
        } else {
            $ket = array(0, 0, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    public function delete() {
        if ($this->model->deleteSave()) {
            $ket = array(1, 0, $this->message->saveSucces());
        } else {
            $ket = array(0, 0, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    private function optionMonth() {
        $option = array();
        foreach ($this->content->getMonthList('ina') as $key => $value) {
            $option[$key + 1] = $value;
        }
        return $option;
    }

}