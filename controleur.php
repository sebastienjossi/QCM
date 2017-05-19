<!-- 
Author : Loick Pipolo, Ivan Trifunovic
Last modify on : 19.05.2017
Goal : Check the data sent by CreationQcm.php and insert them in the db
Status : Finished 
-->

<?php
include_once 'qcmDao.inc.php';
session_start();

$nomQcm = $_POST['nameQcm'];
$questions = $_POST['questions'];
$reponses = $_POST['answers'];

if (isset($nomQcm)&& isset($reponses) && isset($questions)) {
    $response_array['status'] = 'success';
    QcmDao::InsertQcm($nomQcm, $_SESSION['IdUser']); 
    $lastIDQcm = QcmPdo::GetPdo()->lastInsertId();
    $numQuestion = 0;

    foreach ($questions as $question) {
        $numQuestion = $numQuestion +1;
        QcmDao::InsertQuestion($question,$lastIDQcm);
        $lastIDQuestion = QcmPdo::GetPdo()->lastInsertId();

        foreach ($reponses as $reponse){
            if ($numQuestion == $reponse['numQuestion'])
                QcmDao::InsertAnswer($reponse['textAnswer'], $reponse['RightAnswerBool'],$lastIDQuestion);
        }
    }
} else {
    $response_array['status'] = 'error';
}
echo json_encode($response_array);