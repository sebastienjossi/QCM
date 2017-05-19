<?php

/* Durrenmatt Cédric */

class QcmController {

    private static $_idQCM = null;
    private static $_nameQCM = null;
    private static $_questionsQCM = null;
    private static $_reponsesQCM = null;

    private function __construct($idQCM) {
        if (isset($idQCM)) {
            require_once './qcmDao.inc.php';
            self::$_idQCM = $idQCM;
            self::$_nameQCM = QcmDao::GetQcmById($idQCM)[0]['name'];

            $questions = QcmDao::GetQuestionsByIdQcm($idQCM);
            self::$_questionsQCM = array();
            self::$_reponsesQCM = array();

            foreach ($questions as $value) {
                self::$_questionsQCM[$value['id_question']] = $value['question'];
                self::$_reponsesQCM[$value['id_question']] = QcmDao::GetAnswersByIdQuestion($value['id_question']);
            }
            unset($questions);
        }
    }

    public static function GetQcmController($idQCM) {
        if (isset(self::$_idQCM) && isset(self::$_nameQCM) && isset(self::$_questionsQCM) && isset(self::$_reponsesQCM)) {
            return $this;
        } else {
            return new QcmController($idQCM);
        }
    }

    public static function GetIdQCM() {
        return self::$_idQCM;
    }

    public static function GetNameQCM() {
        return self::$_nameQCM;
    }

    /*
     * Utilisé sous forme de string il est donc pas 
     * nécessaire de retourner une array()
     */

    public static function GetQuestionsById($id) {
        if (array_key_exists($id, self::$_questionsQCM)) {
            return self::$_questionsQCM[$id];
        }
    }

    /*
     * Utilisé sous forme de tableau pour un foreach
     * il est donc nécessaire de retourner une array()
     */

    public static function GetAnswerById($id) {
        if (array_key_exists($id, self::$_reponsesQCM)) {
            return self::$_reponsesQCM[$id];
        } else {
            return array();
        }
    }

    public static function MaxQuestion() {
        return max(array_keys(self::$_questionsQCM));
    }

    public static function GetHTMLCode($numQuestion) {
        $html = "";
        $html .= "<header>Question No"
                . $numQuestion
                . '<hr id="star-primary" class="star-primary"></hr>'
                . '</header>'
                . '<div id="question">' . self::GetQuestionsById($numQuestion) . '</div>';
        foreach (self::GetAnswerById($numQuestion) as $value) {
            $html .= '<button id="' . $value['id_answer'] . '" class="btn btn-default">' . $value['answer'] . '</button>';
        }
        return $html;
    }

    /* public function SortAnswerByRandom(){
      shuffle(self::$_reponsesQCM);
      } */
}

?>