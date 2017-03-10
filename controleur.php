<?php

include_once 'qcmDao.inc.php';
$nomQcm = $_POST['nameQcm'];
$questions = $_POST['questions'];
$reponses = $_POST['answers'];
if (isset($nomQcm)&& isset($reponses) && isset($questions)) {
    $response_array['status'] = 'success';
    QcmDao::InsertQcm($nomQcm);
    foreach ($questions as $question) {
        QcmDao::InsertQuestion($question);
        foreach ($reponses as $reponse){
            QcmDao::InsertAnswer($reponse['textAnswer'], $reponse['rightAnswer']);
        }
    }
} else {
    $response_array['status'] = 'error';
}
echo json_encode($response_array);



