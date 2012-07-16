<?php

class Catalogue extends Controller {

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
        Web::setTitle('Catalogue');
        $this->view->link_add = $this->content->setLink('catalog/add');
        $this->view->listData = $this->listData();
        $this->view->render('catalog/index');
    }
    
    public function add() {
        Web::setTitle('Add Catalogue');
        $this->view->link_back = $this->content->setLink('catalog');
        $this->view->render('catalog/add');
    }
    
    public function edit($id = 0) {
        Web::setTitle('Edit Catalogue');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('catalog');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('catalog/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
    }
    
    public function listData($page = 1) {
        $maxRows = 10;
        $countList = $this->model->countAll();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 9;

        $ddcList = $this->model->selectAll(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['book_id'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td valign="top" style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: left;"><div style="margin:0 15px;"><div>' . $value['call_number'] . '</div><div>DAV</div><div>e</div></div></td>';
                $html .= '  <td valign="top" style="text-align: left;">' . $value['book_title'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['resource_name'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['fund_name'] . '</td>';
                $html .= '  <td valign="top"><div style="float:left;">Rp.</div><div style="float:right;">' . $this->content->numberFormat($value['book_price']) . '</div></td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['book_quantity'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;"><div>' . date('l',strtotime($value['book_entry_date'])) . '</div><div>' . date('d-m-Y',strtotime($value['book_entry_date'])) . '</div></td>';
                $html .= '  <td valign="top" style="text-align: center;">';
                $html .= URL::link($this->content->setLink('catalog/edit/' . $tmpID), 'Edit', 'attach') . ' | ';
                $html .= URL::link($this->content->setLink('catalog/edit/' . $tmpID), 'Detail', 'attach');
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

    public function update($id=0) {
        if ($this->model->updateSave($id)) {
            $ket = array(1, 0, $this->message->saveSucces());
        } else {
            $ket = array(0, 0, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    public function delete() {
        $this->model->delete();
    }

}