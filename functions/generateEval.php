<?php 
require_once("../qcmDao.inc.php");
$name = filter_input(INPUT_POST, "name");
$accessCode = filter_input(INPUT_POST, "accessCode");
$idQcm = filter_input(INPUT_POST, "idQcm");
$idCreator = filter_input(INPUT_POST, "idCreator");

if($name != "false" && $accessCode != "false" && $idQcm != "false" && $idCreator != "false"){
     EvaluationDao::InsertEvaluation($name, $accessCode, $idQcm, $idCreator);
} else {
    echo "Problèmes avec les données fournies, contacter l'administrateur";
}