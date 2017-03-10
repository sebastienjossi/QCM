<?php

class QcmController {

    private $_idQCM = null;
    private $_nameQCM = null;
    private $_questionsQCM = null;
    private $_reponsesQCM = null;

    function __construct($idQCM) {
        if (isset($idQCM)) {
            require_once './qcmDao.inc.php';
            $this->_idQCM = $idQCM;
            $this->_nameQCM = QcmDao::GetQcmById($idQCM)[0]['name'];

            $questions = QcmDao::GetQuestionsByIdQcm($idQCM);
            $this->_questionsQCM = array();
            $this->_reponsesQCM = array();

            foreach ($questions as $value) {
                $this->_questionsQCM[$value['id_question']] = $value['question'];
                $this->_reponsesQCM[$value['id_question']] = QcmDao::GetAnswersByIdQuestion($value['id_question']);
            }
        }
    }

    public function GetIdQCM() {
        return $this->_idQCM;
    }

    public function GetNameQCM() {
        return $this->_nameQCM;
    }

    public function SendAnswer($idUser, $idAnswer) {
        require_once './qcmDao.inc.php';
        UserDao::UserHasAnswer($idUser, $idAnswer);
    }

    /*
     * Utilisé sous forme de string il est donc pas 
     * nécessaire de retourner une array()
     */

    public function GetQuestionsById($id) {
        if (array_key_exists($id, $this->_questionsQCM)) {
            return $this->_questionsQCM[$id];
        }
    }

    /*
     * Utilisé sous forme de tableau pour un foreach
     * il est donc nécessaire de retourner une array()
     */

    public function GetAnswerById($id) {
        if (array_key_exists($id, $this->_reponsesQCM)) {
            return $this->_reponsesQCM[$id];
        } else {
            return array();
        }
    }

    public function MaxQuestion($numQuestion){
        return max(array_keys($this->_questionsQCM));
    }
    
    public function GetTitleHTML() {
       /* return '<title>Vous faites le QCM "' . $nomQCM . '"</title>';*/
    }

    public function GetHTMLCode($numQuestion) {
        $html = "";
        $html .= "<header>Question No"
                . $numQuestion
                . '</header>'
                . '<div id="question">Question:' . $this->GetQuestionsById($numQuestion) . '</div>';
        foreach ($this->GetAnswerById($numQuestion) as $value) {
            $html .= '<div class = "reponses">' . $value['answer'] . '</div>';
        }
        return $html;
    }

    /* public function SortAnswerByRandom(){
      shuffle($this->_reponsesQCM);
      } */
}

?>