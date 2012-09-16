<?php

class Project extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        $this->view->hotsSubject = $this->content->hotsSubject();

        Src::plugin()->elrte();
        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryBase64();
    }

    public function view($id = 0) {

        if (!Session::get('loginStatus')) {
            $this->url->redirect('http://' . Web::$host . '/signin');
            exit;
        }

        $data = $this->model->selectAnswerById($id);

        if (count($data) > 0) {
            $this->view->listData = $data[0];
            $qid = $data[0]['question_id'];
            $subject = $this->model->selectSubjectById($qid);
            Web::setTitle('Project of ' . $subject[0]['subject_title'] . ' Question');

            $listDataQuestion = $this->model->selectDataQuestionByID($qid);
            $this->view->listDataQuestion = $listDataQuestion[0];

            $this->view->countFollower = $this->model->countFollowers($qid);

            $this->view->render('project/view');
        }
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
                $html .= '      <div class="left">Saturday, 10.09.2012 | Posted by admin</div>
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
        if ($this->model->answerUpdate()) {
            $re = '{s:1, link: "' . base64_encode('http://' . Web::$host . '/account') . '"}';
        } else {
            $re = '{s:1}';
        }
        echo $re;
    }

    public function deleteFile() {
        if ($this->model->deleteFile()) {
            $re = true;
        } else {
            $re = false;
        }
        echo json_encode($re);
    }

    public function download($filename = '') {
        $download_path = Web::path() . 'asset/upload/file/';
        $args = array(
            'download_path' => $download_path,
            'file' => $filename,
            'extension_check' => TRUE,
            'referrer_check' => FALSE,
            'referrer' => NULL,
        );
        $download = Src::plugin()->PHPDownloader();
        $download->set_args($args);
        $download_hook = $download->get_download_hook();
        if ($download_hook['download'] == TRUE) {
            /* Let's download file */
            $download->get_download();
        }
    }

}