<?php
/**
 * Vue Entête
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<?php
if($_SESSION["typeCompte"]=="Comptable"){
    $libellePageFrais = "Valider les fiches de frais";
    $iconeSuivisFrais = '<span class="glyphicon glyphicon-euro"></span>';
    $libelleSuivisFrais = "Suivre le paiement des fiches de frais";
    $linkGererFrais = '<a href="index.php?uc=gererFrais&action=validerFrais">';
    $linkEtatFrais = '<a href="index.php?uc=etatFrais&action=suivrePaiement">';
} else {
    $libellePageFrais = "Renseigner la fiche de frais";
    $iconeSuivisFrais = '<span class="glyphicon glyphicon-list-alt"></span>';
    $libelleSuivisFrais = "Afficher mes fiches de frais";
    $linkGererFrais = '<a href="index.php?uc=gererFrais&action=saisirFrais">';
    $linkEtatFrais =  '<a href="index.php?uc=etatFrais&action=selectionnerMois">';
}        

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
        <title>Intranet du Laboratoire Galaxy-Swiss Bourdin</title> 
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
        <link href="./styles/style.css" rel="stylesheet">
        <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
              crossorigin="anonymous">
              
        </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</html>
        <script type="text/javascript" src="./includes/js/ajax.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
            $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
            if ($estConnecte) {
                ?>
            <div class="header">
                <div class="row vertical-align">
                    <div class="col-md-4">
                        <h1>
                            <img src="./images/logo.jpg" class="img-responsive" 
                                 alt="Laboratoire Galaxy-Swiss Bourdin" 
                                 title="Laboratoire Galaxy-Swiss Bourdin">
                        </h1>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav nav-pills pull-right" role="tablist">
                            <li <?php if (!$uc || $uc == 'accueil') { ?>class="active" <?php } ?>>
                                <a href="index.php">
                                    <span class="glyphicon glyphicon-home"></span>
                                    Accueil
                                </a>
                            </li>
                            <li <?php if ($uc == 'gererFrais') { ?>class="active"<?php } ?>>
                                    <?php echo $linkGererFrais; ?>
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    <?php echo $libellePageFrais; ?> 
                                </a>
                            </li>
                            <li <?php if ($uc == 'etatFrais') { ?>class="active"<?php } ?>>
                            
                                    <?php
                                    echo $linkEtatFrais;
                                    echo $iconeSuivisFrais;
                                    echo $libelleSuivisFrais; ?>
                                </a>
                            </li>
                            <li 
                            <?php if ($uc == 'deconnexion') { ?>class="active"<?php } ?>>
                                <a href="index.php?uc=deconnexion&action=demandeDeconnexion">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            } else {
                ?>   
                <h1>
                    <img src="./images/logo.jpg"
                         class="img-responsive center-block"
                         alt="Laboratoire Galaxy-Swiss Bourdin"
                         title="Laboratoire Galaxy-Swiss Bourdin">
                </h1>
                <?php
            }
