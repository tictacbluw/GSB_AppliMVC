<?php
/**
 * Vue Entête
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Thibaut PHILIPPS <th.philipps@laposte.net>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>

<div class="row">
    <div class="col-md-4">
        <form action="index.php?uc=gererFrais&action=validerFrais" method="post" role="form">
              <div class="form-group">
                    <label for="lstVisiteur" accesskey="n">Choisir le visiteur : </label>
                    <select id="lstVisiteur" name="lstVisiteur" class="selectpicker" data-live-search="true">
                    <?php
                    foreach ($listeVisiteur as $visiteur) {
                        $nom = $visiteur['nom'];
                        $prenom = $visiteur['prenom'];
                        $visiteurId = $visiteur['id'];
                        echo "<option value='". $visiteurId."' >".$nom." ".$prenom."</option>";
    
                    }?>    

                    </select>
                </div>
                <div class="form-group">
                    <label for="lstMois" accesskey="n">Mois : </label>
                    <select id="lstMois" name="lstMois" data-source="./includes/ajax.php?action=getmois&visiteur=test" data-valueKey="mois" data-displayKey="moisFomat"  class="form-control">    
                    </select>
                </div>
        </form>
    
    
    
    
    
    </div>

    
</div>

<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois 
         : <spawn id="dateMois"></spawn> </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <spawn id="libEtat"></spawn>
        depuis le <spawn id="dateModif" ></spawn> <br> 
        <strong><u>Montant validé :</u></strong><spawn id="montantValide"></spawn> €
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table id="tabElemForfait" class="table table-bordered table-responsive">
        <thead>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                <th> <?php echo htmlspecialchars($libelle) ?></th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
       <spawn id="justificatifs"></spawn> justificatifs reçus</div>
    <table id="tabHorsForfait" class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<spawn id="bouttonValider"><button type="button" class="btn btn-warning" id="paiementFicheFrais">Mettre en paiement la fiche de frais</button></spawn>