<?php

class Ddc extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
    }

    public function index() {
        Web::setTitle('List Dewey Decimal Classification Edition 22');
        $this->view->link_add = $this->content->setLink('ddc/add');
        $this->view->listData = $this->listData();
        $this->view->render('ddc/index');
    }

    public function add() {
        Web::setTitle('Add DDC');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $this->view->link_back = $this->content->setLink('ddc');
        $this->view->link_sub1 = $this->content->setLink('ddc/getSub1');
        $this->view->render('ddc/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit DDC');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('ddc');
        $this->view->ddcLevel = $this->model->selectLevelDDC();
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;

            switch ($listData['ddc_level']) {
                case 2:
                    foreach ($this->model->selectSub1() as $value) {
                        $listSub1[$value['ddc_id']] = $value['ddc_call_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub1 = array($listSub1, $listData['ddc_main_parent']);
                    $this->view->link_sub2 = $this->content->setLink('ddc/getSub2');
                    break;
                case 3:
                    $this->view->link_sub2 = $this->content->setLink('ddc/getSub2');
                    foreach ($this->model->selectSub1() as $value) {
                        $listSub1[$value['ddc_id']] = $value['ddc_call_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub1 = array($listSub1, $listData['ddc_temp_parent']);

                    foreach ($this->model->selectSub2($listData['ddc_temp_parent']) as $value) {
                        $listSub2[$value['ddc_id']] = $value['ddc_call_number'] . ' ' . $value['ddc_title'];
                    }
                    $this->view->listSub2 = array($listSub2, $listData['ddc_main_parent']);
                    break;
            }
            $this->view->render('ddc/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
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
        $page = 1;
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        }
        echo json_encode($this->listData($page));
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
        echo json_encode($this->model->delete());
    }

    public function getSub1() {
        $list = array();
        foreach ($this->model->selectSub1() as $value) {
            $list[$value['ddc_id']] = $value['ddc_call_number'] . ' ' . $value['ddc_title'];
        }

        Form::create('select', 'sub1');
        Form::tips('Chose Level DDC');
        Form::validation()->requaired();
        Form::option($list, ' ');
        Form::properties(array('link' => $this->content->setLink('ddc/getSub2')));
        $html = Form::commit('attach');

        echo json_encode($html);
    }

    public function getSub2() {
        $list = array();
        foreach ($this->model->selectSub2($_GET['id']) as $value) {
            $list[$value['ddc_id']] = $value['ddc_call_number'] . ' ' . $value['ddc_title'];
        }

        Form::create('select', 'sub2');
        Form::tips('Chose Level DDC');
        Form::validation()->requaired();
        Form::option($list, ' ');
        $html = Form::commit('attach');

        echo json_encode($html);
    }

    public function listData($page = 1) {
        $maxRows = 10;
        $countList = $this->model->countAll();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 4;

        $ddcList = $this->model->selectAll(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['ddc_id'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td style="text-align: center;">' . $value['ddc_call_number'] . '</td>';
                $html .= '  <td>' . $value['ddc_title'] . '</td>';
                $html .= '  <td style="text-align: center;">';
                $html .= URL::link($this->content->setLink('ddc/edit/' . $tmpID), 'Edit', 'attach') . ' | ';
                $html .= URL::link($this->content->setLink('ddc/edit/' . $tmpID), 'Detail', 'attach');
                $html .= '  </td>';
                $html .= '</tr>';

                $idx++;
            }

            $html .= $this->content->paging($jumlah_kolom, $countPage, $page);

            Form::create('hidden', 'hiddenID');
            Form::value($id);
            $html .= Form::commit('attach');
        } else {
            $html .= '<tr>';
            $html .= '   <th colspan="' . $jumlah_kolom . '">Data Not Found</th>';
            $html .= '</tr>';
        }
        return $html;
    }

}