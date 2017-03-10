<?php

include_once 'qcmDao.inc.php';
$nomQcm = $_POST['nameQcm'];
$questions = $_POST['questions'];//a finir bug passer array en post
if (isset($nomQcm)) {
    $response_array['status'] = 'success';
    QcmDao::InsertQcm($nomQcm);
    foreach ($questions as $question) {
        QcmDao::InsertQuestion($question);
    }
} else {
    $response_array['status'] = 'error';
}
echo json_encode($response_array);



