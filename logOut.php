<!--
        Florent Jaquerod
        IFA-P3C
        2016
-->
<?php
session_start();
$_SESSION['connect'] = NULL;
header("location: index.php");
