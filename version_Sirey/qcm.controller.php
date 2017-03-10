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
            $this->_nomQCM = QcmDao::GetQcmById($idQCM)[0]['name'];
            $this->_questionsQCM = QcmDao::GetQuestionsByIdQcm($idQCM);
            $this->_reponsesQCM = QcmDao::GetAnswersByIdQuestion($this->_questionsQCM[0]['id_question']);
            
        }
    }

    public function GetIdQCM() {
        return $this->_idQCM;
    }

    public function GetNameQCM() {
        return $this->_nomQCM;
    }

    public function GetQuestionsQCM() {
        return $this->_questionsQCM;
    }

    public function GetReponsesQCM() {
        return $this->_reponsesQCM;
    }

}
?>