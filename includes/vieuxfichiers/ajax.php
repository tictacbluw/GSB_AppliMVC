<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('class.pdogsb.inc.php');
include('fct.inc.php');
$pdo = PdoGsb::getPdoGsb();

$actionGet = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($actionGet) {
    case 'getMois':
         $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
         $moisDisponnibles = $pdo->getLesMoisDisponibles($idVisiteur);
         echo (json_encode($moisDisponnibles));
         break;

    case 'getLesFraisForfait':
         $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
         $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
         $LesFraisForfait = $pdo->getLesFraisForfait($idVisiteur,$mois);
         echo (json_encode($LesFraisForfait));
        break;
 
        case 'getLesFraisHorsForfait':
         $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
         $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
         $LesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
         echo (json_encode($LesFraisHorsForfait));
        break;
        
        case 'getNbJustificatifs':
        $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $LesNbJustificatifs = $pdo->getNbJustificatifs($idVisiteur,$mois);
        echo (json_encode($LesNbJustificatifs));
       break; 

       case 'setLesFraisForfait':
        $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $etp = filter_input(INPUT_GET, 'ETP', FILTER_SANITIZE_STRING);
        $km = filter_input(INPUT_GET, 'KM', FILTER_SANITIZE_STRING);
        $nui = filter_input(INPUT_GET, 'NUI', FILTER_SANITIZE_STRING);
        $rep = filter_input(INPUT_GET, 'REP', FILTER_SANITIZE_STRING);
        $lesFrais = array(
            "ETP" => $etp,
            "KM" => $km,
            "NUI" => $nui,
            "REP" => $rep
        );
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);


       break; 

       case 'validerFicheFrais':
       $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
       $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
       $etat = "VA";
       $pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);


      break; 

      case 'refuserLigneHorsForfait':
      $idFrais = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
      $pdo->refuserFraisHorsForfait($idFrais);


     break; 

     case 'majLigneHorsForfait':
     $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
     $date = dateFrancaisVersAnglais(filter_input(INPUT_GET, 'date', FILTER_SANITIZE_URL));
     $montant = floatval(filter_input(INPUT_GET, 'montant', FILTER_SANITIZE_STRING));
     $libelle = filter_input(INPUT_GET, 'libelle', FILTER_SANITIZE_STRING);
     $pdo->majFraisHorsForfait($id, $date, $libelle, $montant);


    break; 


   case 'getLesInfosFicheFrais':
   $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
   $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
   $infosFiche = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);

   echo (json_encode($infosFiche));
 

  break; 



  case 'paiementFicheFrais':
    $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
    $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $etat = "MP";  
    $pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);

 break; 
 
  case 'remboursementFicheFrais':
    $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
    $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $etat = "RB";  
    $pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);

break; 

case 'renvoyerMoisSuivant':
    $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $tmpdate = str_split($mois, 4);
    $tmpdate[1] += 1;
    if($tmpdate[1] < 10){
        $tmpdate[1] = "0".$tmpdate[1];
    }
    $mois = $tmpdate[0].$tmpdate[1];  

    if($pdo->estPremierFraisMois($idVisiteur, $mois) == true){
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
        
    }
    $ligneHorsForfaitARenvoyer = $pdo->getLesFraisHorsForfaitParId($id);
    $pdo->supprimerFraisHorsForfait($id);
    $libelle = $ligneHorsForfaitARenvoyer[0]["libelle"];
    $date = $ligneHorsForfaitARenvoyer[0]["date"];
    $montant = $ligneHorsForfaitARenvoyer[0]["montant"];
    $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant);




break; 

    default:
        echo 'ERREUR';
        break;
}






?>