<!-- 
 Nom : Pierrick et Christophe
 Date : 17.03.2017
 Descritpion : liste des QCM d'un utilisateur
 -->
<?php
include_once("qcmDao.inc.php");
?>
<!DOCTYPE html>
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
        <link href="Template QCM/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custion CSS -->
        <link rel="stylesheet" href="TemplateQCM/css/style.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    </head>
    <body id="page-top" class="index">
        <?php include 'header.html'; ?>
        <!-- Header -->
        <header>
        </header>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-text">
                            <table class="table">
                                <tr>
                                    <th>Nom du QCM</th>
                                    <th>Date de création</th>
                                    <th>Nombre de question</th>
                                </tr>
                                <?php
                                // REMPLACER LE 2 PAR LA VARIABLE DE SESSION DE L'ID USER
                                foreach (UserDao::GetQcmByIdUser(2) as $value) {
                                    foreach (QcmDao::CountQuestionByIdQcm($value['id_qcm']) as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo '<a style="color: white;" href = "infoQcm.php?id=' . $value['id_qcm'] . '">' . $value['name'] . ''; ?></td>
                                            <td><?php echo $value['creation_date']; ?></td>
                                            <td><?php echo $row['nbrQuest']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php include 'footer.html'; ?>
        
    <!-- jQuery -->
    <script src="TemplateQCM/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="TemplateQCM/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="TemplateQCM/js/freelancer.min.js"></script>
    </body>
</html>