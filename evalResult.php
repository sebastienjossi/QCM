<!DOCTYPE html>
<!-- 
Author : Zoé Cugni
Last modify on : 17.03.2017
Goal : Let the user see his result on an evaluation he passed
Missing : I want to add the mark on this eval and maybe style the user answer in green/red when it's right/false
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
                    <?php
                        $idEval = filter_input(INPUT_GET, 'eval', FILTER_VALIDATE_INT);
                        $idQcm = filter_input(INPUT_GET, 'qcm', FILTER_VALIDATE_INT);

                        if($idQcm != false && $idEval != false){
                            require_once("qcmDao.inc.php");
                            $evalArray = EvaluationDao::GetEvaluationById($idEval);
                        } else {
                            header("Location: index.php");
                        }
                    ?>
                    <h2>Résultats pour l'évaluation : <?php echo $evalArray[0]["name"]; ?></h2>
                    <hr class="star-primary">
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Bonne réponse</th>
                            <th>Votre réponse</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $idUser = 3; /*quand ce sera fait, il faudra utiliser l'utilisateur en session */

                            $questionArray = qcmDao::GetQuestionsByIdQcm($idQcm);
                            $rightAnswerArray;
                            $userAnswerArray;
                            foreach($questionArray as $question){
                                $rightAnswerArray[] = qcmDao::GetRightAnswerByIdQuestion($question["id_question"]);
                                $userAnswerArray[] = userDao::GetAnswerFromUserById($idUser, $idQcm, $question["id_question"]);
                            }

                            $toDisplay = '';
                            for($i = 0; $i < count($questionArray); $i++){
                                $toDisplay .= '<tr>';
                                $toDisplay .= '<td>' . $questionArray[$i]['question'] . '</td>';
                                $toDisplay .= '<td>' . $rightAnswerArray[$i][0]['answer'] . '</td>';
                                $toDisplay .= '<td>' . $userAnswerArray[$i][0]['answer'] . '</td>';
                                $toDisplay .= '</tr>';
                            }

                            echo $toDisplay;
                        ?>
                    </tbody>
                </table>
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