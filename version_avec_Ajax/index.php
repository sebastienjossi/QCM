<?php
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
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="content">
        </div>
        <nav id="navPassQCM"><button id="back">Précédent</button><button id="next">Suivant</button></nav>
        <script>
            $(document).ready(function () {
                i = 1;
                $.ajax({
                    url: "GetHTML_PassQCM_ByAjax.php",
                    type: 'POST',
                    dataType: 'text',
                    data: {
                        idQ: <?php echo $idQCM ?>,
                        numQ: i
                    },
                    success: function (result) {
                        $("#content").html(result);
                    }});

                $("#back").click(function () {
                    if (i > 1) {
                        i -= 1;
                        ReplaceContent();
                    }
                });

                $("#next").click(function () {
                    i += 1;
                    ReplaceContent();
                });

                function ReplaceContent() {
                    $.ajax({
                        url: "GetHTML_PassQCM_ByAjax.php",
                        type: 'POST',
                        dataType: 'text',
                        data: {
                            idQ: <?php echo $idQCM ?>,
                            numQ: i
                        },
                        success: function (result) {
                            $("#content").html(result);
                        }});
                }
            });
        </script>
    </body>
</html>
