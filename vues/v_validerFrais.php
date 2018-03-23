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
    
    

    <h2>Valider la fiche de frais</h2>   
    <h3>Eléments forfaitisés</h3>
    
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" id="majElemForfait">Valider</button>
                <button class="btn btn-danger"  id="resetElemForfait">Réinitialiser</button>
            </fieldset>

    </div>
</div>
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table id="tabHorsForfait" class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>

            </tbody>  
        </table>
    </div>

    <div>
        nombre de justificatifs :  <input type="text" name="nbJustificatifs" id="nbJustificatifs" class="form-control" style="width:40px">
    </div>
    <div>
        <button class="btn btn-success" id="validerFrais">Valider</button>
        <button class="btn btn-danger" id="ReinitialiserFrais">Réinitialiser</button>
    </div>
</div>
