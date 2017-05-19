<!-- 
Author : Ricardo Nunes Oliveira
Last modify on : 19.05.2017
Goal : Send all the answers for a given QCM
Status : Finished 
-->

<?php
    require_once('qcmDao.inc.php');
    $idQuestion = $_POST['idQuestion'];
    echo json_encode(QcmDao::GetAnswersByIdQuestion($idQuestion));
?>