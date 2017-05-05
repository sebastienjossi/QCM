<?php
$login = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
$pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$mdp = sha1($pwd);
//password hash
//password verify
require_once("qcmDao.inc.php");

if (!isset($_SESSION['connect']))
    $_SESSION['connect'] = NULL;

foreach (UserDao::GetUsers() as $row) {
    if ($login == $row['email'] && $mdp == $row['password']) {
        $_SESSION['connect'] = 1;
        $_SESSION['IdUser'] = $row['id'];
        $_SESSION['email'] = $row['email'];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Our css -->
        <link href="TemplateQCM/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <h2 class="login-h2">Register</h2>
                                <hr class="star-primary">
                                <div class="login-form">

                                    <div class="container">
                                        <form class="form-horizontal" method="POST" action="parrot.php">
                                            <div class="form-group">                    
                                                <div class="col-sm-4">
                                                    <input  value="<?php
                                                    if (isset($name)) {
                                                        echo $name;
                                                    }
                                                    ?>" type="text" class="form-control" id="name" name="name" placeholder="name">
                                                </div>
                                                <?php if (!empty($erreur['name'])) { ?>
                                                    <div id="erreur" class="col-sm-5" class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">Error:</span>
                                                        <?php echo $erreur['name']; ?>  </div>  <?php } ?>
                                            </div>

                                            <div class="form-group">                    
                                                <div class="col-sm-4">
                                                    <input  value="<?php
                                                    if (isset($fname)) {
                                                        echo $fname;
                                                    }
                                                    ?>" type="text" class="form-control" id="fname" name="fname" placeholder="first name">
                                                </div>
                                                <?php if (!empty($erreur['$fname'])) { ?>
                                                    <div id="erreur" class="col-sm-5" class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">Error:</span>
                                                        <?php echo $erreur['$fname']; ?>  </div>  <?php } ?>
                                            </div>


                                            <div class="form-group">            
                                                <div class="col-sm-4">
                                                    <input value="<?php
                                                    if (isset($email)) {
                                                        echo $email;
                                                    }
                                                    ?>" type="text" class="form-control" id="email" name="email" placeholder="Email">
                                                </div>
                                                <?php if (!empty($erreur['email'])) { ?>
                                                    <div id="erreur" class="col-sm-5" class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">Error:</span>
                                                        <?php echo $erreur['email']; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">                    
                                                <div class="col-sm-4">
                                                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe">
                                                </div>
                                                <?php if (!empty($erreur['pwd'])) { ?>
                                                    <div id="erreur" class="col-sm-5" class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only"></span>
                                                        <?php echo $erreur['pwd']; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">                    
                                                <div class="col-sm-4">
                                                    <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Confirmation Mot de passe">
                                                </div>
                                                <?php if (!empty($erreur['pwd'])) { ?>
                                                    <div id="erreur" class="col-sm-5" class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only"></span>
                                                        <?php echo $erreur['pwd']; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-1 col-sm-5">
                                                    <input type="submit" name="submit"></input>                     
                                                </div>
                                            </div>
                                            </body>
                                            </html>
