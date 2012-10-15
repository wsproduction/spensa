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
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->jQueryAutoNumeric();
        Src::plugin()->jQueryBase64();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->tokenInput();
    }

    public function index() {
        Web::setTitle('Katalog');
        $this->view->link_add = $this->content->setLink('catalogue/add');
        $this->view->listData = $this->listData();
        $this->view->render('catalogue/index');
    }

    public function setAuthor() {
        $listDadID = array();
        $listDad = array();
        foreach ($this->model->selectAllAuthorDescription() as $value) {
            $listDadID[] = $value['author_description_id'];
            $listDad[$value['author_description_id']] = $value['author_description'];
        }

        $this->dataAuthorDescriptionID = $listDadID;
        $this->dataAuthorDescription = $listDad;

        $dataAuthor = $this->model->selectAllAuthor();

        $varAuthor = array();
        foreach ($dataAuthor as $value) {
            $varAuthor[$value['book_id']][$value['author_description']][] = array('first_name' => $value['author_first_name'], 'last_name' => $value['author_last_name']);
        }
        $this->dataAuthor = $varAuthor;
    }

    public function setAuthorTemp() {
        $listDadID = array();
        $listDad = array();
        foreach ($this->model->selectAllAuthorDescription() as $value) {
            $listDadID[] = $value['author_description_id'];
            $listDad[$value['author_description_id']] = $value['author_description'];
        }

        $this->dataAuthorTempDescriptionID = $listDadID;
        $this->dataAuthorTempDescription = $listDad;

        $dataAuthor = $this->model->selectAuthorTempBySession();

        $varAuthor = array();
        foreach ($dataAuthor as $value) {
            $varAuthor[$value['session_id']][$value['author_description']][] = array('first_name' => $value['author_first_name'], 'last_name' => $value['author_last_name']);
        }
        $this->dataAuthorTemp = $varAuthor;
    }

    public function parsingAuthor($bookID, $authorDescrptionID) {
        $res = '';
        $count = 0;

        $data = $this->dataAuthor;
        if (isset($data[$bookID][$authorDescrptionID])) {
            $list = $data[$bookID][$authorDescrptionID];
            $count = count($list);
            $idx = 1;

            if ($count > 0) {
                if ($authorDescrptionID != 1)
                    $res .= strtolower($this->dataAuthorDescription[$authorDescrptionID]) . ', ';

                foreach ($list as $value) {
                    $tempNama = $value['first_name'];
                    if ($value['last_name'] != '')
                        $tempNama .= ' ' . $value['last_name'];

                    if ($idx == $count) {
                        $res .= $tempNama;
                    } else {
                        $res .= $tempNama . ', ';
                    }
                    $idx++;
                }
            }
        }
        return array($count, $res);
    }

    public function parsingAuthorTemp($bookID, $authorDescrptionID) {
        $res = '';
        $count = 0;

        $data = $this->dataAuthorTemp;
        if (isset($data[$bookID][$authorDescrptionID])) {
            $list = $data[$bookID][$authorDescrptionID];
            $count = count($list);
            $idx = 1;

            if ($count > 0) {
                if ($authorDescrptionID != 1)
                    $res .= strtolower($this->dataAuthorTempDescription[$authorDescrptionID]) . ', ';

                foreach ($list as $value) {
                    $tempNama = $value['first_name'];
                    if ($value['last_name'] != '')
                        $tempNama .= ' ' . $value['last_name'];

                    if ($idx == $count) {
                        $res .= $tempNama;
                    } else {
                        $res .= $tempNama . ', ';
                    }
                    $idx++;
                }
            }
        }
        return array($count, $res);
    }

    public function add() {
        Web::setTitle('Tambah Katalog');
        $this->view->link_back = $this->content->setLink('catalogue');
        $this->view->link_city = $this->content->setLink('catalogue/getCity');
        $this->view->link_info_publisher = $this->content->setLink('catalogue/getInfoPublisher');
        $this->view->session_id_temp = Session::id() . date('YmdHis');
        $this->view->years = $this->model->listYear();
        $this->view->country = $this->listCountry();
        $this->view->language = $this->listLanguage();
        $this->view->publisher = $this->listPublisher();
        $this->view->accounting_symbol = $this->listAccountingSymbol();
        $this->view->book_resource = $this->listBookResource();
        $this->view->book_fund = $this->listBookFund();
        $this->view->book_type = $this->listBookType();
        $this->view->length_borrowed = $this->listLengthBorrowed();
        $this->view->author_description = $this->listAuthorDescription();
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

    public function detail($id = 0) {
        Web::setTitle('Detail Catalogue');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('catalogue');
        $this->view->link_print_barcode = $this->content->setLink('catalogue/printBarcode/' . $id);
        $this->view->link_print_label = $this->content->setLink('catalogue/printLabel/' . $id);
        $this->view->listDataCollection = $this->listDataCollection($id);
        $this->view->render('catalogue/detail');
    }

    public function listData($page = 1) {
        $maxRows = 10;
        $countList = $this->model->countAll();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 10;

        $ddcList = $this->model->selectAll(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';

            $this->setAuthor();

            foreach ($ddcList as $value) {
                $tmpID = $value['book_id'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }

                // Judul Buku
                $keterangan_buku = $value['book_title'];
                if ($value['book_sub_title'] != '')
                    $keterangan_buku .= ' : ' . $value['book_sub_title'];$value['book_year_launching'] . '</i>';

                // Author
                $outAuthor = '';
                $countAuthor = 0;
                $tempCount = 0;
                $jmlPengarang = 0;
                $namaPengarang = '';
                foreach ($this->dataAuthorDescription as $keyAD => $valueAD) {
                    $res = $this->parsingAuthor($tmpID, $keyAD);

                    if ($res[0] > 0 && $countAuthor)
                        $outAuthor .= '; ';

                    $countAuthor += $res[0];
                    $outAuthor .= $res[1];
                    $tempCount = $res[0];

                    //untuk menentukan classification number
                    if ($keyAD == 1) {
                        $namaPengarang = $res[1];
                        $jmlPengarang = $res[0];
                    }
                }

                if ($countAuthor > 0)
                    $keterangan_buku .= '      / ' . $outAuthor;

                // Edisi, Cetakan
                if ($value['book_edition'] != '' || $value['book_print'] != '')
                    $keterangan_buku .= '.&HorizontalLine;';

                if ($value['book_edition'] != '')
                    $keterangan_buku .= ' Ed. ' . $value['book_edition'];

                if ($value['book_edition'] != '' && $value['book_print'] != '')
                    $keterangan_buku .= ', ';

                if ($value['book_print'] != '')
                    $keterangan_buku .= ' cet. ' . $value['book_print'];

                // Keterangan Penerbit
                $keterangan_buku .= '.&HorizontalLine; ' . $value['city_name'] . ' : ' . $value['publisher_name'] . ', ' . $value['book_year_launching'] . '.';


                // CallNumber
                $callNumberRow1 = $value['classification_number'];
                $callNumberRow2 = '';
                $callNumberRow3 = '';
                if ($jmlPengarang > 0 && $jmlPengarang <= 3) {
                    $np = explode(',', $namaPengarang);
                    $callNumberRow2 = strtoupper(substr(str_replace(' ', '', $np[0]), 0, 3));
                    $callNumberRow3 = strtolower(substr(str_replace(' ', '', $value['book_title']), 0, 1));
                } else {
                    $callNumberRow2 = strtoupper(substr(str_replace(' ', '', $value['book_title']), 0, 3));
                }


                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td valign="top" style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: center;display:none;">' . $value['book_id'] . '</td>';
                $html .= '  <td valign="top" style="text-align: left;">';
                $html .= '      <div style="margin:0 15px;">';
                $html .= '          <div>' . $callNumberRow1 . '</div>';
                $html .= '          <div>' . $callNumberRow2 . '</div>';
                $html .= '          <div>' . $callNumberRow3 . '</div>';
                $html .= '      </div>';
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: left;">' . $keterangan_buku . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['resource_name'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['fund_name'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['book_quantity'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">' . $value['length_borrowed'] . '</td>';
                $html .= '  <td valign="top" style="text-align: center;">';
                $html .= date('d/m/Y', strtotime($value['book_entry_date']));
                $html .= '  </td>';
                $html .= '  <td valign="top" style="text-align: center;">';
                $html .= URL::link($this->content->setLink('catalogue/edit/' . $tmpID), 'Edit', 'attach') . ' | ';
                $html .= URL::link($this->content->setLink('catalogue/detail/' . $tmpID), 'Detail', 'attach');
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

    public function listDataCollection($id = 0, $page = 1) {
        $maxRows = 10;
        $countList = $this->model->countAllCollection($id);
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 9;

        $ddcList = $this->model->selectAllCollection($id, ($page * $maxRows) - $maxRows, $maxRows);
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
                if ($value['borrow_status']) {
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
                if ($value['last_borrow'] == NULL)
                    $html .= date('d/m/Y', strtotime($value['last_borrow']));
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

                $html .= '<tr isa="option" class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '" value="' . $tmpID . '" style="cursor:pointer">';
                $html .= '  <td valign="top" style="text-align: center;"  class="first" is="call_number">' . $value['ddc_classification_number'] . '</td>';
                $html .= '  <td>';
                $html .= '      <div>' . $value['ddc_title'] . '</div>';

                if ($level == 3 && $value['ddc_description'] != '') {
                    $html .= '      <div style="font-size:10px;border-top:1px solid #ddd;margin-top:2px;padding-top:2px;">' . $value['ddc_description'] . '</div>';
                }

                $html .= '  </td>';
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
            $html .= '   <td class="first" style="text-align:center;" colspan="' . $jumlah_kolom . '"><i>Data Not Found</i></th>';
            $html .= '</tr>';
        }
        return $html;
    }

    public function listAuthorTemp($page = 1, $sessionAuthor = 0) {
        $maxRows = 10;
        $countList = $this->model->countAllAuthorTemp($sessionAuthor);
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 4;

        $ddcList = $this->model->selectAllAuthorTemp(($page * $maxRows) - $maxRows, $maxRows, $sessionAuthor);
        $html = '';

        if ($countList > 0) {

            $idx = (($maxRows * $page) - $maxRows) + 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['author_id'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td class="first" style="text-align: center;">' . $idx . '</td>';
                $html .= '  <td style="text-align: left;">' . $value['author_first_name'] . ' ' . $value['author_last_name'] . '</td>';
                $html .= '  <td>' . $value['author_description'] . '</td>';
                $html .= '  <td style="text-align: center;">';
                $html .= URL::link('#', 'Delete', 'attach', array('class' => 'delete', 'value' => $tmpID));
                $html .= '  </td>';
                $html .= '</tr>';

                $idx++;
            }

            $this->content->customPagingId('prevPagingAuthor', 'pagePagingAuthor', 'nextPagingAuthor', 'maxPagingAuthor');
            $html .= $this->content->paging($jumlah_kolom, $countPage, $page);

            Form::create('hidden', 'hiddenID');
            Form::value($id);
            $html .= Form::commit('attach');
        } else {
            $html .= '<tr>';
            $html .= '   <td colspan="' . $jumlah_kolom . '" class="first" style="text-align:center;"><i>Data Not Found</i></th>';
            $html .= '</tr>';
        }
        return $html;
    }

    public function create() {
        if ($this->model->createSave()) {
            $ket = '{sucess:1, reset:1, html: "' . base64_encode($this->message->saveSucces()) . '"}';
        } else {
            $ket = '{sucess:0, reset:0, html: "' . base64_encode($this->message->saveError()) . '" }';
        }
        echo $ket;
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

    public function readAuthorTemp() {
        $page = 1;
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        }
        $sessionAuthor = '0';
        if (isset($_GET['sa'])) {
            $sessionAuthor = $_GET['sa'];
        }
        echo json_encode($this->listAuthorTemp($page, $sessionAuthor));
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

    public function deleteAuthorTemp() {
        $this->model->deleteAuthorTemp();
    }

    public function upload() {
        Web::setTitle('Test Upload');
        $this->view->link_back = $this->content->setLink('catalogue');
        $this->view->render('catalogue/upload');
    }

    public function postUpload() {
        $gambar = 'gambar';
        $file = 'file';
        if ($_FILES[$gambar]['tmp_name'] && $_FILES[$file]['tmp_name']) {
            $upload = Src::plugin()->PHPUploader();

            $upload->SetFileName($_FILES[$gambar]['name']);
            $upload->ChangeFileName('cover_' . date('Ymd') . time());
            $upload->SetTempName($_FILES[$gambar]['tmp_name']);
            $upload->SetUploadDirectory(Web::path() . 'asset/upload/images/'); //Upload directory, this should be writable
            echo 'yang pertama ' . $upload->UploadFile();

            $upload->SetFileName($_FILES[$file]['name']);
            $upload->ChangeFileName('ebook_' . date('Ymd') . time());
            $upload->SetTempName($_FILES[$file]['tmp_name']);
            $upload->SetUploadDirectory(Web::path() . 'asset/upload/file/'); //Upload directory, this should be writable
            echo '<br>yang kedua ' . $upload->UploadFile();
        }
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

    public function listBookType() {
        $data = $this->model->selectBookType();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['book_type_id']] = $value['book_type'];
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

    public function listLengthBorrowed() {
        $data = $this->model->selectAllLengthBorrowed();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['borrowed_description_id']] = $value['borrowed_title'];
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

    public function listAuthorDescription() {
        $data = $this->model->selectAllAuthorDescription();
        $list = array();
        foreach ($data as $value) {
            $list[$value['author_description_id']] = $value['author_description'];
        }
        return $list;
    }

    public function addAuthorTemp() {
        if ($this->model->addAuthorTempSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

    public function getWriter() {
        $sid = 0;
        if (isset($_GET['sa'])) {
            $sid = $_GET['sa'];
        }
        $data = $this->model->selectWriterTempBySession($sid);
        if (count($data) > 0 && count($data) <= 3) {
            $writerPrimary = $data[0];

            $WriterName = $writerPrimary['author_first_name'];
            if ($writerPrimary['author_last_name'] != '') {
                $WriterName = strtoupper($writerPrimary['author_last_name']) . ', ' . $writerPrimary['author_first_name'];
            }

            $ket = array(1, $WriterName);
        } else {
            $ket = array(0);
        }

        echo json_encode($ket);
    }

    public function getInfoPublisher() {

        $data = $this->model->selectPublisherByID();
        if ($data) {
            $listData = $data[0];

            $namaPenerbit = '-';
            if ($listData['publisher_name'] != '')
                $namaPenerbit = $listData['publisher_name'];

            $alamat = '-';
            if ($listData['publisher_name'] != '')
                $alamat = $listData['publisher_address'];

            $telp = '-';
            if ($listData['publisher_phone'] != '')
                $telp = $listData['publisher_phone'];

            $fax = '-';
            if ($listData['publisher_fax'] != '')
                $fax = $listData['publisher_fax'];

            $email = '-';
            if ($listData['publisher_email'] != '')
                $email = $listData['publisher_email'];

            $website = '-';
            if ($listData['publisher_website'] != '')
                $website = $listData['publisher_website'];

            $keterangan = '-';
            if ($listData['publisher_description'] != '')
                $keterangan = $listData['publisher_description'];

            if ($listData['publisher_logo'] != '') {
                $logo = Src::image($listData['publisher_logo'], URL::getService() . '://' . Web::$host . '/__MyWeb/' . Web::$webFolder . '/asset/upload/images/', array('id' => 'publisherLogo', 'style' => 'max-width:128px;max-height:128px;'));
            } else {
                $logo = Src::image('128.png', null, array('id' => "publisherLogo"));
            }
        } else {
            $logo = Src::image('128.png', null, array('id' => "publisherLogo"));
            $namaPenerbit = '&Lt; Nama Penerbit &Gt;';
            $alamat = '&Lt; Alamat &Gt;';
            $telp = '-';
            $fax = '-';
            $email = '-';
            $website = '-';
            $keterangan = '-';
        }

        $html = '<div id="info_publisher">
            <table style="width: 100%">
                    <tr>
                        <td style="width: 128px;" valign="top"> ' . $logo . ' </td>
                        <td valign="top" style="padding: 5px 10px;font-size: 11px;">
                            <div style="font-weight: bold">' . $namaPenerbit . '</div>
                            <div>' . $alamat . '</div>
                            <div>Telp. : ' . $telp . ' , Fax. : ' . $fax . '</div>
                            <div>Email : ' . $email . ' </div>
                            <div>Website : ' . $website . '</div>
                            <div style="padding-top: 5px;">Keterangan : </div>
                            <div>' . $keterangan . '</div>
                        </td>
                    </tr>
                </table>
                </div>';
        echo json_encode($html);
    }

    public function getAuhtorTemp() {
        $this->setAuthorTemp();

        // Author
        $outAuthor = '';
        $countAuthor = 0;
        $tempCount = 0;

        foreach ($this->dataAuthorTempDescription as $keyAD => $valueAD) {
            $res = $this->parsingAuthorTemp($this->method->get('sa'), $keyAD);

            if ($res[0] > 0 && $countAuthor)
                $outAuthor .= '; ';

            $countAuthor += $res[0];
            $outAuthor .= $res[1];
            $tempCount = $res[0];
        }

        if ($countAuthor > 0)
            $keteranganAuthor = ' / ' . $outAuthor;

        echo json_encode($keteranganAuthor);
    }

    public function printBarcode($id = 0) {

        $catalogue = $this->model->selectCatalogueById($id);

        if (count($catalogue) > 0) {
            $listCatalogue = $catalogue[0];
            $data = $this->model->selectAllCollectionByBookId($id);
            $author = $this->model->selectAuthorByBookID($id);

            $booktitle = $listCatalogue['book_title'];
            if ($listCatalogue['book_sub_title'] != '')
                $booktitle .= ' : ' . $listCatalogue['book_sub_title'];

            if (count($author) > 0) {
                $listAuthor = $author[0];
                $call_number = $listCatalogue['class_number'] . ' / ' . strtoupper(substr(str_replace(' ', '', $listAuthor['author_first_name']), 0, 3)) . ' / ' . strtolower(substr(str_replace(' ', '', $listCatalogue['book_title']), 0, 1));
            } else {
                $call_number = $listCatalogue['class_number'] . ' / ' . strtoupper(substr(str_replace(' ', '', $listCatalogue['book_title']), 0, 3));
            }

            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');

            // set default header data
            $pdf->SetHeaderData('', '', '[ ' . $id . ' ] ' . $booktitle, 'Call Number : ' . $call_number . ' | Jumlah Barcode : ' . count($data));

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, PDF_MARGIN_TOP, 11);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // ---------------------------------------------------------
            // set a barcode on the page footer
            $pdf->setBarcode(date('Y-m-d H:i:s'));

            // set font
            $pdf->SetFont('helvetica', '', 11);

            // add a page
            $pdf->AddPage();

            // -----------------------------------------------------------------------------

            $pdf->SetFont('helvetica', '', 10);

            // define barcode style
            $style = array(
                'position' => '',
                'align' => 'C',
                'stretch' => false,
                'fitwidth' => true,
                'cellfitalign' => '',
                'border' => true,
                'hpadding' => 'auto',
                'vpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255),
                'text' => true,
                'font' => 'helvetica',
                'fontsize' => 8,
                'stretchtext' => 4
            );

            // CODE 128 C
            $posX = 11;
            $posY = 20;
            $row = 1;
            $col = 1;

            //var_dump($data);
            //for ($idx = 1; $idx <= 53; $idx++) {
            foreach ($data as $value) {

                $pdf->write1DBarcode($value['book_register_id'], 'C128C', $posX, $posY, 44, 18, 0.4, $style, '');

                $posX += 48;

                if ($col == 4) {
                    $col = 1;
                    $posX = 11;
                    $posY += 22;
                    $row++;
                } else {
                    $col++;
                }

                if ($row > 12) {
                    $pdf->AddPage();
                    $posX = 11;
                    $posY = 20;
                    $row = 1;
                    $col = 1;
                }
            }

            // ---------------------------------------------------------
            //Close and output PDF document
            $pdf->Output('example_027.pdf', 'I');
        } else {
            echo 'Sory, Catalogue Not Found!';
        }
    }

    public function printLabel($id) {
        $catalogue = $this->model->selectCatalogueById($id);

        if (count($catalogue) > 0) {
            $listCatalogue = $catalogue[0];
            $data = $this->model->selectAllCollectionByBookId($id);
            $author = $this->model->selectAuthorByBookID($id);

            $booktitle = $listCatalogue['book_title'];
            if ($listCatalogue['book_sub_title'] != '')
                $booktitle .= ' : ' . $listCatalogue['book_sub_title'];

            if (count($author) > 0) {
                $listAuthor = $author[0];
                $call_number = $listCatalogue['class_number'] . ' / ' . strtoupper(substr(str_replace(' ', '', $listAuthor['author_first_name']), 0, 3)) . ' / ' . strtolower(substr(str_replace(' ', '', $listCatalogue['book_title']), 0, 1));
            } else {
                $call_number = $listCatalogue['class_number'] . ' / ' . strtoupper(substr(str_replace(' ', '', $listCatalogue['book_title']), 0, 3));
            }

            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');
            
            // set default header data
            $pdf->SetHeaderData('', '', '[ ' . $id . ' ] ' . $booktitle, 'Call Number : ' . $call_number . ' | Jumlah Barcode : ' . count($data));

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, PDF_MARGIN_TOP, 11);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // ---------------------------------------------------------
            // set a barcode on the page footer
            $pdf->setBarcode(date('Y-m-d H:i:s'));

            // set font
            $pdf->SetFont('helvetica', '', 11);

            // add a page
            $resolution= array(210, 310);
            $pdf->AddPage('P', $resolution);

            // create some HTML content
            // HTML text with soft hyphens (&shy;)
            $html = '
                    <table style="border:1px solid #000;text-align:center;">
                        <tr>
                            <td>PERPUSTAKAAN</td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #000;">SMP NEGERI 1 SUBANG</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;">
                                &nbsp;
                                <br>
                                578.03<br>
                                WAR<br>
                                p
                                <br>
                            </td>
                        </tr>
                    </table>
                    ';

            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 20, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 20, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 20, $html, 0, 0, 0, true, 'J');
            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 60, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 60, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 60, $html, 0, 0, 0, true, 'J');
            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 100, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 100, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 100, $html, 0, 0, 0, true, 'J');
            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 140, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 140, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 140, $html, 0, 0, 0, true, 'J');
            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 180, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 180, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 180, $html, 0, 0, 0, true, 'J');
            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 220, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 220, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 220, $html, 0, 0, 0, true, 'J');
            // print a cell
            $pdf->writeHTMLCell(60, 0, 10, 260, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 75, 260, $html, 0, 0, 0, true, 'J');
            $pdf->writeHTMLCell(60, 0, 140, 260, $html, 0, 0, 0, true, 'J');

            // reset pointer to the last page
            $pdf->lastPage();

            // ---------------------------------------------------------
            //Close and output PDF document
            $pdf->Output('example_027.pdf', 'I');
        } else {
            echo 'Sory, Catalogue Not Found!';
        }
    }

}