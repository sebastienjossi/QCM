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
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custion CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body id="page-top" class="index">
    
	<?php include 'header.html'; ?>

    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Mes QCMs</h2>
                    <hr class="star-primary">
                    <table class="table table-hover">
                        <thead>
                            <th>ID QCM</th>
                            <th>Nom QCM</th>
                            <th>Date de création</th>
                            <th>Modifer</th>
                            <th>Supprimer</th>
                            <th>Gérer les évaluations</th>
                        </thead>

                        <?php
                            require_once("qcmDao.inc.php");
                            $toDisplay= '';
                            foreach(QcmDao::GetQcmByIdCreator(2) as $qcm)
                                echo '<tr><td>' . $qcm['id_qcm'] . '</td><td>' . $qcm['name'] . '</td><td>' . $qcm['creation_date'] . '</td><td><a href="modify.php?id=' . $qcm['id_qcm'] . '">Modifier</a></td><td><a href="delete.php?id=' . $qcm['id_qcm'] . '">Supprimer</a></td><td><a href="manageEval.php">Gérer les évaluations</a></td></tr>';
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Mes résultats aux évaluation</h2>
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
                                $idUser = 3; //Prendre de la session
                                $evaluations = EvaluationDao::GetEvaluationByIdUser($idUser);

                                for($i = 0; $i < count($evaluations); $i++)
                                    $evaluations[$i]['qcmName'] = QcmDao::GetQcmById($evaluations[$i]['id_qcm'])['name'];

                                $toDisplay = '';
                                foreach($evaluations as $eval){
                                    $toDisplay .= '<tr>';
                                    $toDisplay .= '<td>' . $eval['name'] . '</td>';
                                    $toDisplay .= '<td>' . $eval['qcmName'] . '</td>';
                                    $toDisplay .= '<td>' . $eval['access_code'] . '</td>';
                                    $toDisplay .= '<td><a href="evalResult.php?eval=' . $eval['id_evaluation'] . '&qcm=' . $eval['id_qcm'] . '" alt="Voir les résultats">Voir les résultats</a>';
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

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>
</body>
</html>