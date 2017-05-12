<!DOCTYPE html>
<!-- 
Author : Zoé Cugni
Last modify on : 
Goal : 
Missing : 
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
        <div class="container container_horizontal">
            <div class="row horizontal">
                <div class="col-lg-12 text-center">
                    <h2>Liste des participants</h2>
                    <hr class="star-primary">
                    <?php 
                        require_once("qcmDao.inc.php");
                        $idEvaluation = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
                        $toDisplay = '';

                        foreach(EvaluationDao::GetEvaluationUser($idEvaluation) as $idUser){
                            $qcmId = EvaluationDao::GetQcmByEvaluation($idEvaluation)[0]['id_qcm'];
                            $toDisplay .= "<a href='evalResult.php?idQcm=" . $qcmId . "&idUser=". $idUser[0] . "' class='block'>" . UserDao::GetUserById($idUser[0])[0]['name'] . "</a>";
                        }

                        echo $toDisplay;
                    ?>
                </div>
            </div>
            <div class="row horizontal">
                <div class="col-lg-12 text-center">
                    <h2>% de réussite des questions</h2>
                    <hr class="star-primary">
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
</body>
</html>