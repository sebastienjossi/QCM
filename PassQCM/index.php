<?php
/*
  Style, forme générale (HTML, CSS): Sirey Loïc
  Script, PHP: Dürrenmatt Cédric
 */
$idQCM = filter_input(INPUT_GET, 'idQ', FILTER_SANITIZE_NUMBER_INT); //id du QCM
if (!isset($idQCM) || $idQCM == null) {
    header("Location: BACK.php"); //Renvoyer à la page de sélection de QCM
    exit();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>QCM</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>    

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- our css -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body id="qcmPage">
        <?php include 'header.html'; ?>
        <section id="layout">
            <ul>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
                <li>Question 1</li>
                <li>Question 2</li>
            </ul>
        </section>
        <section class="center-block qcm">
            <div id="content">

            </div>
            <nav id="nav"><button id="back" class="btn btnPagination">Précédent</button><button id="next" class="btn btnPagination">Suivant</button></nav>
        </section>
        <script>
            $(document).ready(function () {
                //Etape du QCM
                i = 1;
                //Appelle une fonction pour savoir le numéro de la dernière question
                GetMaxQuestion();
                //Remplace le contenu avec le "i" initialisé avant
                ReplaceContent();
                //Cache le bouton avec l'id "back"
                $("#back").css("visibility", "hidden");

                $("#back").click(function () {
                    //Si c'est pas la première question
                    if (i > 1) {
                        //On revient en arrière
                        i -= 1;
                        //on change le contenu
                        ReplaceContent();
                        //Si après c'est la première question
                        if (i === 1) {
                            //Cache le bouton avec l'id "back"
                            $("#back").css("visibility", "hidden");
                        }
                    }
                    //On remet le text du button avec l'id "next" normal (plus terminé)
                    $("#next").text("Suivant");
                });
                $("#next").click(function () {
                    //Montre le bouton avec l'id "back"
                    $("#back").css("visibility", "");
                    // Si la question était la dernière question (ou plus)
                    if (i >= nbQuestion) {
                        //on redirige sur une autre page
                        document.location.href = "back.php";
                    }
                    else { //Si ce n'est pas la dernière question
                        //On avance dans les questions
                        i += 1;
                        //on change le contenu
                        ReplaceContent();
                    }

                    //Si la question est la dernière du QCM
                    if (i.toString() === nbQuestion) {
                        //On change le texte du button avec l'id "next"
                        $("#next").text("Terminé");
                    }
                });

                function GetMaxQuestion() {
                    $.ajax({
                        url: "GetHTML_PassQCM_ByAjax.php",
                        type: 'POST',
                        dataType: 'text',
                        data: {
                            idQ: <?php echo $idQCM ?>,
                            action: 'GetMaxQuestion'
                        },
                        success: function (result) {
                            //nbQuestion est la variable contenant l'id de la dernière question
                            nbQuestion = result;
                        }});
                }

                function ReplaceContent() {
                    $.ajax({
                        url: "GetHTML_PassQCM_ByAjax.php",
                        type: 'POST',
                        dataType: 'text',
                        data: {
                            idQ: <?php echo $idQCM ?>,
                            numQ: i,
                            action: 'GetInfos'
                        },
                        success: function (result) {
                            //Change le contenu du div avec l'id "content"
                            $("#content").html(result);
                        }});
                }
            });
        </script>
        <?php include 'footer.html'; ?>    
    </body>
</html>
