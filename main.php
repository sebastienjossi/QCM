<!DOCTYPE html>
<!-- 
Author : Zoé Cugni
Last modify on : 17.03.2017
Goal : Main page. Here, the user can visualize the qcm he created and the evaluation he passed
Missing : For now, the idUser is written directly, but it should take the one of the user in session. It hasn't been done because the login isn't yet finish
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Freelancer - Start Bootstrap Theme</title>
        
        <!-- Bootstrap Core CSS -->
        <link href="TemplateQCM/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="TemplateQCM/css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="TemplateQCM/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="TemplateQCM/css/style.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="page-top" class="index">
    
	<?php 
        session_start();
        include 'header.html'; 
    ?>
    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Mes QCMs</h2>
                    <hr class="star-primary">
                    <table class="table table-hover table-fixed">
                        <thead>
                            <th>Nom QCM</th>
                            <th>Date de création</th>
                            <th>Modifer</th>
                            <th>Supprimer</th>
                            <th>Gérer les évaluations</th>
                        </thead>

                        <?php
                            require_once("qcmDao.inc.php");
                            $toDisplay= '';
                            foreach(QcmDao::GetQcmByIdCreator($_SESSION['IdUser']) as $qcm) 
                                 echo '<tr><td>' . $qcm['name'] . '</td><td>' . $qcm['creation_date'] . '</td><td><a href="modifyQcm.php?id=' . $qcm['id_qcm'] . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td><td><a onclick="return myDelete(' . $qcm['id_qcm'] . ')" href=""><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td><td><a href="manageEval.php?id='. $qcm['id_qcm'] . '">Gérer les évaluations</a></td></tr>';
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Mes résultats aux évaluations</h2>
                    <hr class="star-primary">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Evaluation</th>
                                <th>Qcm</th>
                                <th>Code d'accès</th>
                                <th>Voir les résultats</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $idUser = 2; //Prendre de la session
                                $evaluations = EvaluationDao::GetEvaluationByIdUser($idUser);

                                for($i = 0; $i < count($evaluations); $i++)
                                    $evaluations[$i]['qcmName'] = QcmDao::GetQcmById($evaluations[$i]['id_qcm'])['name'];

                                $toDisplay = '';
                                foreach($evaluations as $eval){
                                    $toDisplay .= '<tr>';
                                    $toDisplay .= '<td>' . $eval['name'] . '</td>';
                                    $toDisplay .= '<td>' . $eval['qcmName'] . '</td>';
                                    $toDisplay .= '<td>' . $eval['access_code'] . '</td>';
                                    $toDisplay .= '<td><a href="evalResult.php?idQcm=' . $eval['id_qcm'] . '" alt="Voir les résultats">Voir les résultats</a>';
                                    $toDisplay .= '</tr>';
                                }

                                echo $toDisplay;
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.html'; ?>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    <script>
    function myDelete(idQcm){
        if(confirm("Voulez-vous vraiment supprimer ce QCM ?\rToutes les évaluations vont également être supprimées.\rCette action est irréversible.")){
            window.location.href = "deleteQcm.php?idQcm=" + idQcm;
            return false;
        }
    }
  </script>
</body>
</html>