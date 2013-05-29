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
        Src::plugin()->flexiGrid();
        Src::plugin()->jQueryMultiSelect();
    }

    public function index() {
        Web::setTitle('Daftar Katalog');
        $this->view->link_r = $this->content->setLink('catalogue/read');
        $this->view->link_c = $this->content->setLink('catalogue/add');
        $this->view->link_d = $this->content->setLink('catalogue/delete');
        $this->view->link_pl = $this->content->setLink('catalogue/printlistbarcode');
        $this->view->render('catalogue/index');
    }

    public function setAuthor() {
        $listDadID = array();
        $listDad = array();
        foreach ($this->model->selectAllAuthorDescription() as $value) {
            $listDadID[] = $value['author_description_id'];
            $listDad[$value['author_description_id']] = $value['author_description_title'];
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
            $listDad[$value['author_description_id']] = $value['author_description_title'];
        }

        $this->dataAuthorTempDescriptionID = $listDadID;
        $this->dataAuthorTempDescription = $listDad;

        $dataAuthor = $this->model->selectAuthorTempBySession();

        $varAuthor = array();
        foreach ($dataAuthor as $value) {
            $varAuthor[$value['book_author_temp_session']][$value['book_author_temp_name']][] = array('first_name' => $value['author_firstname'], 'last_name' => $value['author_lastname']);
        }
        $this->dataAuthorTemp = $varAuthor;
    }

    public function add() {
        Web::setTitle('Tambah Katalog');
        $this->view->link_back = $this->content->setLink('catalogue');
        $this->view->session_id_temp = Session::id() . date('YmdHis');

        $this->model->clearLanguageTemp();
        $this->view->language = $this->optionLanguage();
        $this->view->link_r_language = $this->content->setLink('catalogue/readlanguagetemp');
        $this->view->link_d_language = $this->content->setLink('catalogue/deletelanguagetemp');

        $this->view->accounting_symbol = $this->optionAccountingSymbol();
        $this->view->book_resource = $this->optionBookResource();
        $this->view->book_fund = $this->optionBookFund();

        $this->view->country = $this->optionCountry();
        $this->view->link_province = $this->content->setLink('catalogue/optionprovince');
        $this->view->link_city = $this->content->setLink('catalogue/optioncity');
        $this->view->link_r_publisher = $this->content->setLink('catalogue/readpublisher');
        $this->view->years = $this->model->listYear();

        $this->model->clearAuthorTemp();
        $this->view->author_description = $this->optionAuthorDescription();
        $this->view->link_author = $this->content->setLink('catalogue/optionauthor');
        $this->view->link_r_author_temp = $this->content->setLink('catalogue/readauthortemp');
        $this->view->link_d_author_temp = $this->content->setLink('catalogue/deleteauthortemp');

        $this->view->ddc_level1 = $this->optionDdc(1);
        $this->view->link_ddc_level2 = $this->content->setLink('catalogue/optionddclevel2');
        $this->view->link_r_ddc = $this->content->setLink('catalogue/readddc');

        $this->view->render('catalogue/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Catalogue');
        $this->view->id = $id;
        
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;

            $this->view->link_back = $this->content->setLink('catalogue');
            $this->view->session_id_temp = Session::id() . date('YmdHis');

            $this->model->clearLanguageTemp();
            $this->view->language = $this->optionLanguage();
            $this->view->link_r_language = $this->content->setLink('catalogue/readlanguagetemp');
            $this->view->link_d_language = $this->content->setLink('catalogue/deletelanguagetemp');

            $this->view->accounting_symbol = $this->optionAccountingSymbol();
            $this->view->book_resource = $this->optionBookResource();
            $this->view->book_fund = $this->optionBookFund();

            $this->view->country = $this->optionCountry();
            $this->view->link_province = $this->content->setLink('catalogue/optionprovince');
            $this->view->link_city = $this->content->setLink('catalogue/optioncity');
            $this->view->link_r_publisher = $this->content->setLink('catalogue/readpublisher');
            $this->view->years = $this->model->listYear();

            $this->model->clearAuthorTemp();
            $this->view->author_description = $this->optionAuthorDescription();
            $this->view->link_author = $this->content->setLink('catalogue/optionauthor');
            $this->view->link_r_author_temp = $this->content->setLink('catalogue/readauthortemp');
            $this->view->link_d_author_temp = $this->content->setLink('catalogue/deleteauthortemp');

            $this->view->ddc_level1 = $this->optionDdc(1);
            $this->view->link_ddc_level2 = $this->content->setLink('catalogue/optionddclevel2');
            $this->view->link_r_ddc = $this->content->setLink('catalogue/readddc');

            $this->view->render('catalogue/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
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

            $this->view->link_back = $this->content->setLink('catalogue');
            $this->view->link_print_barcode = $this->content->setLink('catalogue/printBarcode/' . $id);
            $this->view->link_print_label = $this->content->setLink('catalogue/printLabel/' . $id);
            $this->view->link_r_collection = $this->content->setLink('catalogue/readcollectionbook/' . $id);
            $this->view->link_p_collection = $this->content->setLink('catalogue/addprintbarcode');
            $this->view->link_pl_collection = $this->content->setLink('catalogue/printlistbarcode');
            $this->view->render('catalogue/detail');
        }
    }

    public function printListBarcode() {
        Web::setTitle('Daftar Print Barcode');
        $this->view->link_r = $this->content->setLink('catalogue/readprintlistbarcode');
        $this->view->link_p = $this->content->setLink('catalogue/printbarcode');
        $this->view->link_d = $this->content->setLink('catalogue/deleteprintlistbarcode');
        $this->view->link_da = $this->content->setLink('catalogue/deleteprintlistbarcodeall');
        $this->view->render('catalogue/printlistbarcode');
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

    public function create() {
        if ($this->model->createSave()) {
            $ket = '{sucess:1, reset:1, html: "' . base64_encode($this->message->saveSucces()) . '"}';
        } else {
            $ket = '{sucess:0, reset:0, html: "' . base64_encode($this->message->saveError()) . '" }';
        }
        echo $ket;
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

                $link_edit = $this->content->setLink('catalogue/edit/' . $row['book_id']);
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

                $description = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
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
                $xml .= "<cell><![CDATA[<a href='" . $link_edit . "'>Edit</a> | <a href='" . $link_detail . "'>Detail</a>]]></cell>";
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
                $xml .= "<cell><![CDATA[<a href=''>Edit</a>]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readLanguageTemp() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectLanguageTemp($page);
            $total = $this->model->countLanguageTemp();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {
                $xml .= "<row id='" . $row['book_language_temp_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_language_temp_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['language_name'] . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readPublisher() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllPublisher($page);
            $total = $this->model->countAllPublisher();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {
                $xml .= "<row id='" . $row['publisher_office_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_description'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['publisher_office_department_name'] . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readAuthorTemp() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllAuthorTemp($page);
            $total = $this->model->countAllAuthorTemp();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {
                $xml .= "<row id='" . $row['book_author_temp_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_author_temp_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['author_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['author_description_title'] . "]]></cell>";
                $satus = '-';
                if ($row['book_author_temp_primary'])
                    $satus = 'Primary';
                $xml .= "<cell><![CDATA[" . $satus . "]]></cell>";
                $linkset = '-';
                if (!$row['book_author_temp_primary'] && $row['author_description_level'] == 1)
                    $linkset = '<a href="#setprimary" rel="' . $row['book_author_temp_id'] . '">Set Primary</a>';
                $xml .= "<cell><![CDATA[" . $linkset . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readDdc() {
        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllDdc($page);
            $total = $this->model->countAllDdc();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {
                $xml .= "<row id='" . $row['ddc_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['ddc_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['ddc_classification_number'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<div>" . $row['ddc_title'] . "</div><div>" . $row['ddc_description'] . "</div>]]></cell>";
                $xml .= "<cell><![CDATA[-]]></cell>";
                $xml .= "<cell><![CDATA[-]]></cell>";
                $xml .= "</row>";
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
        $this->model->delete();
    }

    public function optionLanguage() {
        $data = $this->model->selectLanguage();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['language_id']] = $value['language_name'];
            }
        }

        //$list[-1] = 'Lainnya...';

        return $list;
    }

    public function optionAccountingSymbol() {
        $data = $this->model->selectAccountingSymbol();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['accounting_symbol_id']] = $value['accounting_symbol_title'] . ' (' . $value['accounting_symbol'] . ')';
            }
        }
        return $list;
    }

    public function optionBookResource() {
        $data = $this->model->selectBookResource();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['book_resource_id']] = $value['book_resource_title'];
            }
        }
        return $list;
    }

    public function optionBookFund() {
        $data = $this->model->selectBookFund();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['book_fund_id']] = $value['book_fund_title'];
            }
        }
        return $list;
    }

    public function optionCountry() {
        $data = $this->model->selectCountry();
        $list = array();
        if ($data) {
            foreach ($data as $value) {
                $list[$value['country_id']] = $value['country_name'];
            }
        }
        return $list;
    }

    public function optionAuthorDescription() {
        $data = $this->model->selectAllAuthorDescription();
        $list = array();
        foreach ($data as $value) {
            $list[$value['author_description_id']] = $value['author_description_title'];
        }
        return $list;
    }

    public function optionAuthor() {
        $option = '';
        $countryid = $this->method->get('id');
        $listprovince = $this->model->selectAuthorByDescrtiptionId($countryid);
        foreach ($listprovince as $row) {
            $option .= '<option value="' . $row['author_id'] . '">' . $row['author_name'] . '</option>';
        }
        $option .= '<option value="-1">Lainnya...</option>';
        echo json_encode($option);
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

    public function getAuhtorPrimaryTemp() {
        $list_author_temp = $this->model->selectAuthorPrimaryTemp();
        $count_author_temp = count($list_author_temp);
        $primary_status = false;
        $primary_name = array();

        foreach ($list_author_temp as $value) {
            if ($value['book_author_temp_primary']) {
                $primary_status = true;
                $primary_name['first_name'] = $value['author_firstname'];
                $primary_name['last_name'] = $value['author_lastname'];
            }
        }

        echo json_encode(array('count' => $count_author_temp, 'primary' => array('status' => $primary_status, 'name' => $primary_name)));
    }

    public function getAuhtorTemp() {
        $this->setAuthorTemp();

        // Author
        $outAuthor = '';
        $countAuthor = 0;
        $tempCount = 0;

        foreach ($this->dataAuthorTempDescription as $keyAD => $valueAD) {
            $res = $this->parsingAuthorTemp($keyAD);

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

    public function printBarcode() {

        $data = $this->model->selectPrintBarcodeList();

        if (count($data) > 0) {


            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');

            // set default header data
            $pdf->SetHeaderData('', '', 'Print Barcode');

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

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

            foreach ($data as $value) {

                $pdf->write1DBarcode($value['book_temp_barcodeprint_register'], 'C128C', $posX, $posY, 44, 18, 0.4, $style, '');

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

            //Close and output PDF document
            $pdf->Output('Barcode_' . date('dmYHis') . '.pdf', 'I');
        } else {
            echo 'Maaf Daftar Print Tidak Ditemukan!';
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
            $resolution = array(210, 310);
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

    public function addLanguageTemp() {
        $isother = $this->method->post('other');
        $val = $this->method->post('val');

        if ($isother == 'yes') {
            $listLanguage = $this->model->selectLanguageByName($val);
            if ($listLanguage) {
                $dataLanguage = $listLanguage[0];
                $lastlanguageid = $dataLanguage['language_id'];
                if ($this->model->saveLanguageTemp($lastlanguageid)) {
                    $res = true;
                } else {
                    $res = false;
                }
            } else {
                if ($this->model->saveLanguage($val)) {
                    $lastlanguageid = $this->model->lastLanguageId();
                    if ($this->model->saveLanguageTemp($lastlanguageid)) {
                        $res = true;
                    } else {
                        $res = false;
                    }
                } else {
                    $res = false;
                }
            }
        } else {
            if ($this->model->saveLanguageTemp($val)) {
                $res = true;
            } else {
                $res = false;
            }
        }

        echo json_encode($res);
    }

    public function deleteLanguageTemp() {
        $res = false;

        $listemptlanguage = $this->model->selectLanguageTempById();
        $languageid = '0';
        foreach ($listemptlanguage as $rowlanguage) {
            $languageid .= ',' . $rowlanguage['book_language'];
        }

        if ($this->model->deleteLanguageTemp()) {
            $this->model->deleteLanguage($languageid);
            $res = true;
        }
        echo json_encode($res);
    }

    public function optionProvince() {
        $option = '<option value=""></option>';
        $countryid = $this->method->get('id');
        $listprovince = $this->model->selectProvinceByCountryId($countryid);
        foreach ($listprovince as $row) {
            $option .= '<option value="' . $row['province_id'] . '">' . $row['province_name'] . '</option>';
        }
        echo json_encode($option);
    }

    public function optionCity() {
        $countryid = $this->method->get('id');
        $listcity = $this->model->selectCityByProvinceId($countryid);
        $option = '<option value=""></option>';
        foreach ($listcity as $value) {
            $option .= '<option value="' . $value['city_id'] . '">' . $value['city_name'] . '</option>';
        }
        echo json_encode($option);
    }

    public function addAuthorTemp() {
        $isother = $this->method->post('other');
        $authorid = $this->method->post('val');

        if ($isother == 'yes') {
            $listAuthor = $this->model->selectAuthorByNameAndAuthorDescription();
            if ($listAuthor) {
                $dataAuthor = $listAuthor[0];
                $authorid = $dataAuthor['author_id'];
                if ($this->model->saveAuthorTemp($authorid)) {
                    $res = true;
                } else {
                    $res = false;
                }
            } else {
                if ($this->model->saveAuthor()) {
                    $authorid = $this->model->lastAuthorId();
                    if ($this->model->saveAuthorTemp($authorid)) {
                        $res = true;
                    } else {
                        $res = false;
                    }
                } else {
                    $res = false;
                }
            }
        } else {
            if ($this->model->saveAuthorTemp($authorid)) {
                $res = true;
            } else {
                $res = false;
            }
        }

        echo json_encode($res);
    }

    public function deleteAuthorTemp() {
        $res = false;
        $id = $this->method->post('id');
        $listauthortemp = $this->model->selectAuthorTempById($id);
        $authorid = '0';
        foreach ($listauthortemp as $rowauthor) {
            $authorid .= ',' . $rowauthor['book_author_temp_name'];
        }

        if ($this->model->deleteAuthorTemp($id)) {
            $this->model->deleteAuthor($authorid);
            $res = true;
        }
        echo json_encode($res);
    }

    public function setPrimaryAuthor() {
        $res = false;
        $id = $this->method->post('val');
        if ($this->model->saveSetPrimaryAuthor('IN', $id, true)) {
            $this->model->saveSetPrimaryAuthor('NOT IN', $id, false);
            $res = true;
        }
        echo json_encode($res);
    }

    public function optionDdc($level) {
        $listddc = $this->model->selectDdcByLevel($level);
        $optionddc = array();
        foreach ($listddc as $rowddc) {
            $optionddc[$rowddc['ddc_id']] = '[' . $rowddc['ddc_classification_number'] . ']  ' . $rowddc['ddc_title'];
        }

        return $optionddc;
    }

    public function optionDdcLevel2() {
        $parentid = $this->method->get('id');
        $listddc = $this->model->selectDdcByParentId($parentid);
        $optionddc = '<option value=""></option>';
        foreach ($listddc as $rowddc) {
            $optionddc .= '<option value="' . $rowddc['ddc_id'] . '">' . '[' . $rowddc['ddc_classification_number'] . ']  ' . $rowddc['ddc_title'] . '</option>';
        }

        echo json_encode($optionddc);
    }

    public function addPrintBarcode() {
        if ($this->method->isAjax()) {
            Session::init();
            $sessionid = Session::id();
            $tempid = $this->method->post('id');
            foreach (explode(',', $tempid) as $key => $value) {
                $this->model->saveTempPrintBarcode($value, $sessionid);
            }
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function deletePrintListBarcode() {
        $res = false;
        if ($this->model->deletePrintListBarcode())
            $res = true;
        echo json_encode($res);
    }

    public function deletePrintListBarcodeAll() {
        $res = false;
        if ($this->model->deletePrintListBarcodeAll())
            $res = true;
        echo json_encode($res);
    }

}