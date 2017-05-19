<!DOCTYPE html>
<!-- 
Author : Zoé Cugni
Last modify on : 17.03.2017
Goal : Let the user manage and create evaluation for his qcm
Missing : Nearly everything, i just created this page and implemented the style.
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
    
	<?php include 'header.html'; ?>

    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Evaluations pour ce qcm</h2>
                    <hr class="star-primary">
                    <table class="table table-hover">
                        <thead><tr>
                            <th>Nom</th>
                            <th>Code d'accès</th>
                            <th>% de bonne réponse</th>
                            <th>Nombre de participants</th>
                            <th>Détails</th>
                        </thead></tr>
                    <?php 
                        require_once("qcmDao.inc.php");
                        $idQcm = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

                        $nbQuestion = QcmDao::CountQuestionByIdQcm($idQcm);
                        $toDisplay = '';
                        
                        foreach(EvaluationDao::GetEvaluationByIdQcm($idQcm) as $eval){ 
                            $toDisplay .= "<tr>";
                            $toDisplay .= "<td>" . $eval['name'] . "</td>";
                            $toDisplay .= "<td>" . $eval['access_code'] . "</td>";
                            $toDisplay .= "<td></td>";
                            $toDisplay .= "<td>" . EvaluationDao::GetNbUserByEvalutionId($eval['id_evaluation'])[0][0] . "</td>";
                            $toDisplay .= "<td><a href='evalDetail.php?id="  . $eval['id_evaluation'] . "'>Détails</a></td>";
                            $toDisplay .= "</tr>";
                        }

                        $idUser = 2; /* manage with session */
                        echo $toDisplay;
                    ?>
                    </table>
                    <form class="createQcm-qcm" id="generateEval" action="functions/generateEval.php" method="post">
                        <p>Générer une nouvelle évaluation :</p>
                        <div class="formBlock">
                            <label for="name">Nom :</label>
                            <input type="text" id="name" name="name" required></input>
                        </div>
                        <div class="formBlock">
                            <label for="accessCode">Code d'accès :</label>
                            <input type="text" readonly <?php echo 'value="' . uniqid() . '"'; ?> id="readonly" name="accessCode"></input>
                        </div>
                        <!-- needed for sql request, we know these values, no need to bother the user with them -->
                        <input type="text" name="idQcm" hidden <?php echo 'value="' . $idQcm . '"';?>></input>
                        <input type="text" name="idCreator" hidden <?php echo 'value="' . $idUser . '"';?>></input>

                        <input type="Submit" class="btn btn-default" value="Générer" id="generateBtn"></input>
                    </form>
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
    <script src="TemplateQCM/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="TemplateQCM/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="TemplateQCM/js/freelancer.min.js"></script>

    <script>
        $("#generateEval").submit(function(e){ 
            e.preventDefault(); 

            $.ajax({
            url : 'functions/generateEval.php',
            type : 'POST',
            data : $(this).serialize(),  
            dataType : 'html', //Type de retour (html, xml, json, text)
            success : function(data){ 
                location.reload();
            },
            error : function(jqXHR){ 
                alert(jqXHR.responseText);
            }
            });
        });
    </script>

    <!-- Create QCM button redirection -->
    <script>
        $("#creationButton").click(function(e){
            e.preventDefault();
            window.location = "/QCM/CreationQcm.php"; 
        });
    </script>
</body>
</html>