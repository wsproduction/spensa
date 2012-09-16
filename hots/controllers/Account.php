<?php

class Account extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();
        if (!Session::get('loginStatus')) {
            $this->url->redirect('http://' . Web::$host . '/signin');
            exit;
        }
        $this->view->hotsSubject = $this->content->hotsSubject();

        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryBase64();
    }

    public function index() {
        Web::setTitle('Account');
        $this->view->listProject = $this->listDataProject();
        $this->view->render('account/index');
    }

    public function listDataProject($page = 1) {
        $maxRows = 1;
        $countList = $this->model->countAllProject();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 4;

        $ddcList = $this->model->selectAllProject(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['answer_id'];
                $id .= ',' . $tmpID;

                $html .= '<tr>';
                $html .= '  <td class="first">' . URL::link('http://' . Web::$host . '/project/view/' . $tmpID, $value['subject_title'], 'attach') . '</td>';
                $html .= '           <td style="text-align: center;">' . date('d/m/Y', strtotime($value['question_start_date'])) . ' - ' . date('d/m/Y', strtotime($value['question_end_date'])) . '</td>
                            <td style="text-align: center;">' . date('d/m/Y', strtotime($value['answer_date'])) . '</td>
                            <td style="text-align: center;">' . $value['answer_status'] . '</td>
                            <td style="text-align: center;">';
                Form::create('button');
                Form::value('Submit');
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '</tr>';

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

    public function changePassword() {
        if ($this->model->cekPassword()) {
            if ($this->model->saveChangePassword()) {
                echo '{s:1,msg:"' . base64_encode($this->message->saveSucces()) . '"}';
            } else {
                echo '{s:2,msg:"' . base64_encode($this->message->saveError()) . '"}';
            }
        } else {
            echo '{s:3,msg:"' . base64_encode('<label for="old_password" generated="true" class="error" style="">Password was incorrect.</label>') . '"}';
        }
    }
    
    public function changeAvatar() {
        if ($this->model->saveAvatar()) {
            
        } else {
            
        }
    }

}