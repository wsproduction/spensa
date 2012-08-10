<?php

class Catalogue extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->jQueryBase64();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->tokenInput();
    }

    public function index() {
        Web::setTitle('Catalogue');
        $this->view->link_add = $this->content->setLink('catalogue/add');
        $this->view->listData = $this->listData();
        $this->view->render('catalogue/index');
    }

    public function add() {
        Web::setTitle('Add Catalogue');
        $this->view->link_back = $this->content->setLink('catalogue');
        $this->view->link_city = $this->content->setLink('catalogue/getCity');
        $this->view->years = $this->model->listYear();
        $this->view->country = $this->listCountry();
        $this->view->language = $this->listLanguage();
        $this->view->publisher = $this->listPublisher();
        $this->view->accounting_symbol = $this->listAccountingSymbol();
        $this->view->book_resource = $this->listBookResource();
        $this->view->book_fund = $this->listBookFund();
        $this->view->ddc_level1 = $this->listDdc(1, 0, 1);
        $this->view->render('catalogue/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Catalogue');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('catalogue');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('catalogue/edit');
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

                $author = $this->model->selectAuthorByID($tmpID);
                $listAuthor = '';
                $countAuthor = count($author);
                foreach ($author as $av) {
                    $countAuthor--;
                    if ($countAuthor > 0) {
                        $listAuthor .= $av['author_last_name'] . ', ';
                    } else {
                        $listAuthor .= $av['author_last_name'];
                    }
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td valign="top" style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: left;">';
                $html .= '      <div style="margin:0 15px;">';
                $html .= '          <div>' . $value['call_number'] . '</div>';
                $html .= '          <div>DAV</div>';
                $html .= '          <div>e</div>';
                $html .= '      </div>';
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: left;">';
                $html .= $value['book_title'] . ' : ' . $value['book_sub_title'];
                $html .= '      <strong> / </strong> ' . $listAuthor . ' .&HorizontalLine; <i>' . $value['city_name'] . ' : ' . $value['publisher_name'] . ', ' . $value['book_year_launching'] . '</i>';
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['resource_name'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['fund_name'] . '</td>';
                $html .= '  <td valign="top">';
                $html .= '      <div style="float:left;">Rp.</div>';
                $html .= '      <div style="float:right;">' . $this->content->numberFormat($value['book_price']) . '</div>';
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['book_quantity'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">';
                $html .= '      <div>' . date('l', strtotime($value['book_entry_date'])) . '</div>';
                $html .= '      <div>' . date('d-m-Y', strtotime($value['book_entry_date'])) . '</div>';
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: center;">';
                $html .= URL::link($this->content->setLink('catalogue/edit/' . $tmpID), 'Edit', 'attach') . ' | ';
                $html .= URL::link($this->content->setLink('catalogue/edit/' . $tmpID), 'Detail', 'attach');
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

    public function listDdc($page = 1, $parent = 0, $level = 0) {
        $maxRows = 10;

        if ($level != 0 && $parent == 0) {
            $countList = $this->model->countAllDdcByLevel($level);
            $ddcList = $this->model->selectAllDdcByLevel($level, ($page * $maxRows) - $maxRows, $maxRows);
        } else {
            $countList = $this->model->countAllDdcByParent($parent);
            $ddcList = $this->model->selectAllDdcByParent($parent, ($page * $maxRows) - $maxRows, $maxRows);
        }

        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 2;

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

                $html .= '<tr is="option" class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '" value="' . $tmpID . '">';
                $html .= '  <td style="text-align: center;"  class="first" is="call_number">' . $value['ddc_classification_number'] . '</td>';
                $html .= '  <td>' . $value['ddc_title'] . '</td>';
                $html .= '</tr>';

                $idx++;
            }

            if ($level == 1) {
                $this->content->customPagingId('prevPagingLevel1', 'pagePagingLevel1', 'nextPagingLevel1', 'maxPagingLevel1');
            } else if ($level == 2) {
                $this->content->customPagingId('prevPagingLevel2', 'pagePagingLevel2', 'nextPagingLevel2', 'maxPagingLevel2');
            } else if ($level == 3) {
                $this->content->customPagingId('prevPagingLevel3', 'pagePagingLevel3', 'nextPagingLevel3', 'maxPagingLevel3');
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

    public function readDdc() {
        $page = 1;
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        }
        $parent = 0;
        if (isset($_GET['parent'])) {
            $parent = $_GET['parent'];
        }
        $level = 0;
        if (isset($_GET['level'])) {
            $level = $_GET['level'];
        }
        echo json_encode($this->listDdc($page, $parent, $level));
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
        $this->model->delete();
    }

    public function getAuthor() {
        $res = array();
        $listAuthor = $this->model->selectAuthorByName();

        if ($listAuthor) {
            foreach ($listAuthor as $value) {
                $res[] = array('id' => $value['author_id'], 'name' => $value['author_first_name'] . ' ' . $value['author_last_name']);
            }
        }

        # JSON-encode the response
        $json_response = json_encode($res);

        # Optionally: Wrap the response in a callback function for JSONP cross-domain support
        if (isset($_GET["callback"])) {
            if ($_GET["callback"]) {
                $json_response = $_GET["callback"] . "(" . $json_response . ")";
            }
        }

        # Return the response
        echo $json_response;
    }

    public function upload() {
        Web::setTitle('Test Upload');
        $this->view->link_back = $this->content->setLink('catalogue');
        $this->view->render('catalogue/upload');
    }

    public function postUpload() {
        /*
          $path = Web::path() . 'asset/upload/';
          $valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");

          $name = $_FILES['photoimg']['name'];
          $size = $_FILES['photoimg']['size'];

          if (strlen($name)) {
          list($txt, $ext) = explode(".", strtolower($name));
          if (in_array($ext, $valid_formats)) {
          if ($size < (1024 * 1024)) {
          $actual_image_name = time() . substr(str_replace(" ", "_", $txt), 5) . "." . $ext;
          $tmp = $_FILES['photoimg']['tmp_name'];
          if (move_uploaded_file($tmp, $path . $actual_image_name)) {
          //echo json_encode(array(1,$this->message->saveSucces()));
          //echo '{"name":"Warman Suganda","gender":"Male","message":"' . json_encode($this->message->saveSucces()) . '"}';
          echo '{"aye":"sds"}';
          }
          else
          echo "failed";
          }
          else
          echo "Image file size max 1 MB";
          }
          else
          echo "Invalid file format..";
          }
          else
          echo "Please select image..!";

          exit;
         */
        echo '{"aye":"sds","html":"' . base64_encode($this->message->saveSucces()) . '"}';
    }

    public function listLanguage() {
        $data = $this->model->selectLanguage();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['language_id']] = $value['language_name'];
            }
        }
        return $list;
    }

    public function listAccountingSymbol() {
        $data = $this->model->selectAccountingSymbol();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['accounting_symbol_id']] = $value['accounting_symbol'] . ' (' . $value['accounting_symbol_desc'] . ')';
            }
        }
        return $list;
    }

    public function listBookResource() {
        $data = $this->model->selectBookResource();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['resource_id']] = $value['resource_name'];
            }
        }
        return $list;
    }

    public function listBookFund() {
        $data = $this->model->selectBookFund();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $fund_name = $value['fund_name'];
                if (isset($value['fund_desc'])) {
                    $fund_name .= ' (' . $value['fund_desc'] . ')';
                }
                $list[$value['fund_id']] = $fund_name;
            }
        }
        return $list;
    }

    public function listPublisher() {
        $data = $this->model->selectPublisher();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['publisher_id']] = $value['publisher_name'];
            }
        }
        return $list;
    }

    public function listCountry() {
        $data = $this->model->selectCountry();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['country_id']] = $value['country_name'];
            }
        }
        return $list;
    }

    public function getCity() {
        $data = $this->model->selectCity($_GET['id']);
        $list = '<option value=""></option>';
        if ($data) {
            foreach ($data as $value) {
                $list .= '<option value="' . $value['city_id'] . '">' . $value['city_name'] . '</option>';
            }
        }
        echo json_encode($list);
    }

}