<?php

class Subject extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        $this->view->hotsSubject = $this->content->hotsSubject();

        Src::plugin()->elrte();
        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryBase64();
    }

    public function index() {
        Web::setTitle('Beranda');
        $this->view->render('laporan/guru');
    }

    public function view($id = 0) {
        $subject = $this->model->selectSubjectById($id);
        Web::setTitle('List of ' . $subject[0]['subject_title'] . ' Question');
        $this->view->listDataQuestion = $this->listDataQuestion($id);
        $this->view->render('subject/view');
    }

    public function follow($id = 0) {

        if (!Session::get('loginStatus')) {
            $this->url->redirect('http://' . Web::$host . '/signin');
            exit;
        }

        $dataAnswer = $this->model->cekProject($id);
        if ($dataAnswer) {
            if (count($dataAnswer) > 0) {
                $this->url->redirect('http://' . Web::$host . '/project/view/' . $dataAnswer[0]['answer_id']);
            }
        }

        $subject = $this->model->selectSubjectById($id);
        Web::setTitle('Follow of ' . $subject[0]['subject_title'] . ' Question');

        $listDataQuestion = $this->model->selectDataQuestionByID($id);
        $this->view->listDataQuestion = $listDataQuestion[0];

        $this->view->countFollower = $this->model->countFollowers($id);
        $this->view->questionID = $id;

        $this->view->answer = $this->model->selectMyAnswer($id);

        $this->view->render('subject/follow');
    }

    public function listDataQuestion($id = 0, $page = 1) {
        $maxRows = 1;
        $countList = $this->model->countAllQuestion($id);
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 4;

        $ddcList = $this->model->selectAllQuestion($id, ($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['question_id'];
                $id .= ',' . $tmpID;

                $range = 0;

                Form::create('button');
                Form::value('Follow');
                Form::style('optFollowDisabled');
                Form::properties(array('disabled' => 'disabled'));
                $btnFollow = Form::commit('attach');

                if ($value['range_date'] > 0) {
                    $range = $value['range_date'];

                    Form::create('button');
                    Form::value('Follow');
                    Form::style('optFollow');
                    Form::properties(array('link' => 'http://' . Web::$host . '/subject/follow/' . $tmpID));
                    $btnFollow = Form::commit('attach');
                }

                $html .= '<div class="box-content">
                            <div class="box-main">
                                <div class="box-time">';
                $html .= '          <div class="count-down"><div>' . $range . '</div>Days a go</div>';
                $html .= '          <div class="box-info">
                                        <table>
                                            <tr>
                                                <th>Periode</th>
                                                <td>' . date('d/m/Y', strtotime($value['question_start_date'])) . ' - ' . date('d/m/Y', strtotime($value['question_end_date'])) . '</td>
                                            </tr>
                                            <tr>
                                                <th>Follower</th>
                                                <td>2</td>
                                            </tr>
                                        </table>
                                    </div>';
                $html .= '          <div class="cl">&nbsp;</div>
                                </div>';
                $html .= '      <div class="box-qustion">
                                    <fieldset>
                                        <legend>Question</legend>
                                        ' . $value['question_description'] . '
                                    </fieldset>
                                </div>';
                $html .= '  </div>
                            <div class="cl">&nbsp;</div>
                            <div class="box-button">';
                $html .= '      <div class="left">' . date('l, d.m.Y',  strtotime($value['question_entry'])) . ' | Posted by admin</div>
                                <div class="right">';
                $html .= $btnFollow;
                $html .= '      </div>
                             </div>
                             <div class="cl">&nbsp;</div>
                           </div>';

                $idx++;
            }

            //$html .= $this->content->paging($jumlah_kolom, $countPage, $page);

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

    public function answer() {
        if ($this->model->answerSave()) {
            $re = '{s:1, link: "' . base64_encode('http://' . Web::$host . '/account') . '"}';
        } else {
            $re = '{s:1}';
        }
        echo $re;
    }

}