<!-- 
Author : Ricardo Nunes Oliveira
Last modify on : 19.05.2017
Goal : Delete a QCM, redirect on succes, show error otherwise
Status : Finished 
-->

<?php
    include_once("qcmDao.inc.php");
    $idQcm = $_GET['idQcm'];
    $deleteReturn = QcmDao::DeleteQcmWithEvaluationByIdQcm($idQcm);
    if($deleteReturn)
        header('Location: main.php');
    else
    {
        print_r($deleteReturn);
        exit();
    }
?>