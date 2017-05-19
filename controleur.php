
<?php
/*
Dévleppeur : 
Loick Pipolo, Ivan Trifunovic
Description :
Controleur qui gère les données envoyer par le fichier CreationQcm.php
et les envoie dans la base de données
Date :
17.03.2017
Version :
1.0
*/
include_once 'qcmDao.inc.php';
$nomQcm = $_POST['nameQcm'];
$questions = $_POST['questions'];
$reponses = $_POST['answers'];
if (isset($nomQcm)&& isset($reponses) && isset($questions)) {
    $response_array['status'] = 'success';
    QcmDao::InsertQcm($nomQcm, 2); //USE THE SESSION VARIABLE!!
    $lastIDQcm = QcmPdo::GetPdo()->lastInsertId();
    $numQuestion = 0;
    foreach ($questions as $question) {
        $numQuestion = $numQuestion +1;
        QcmDao::InsertQuestion($question,$lastIDQcm);
        $lastIDQuestion = QcmPdo::GetPdo()->lastInsertId();
        foreach ($reponses as $reponse){
            if ($numQuestion == $reponse['numQuestion']) {
                QcmDao::InsertAnswer($reponse['textAnswer'], $reponse['RightAnswerBool'],$lastIDQuestion);
            }
        }
    }
} else {
    $response_array['status'] = 'error';
}
echo json_encode($response_array);