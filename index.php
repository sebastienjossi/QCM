<?php

include_once("qcmDao.inc.php");

$test = new QcmPdo("127.0.0.1", "db_qcm", "wikbergs", "1234");

echo "<pre>";
print_r(UserDao::GetUsers($test));
echo "</pre>";