<?php

class Collection extends Controller {

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
        Web::setTitle('Daftar Koleksi Buku');
        $this->view->link_add = $this->content->setLink('author/add');
        $this->view->listData = $this->listData();
        $this->view->render('collection/index');
    }
    
    public function add() {
        Web::setTitle('Add author');
        $this->view->link_back = $this->content->setLink('author');
        $this->view->render('author/add');
    }
    
    public function edit($id = 0) {
        Web::setTitle('Edit author');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('author');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('author/edit');
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
                $tmpID = $value['book_register_id'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }
                
                $sts = 'Ada';
                if ($value['borrow_status']){
                    $sts = 'Dipinjam';
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td style="text-align: center;">' . $tmpID . '</td>';
                $html .= '  <td></td>';
                $html .= '  <td></td>';
                $html .= '  <td style="text-align: center;">' . $value['book_con'] . '</td>';
                $html .= '  <td style="text-align: center;">' . date('d/m/Y', strtotime($value['entry_date'])) . '</td>';
                $html .= '  <td style="text-align: center;">' . $sts . '</td>';
                $html .= '  <td style="text-align: center;">';
                        if ($value['last_borrow']==NULL)
                            $html .= date('d/m/Y',  strtotime ($value['last_borrow']));
                $html .= '  </td>';
                $html .= '  <td style="text-align: center;">';
                $html .= URL::link($this->content->setLink('author/edit/' . $tmpID), 'Edit', 'attach') . ' | ';
                $html .= URL::link($this->content->setLink('author/edit/' . $tmpID), 'Detail', 'attach');
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