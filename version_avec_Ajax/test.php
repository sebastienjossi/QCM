<?php

require_once './qcm.controller.php';
$qcm = new QcmController(1);
print_r($qcm->GetIdQCM());
print_r($qcm->GetNameQCM());
print_r($qcm->GetQuestionsQCM());
print_r($qcm->GetReponsesQCM());