$( document ).ready(function() {


    var token = getToken();


/**
 * Evenement ce déclenchant lorsque la selection lstVisiteur change
 * Rempli la selection lstMois en fonction du visiteur selectionné dans la selection lstVisiteur
 */
    $( "#lstVisiteur" ).change(function() {
        var idVisiteur = $("#lstVisiteur").val();
        $('#lstMois').empty();
        $.getJSON('./includes/ajax.php?action=getMois&idVisiteur='+idVisiteur+'&token='+token, function(data){
            var html = '';
            var len = data.length;
            if (len ==0){
                html = '<option value=""></option>';
                alert("Pas de fiche de frais pour ce visiteur ce mois-ci'")
                $("input").prop("disabled", true);
                $("button.btn-success").prop("disabled",true);
                $("button.btn-danger").prop("disabled",true);
                $('input[name="lesFrais[ETP]"]').val(" ");
                $('input[name="lesFrais[KM]"]').val(" ");
                $('input[name="lesFrais[NUI]"]').val(" ");
                $('input[name="lesFrais[REP]"]').val(" ");


            } 
            for (var i = 0; i< len; i++) {
                html += '<option value="' + data[i].mois + '">' + data[i].numMois +'/'+ data[i].numAnnee + '</option>';
                $("button.btn-success").prop("disabled",false);
                $("button.btn-danger").prop("disabled",false);
                $("input").prop("disabled", false);
            }
            $('#lstMois').append(html);
        });

    
    })

/**
 * Evenement ce déclenchant lorsque la selection lstmois change
 * Charge la fiche de frais du mois selectionner dans lstMois et remplis les formulaires forfait et hors forfait correspondant
 */
    $( "#lstMois" ).click(function() {
        var params = getUrlParametres();
        var idVisiteur = $("#lstVisiteur").val();
        var mois = $("#lstMois").val();

        if (params.uc === 'gererFrais') {


            $('#tabHorsForfait tbody > tr').remove();
            $.getJSON('./includes/ajax.php?action=getLesFraisForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                $('#tabHorsForfait tbody > tr').remove();
                $('input[name="lesFrais[ETP]"]').val(data[0].quantite);
                $('input[name="lesFrais[KM]"]').val(data[1].quantite);
                $('input[name="lesFrais[NUI]"]').val(data[2].quantite);
                $('input[name="lesFrais[REP]"]').val(data[3].quantite);
             });

            $.getJSON('./includes/ajax.php?action=getLesFraisHorsForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
            var len = data.length;
                for (var i = 0; i< len; i++) {
                    $('#tabHorsForfait').append('<tr id="'+data[i].id+'"><td><input type="text" id=date_'+data[i].id+' value="'+data[i].date+'" class="form-control"></td><td><input type="text" id=libelle_'+data[i].id+' value="'+data[i].libelle+'" class="form-control"></td><td><input type="text" id=montant_'+data[i].id+' value="'+data[i].montant+'" class="form-control"></td><td><button class="btn btn-success" id="valider_'+data[i].id+'"onclick="corrigerHorsForfait('+data[i].id+')" >Corriger </button> <button class="btn btn-danger" id="refuser_'+data[i].id+'" onclick="refuserHorsForfait('+data[i].id+')">Refuser</button> <button class="btn btn-warning renvoyerrHorsForfait" id="refuser_'+data[i].id+'" onclick="renvoyerMoisSuivant('+data[i].id+')">Renvoyer au mois suivant</button></td></tr>');
                }
            });


            $.getJSON('./includes/ajax.php?action=getLesInfosFicheFrais&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                $('input[name="nbJustificatifs').val(data.nbJustificatifs);    
            });



        }
        if (params.uc === 'etatFrais'){
            $('#dateMois').empty();
            $('#dateMois').append($("#lstMois").text());

            $.getJSON('./includes/ajax.php?action=getLesInfosFicheFrais&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                $("#libEtat").empty();
                if (data.idEtat == 'MP'){
                    $("#bouttonValider").empty();
                    $("#bouttonValider").append('<button type="button" class="btn btn-success" id="remboursementFicheFrais" onclick="rembourserFicheFrais()">Valider le remboursement</button>');        
                }

                if(data.idEtat == 'RB')
                {
                    $("#bouttonValider").empty();
                    $("#bouttonValider").append('<button type="button" class="btn btn-info" id="remboursementFicheFrais" disabled>Remboursement effectué</button>'); 
                }
                $("#libEtat").append(data.libEtat);
                $("#dateModif").empty();
                $("#dateModif").append(data.dateModif); 
                $("#montantValide").empty();
                $("#montantValide").append(data.montantValide);
                $('#justificatifs').empty();
                $('#justificatifs').append(data.nbJustificatifs);                        

             });
            
            $.getJSON('./includes/ajax.php?action=getLesFraisForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                $('#tabElemForfait tbody > tr').remove(); 
                $('#tabElemForfait tbody').append('<tr><td>'+data[0].quantite+'</td><td>'+data[1].quantite+'</td><td>'+data[2].quantite+'</td><td>'+data[3].quantite+'</td></tr>');

             });




            $.getJSON('./includes/ajax.php?action=getLesFraisHorsForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                var len = data.length;
                $('#tabHorsForfait tbody > tr').remove(); 
                for (var i = 0; i< len; i++) {
                    $('#tabHorsForfait tbody').append('<tr><td>'+data[i].date+'</td><td>'+data[i].libelle+'</td><td>'+data[i].montant+'</td></tr>');
                }
            });
            /**
            * Evenement ce déclenchant lorsque l'on clique sur le bouton paiementFicheFrais
            * Met à jour l'état de la fiche de frais en remboursé
            */
            $("#paiementFicheFrais").click(function() {
                var idVisiteur = $("#lstVisiteur").val();
                var mois = $("#lstMois").val();
                $.ajax({
                    type:"GET",
                    cache:false,
                    url:"./includes/ajax.php?action=paiementFicheFrais&token="+token,
                    data:{ 'idVisiteur': idVisiteur , 'mois': mois },
                    success: function () {
                        alert("Mise à jour effectuée !");
                        $.getJSON('./includes/ajax.php?action=getLesInfosFicheFrais&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                            $("#libEtat").empty();
                            $("#libEtat").append(data.libEtat);
                            $("#dateModif").empty();
                            $("#dateModif").append(data.dateModif);
                            $("#bouttonValider").empty();
                            $("#bouttonValider").append('<button type="button" class="btn btn-success" id="remboursementFicheFrais" onclick="rembourserFicheFrais()">Valider le remboursement</button>');                  
            
                         });  
        
                    }
                  }); 
            });


        }
        
    })


/**
 * Evenement ce déclenchant lorsque l'on clique sur le bouton resetElemForfait
 * Réinitalise le formulaire Frais forfaitisés avec les valeurs par defaut de la fiche de frais
 */
    $("#resetElemForfait").click(function() {
        var idVisiteur = $("#lstVisiteur").val();
        var mois = $("#lstMois").val();
        $.getJSON('./includes/ajax.php?action=getLesFraisForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
            $('input[name="lesFrais[ETP]"]').val(data[0].quantite);
            $('input[name="lesFrais[KM]"]').val(data[1].quantite);
            $('input[name="lesFrais[NUI]"]').val(data[2].quantite);
            $('input[name="lesFrais[REP]"]').val(data[3].quantite);
        });


    });

/**
 * Evenement ce déclenchant lorsque l'on clique sur le bouton ReinitialiserFrais
 * Réinitalise les formulaire Frais forfaitisés et hors forfait avec les valeurs par defaut de la fiche de frais
 */
    $("#ReinitialiserFrais").click(function() {
        var idVisiteur = $("#lstVisiteur").val();
        var mois = $("#lstMois").val();
        var idVisiteur = $("#lstVisiteur").val();
        var mois = $("#lstMois").val();
        $('#tabHorsForfait tbody > tr').remove();
        $.getJSON('./includes/ajax.php?action=getLesFraisForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
            $('input[name="lesFrais[ETP]"]').val(data[0].quantite);
            $('input[name="lesFrais[KM]"]').val(data[1].quantite);
            $('input[name="lesFrais[NUI]"]').val(data[2].quantite);
            $('input[name="lesFrais[REP]"]').val(data[3].quantite);
        });

        $.getJSON('./includes/ajax.php?action=getLesFraisHorsForfait&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
            var len = data.length;
            for (var i = 0; i< len; i++) {
                $('#tabHorsForfait').append('<tr id="'+data[i].id+'"><div class="form-group"><td><input type="text" id=date_'+i+' value="'+data[i].date+'" class="form-control"></td><td><input type="text" id=libelle_'+i+' value="'+data[i].libelle+'" class="form-control"></td><td><input type="text" id=montant_'+data[i].id+' value="'+data[i].montant+'" class="form-control"></td></div><td><button class="btn btn-success" id="valider_'+data[i].id+'" onclick="validerHorsForfait('+data[i].id+')">Valider </button> <button class="btn btn-danger refuserHorsForfait" id="refuser_'+data[i].id+'" onclick="refuserHorsForfait(('+data[i].id+')">Refuser</button> <button class="btn btn-warning renvoyerrHorsForfait" id="refuser_'+data[i].id+'" onclick="renvoyerMoisSuivant('+data[i].id+')">Renvoyer au mois suivant</button></td></tr>');
            }
        });


        $.getJSON('./includes/ajax.php?action=getNbJustificatifs&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
            $('input[name="nbJustificatifs').val(data);
            
        });

    });

/**
 * Evenement ce déclenchant lorsque l'on clique sur le bouton majElemForfait
 * Met à jour dans la base de donnée la ligne Frais forfaitisés de la fiche de frais
 */
    $("#majElemForfait").click(function() {
        var idVisiteur = $("#lstVisiteur").val();
        var mois = $("#lstMois").val();
        var etp =  $('input[name="lesFrais[ETP]"]').val();
        var km  = $('input[name="lesFrais[KM]"]').val();
        var nui = $('input[name="lesFrais[NUI]"]').val();
        var rep =  $('input[name="lesFrais[REP]"]').val();
        $.ajax({
            type:"GET",
            cache:false,
            url:"./includes/ajax.php?action=setLesFraisForfait&token="+token,
            data:{ 'idVisiteur': idVisiteur , 'mois': mois , 'ETP':etp, 'KM':km, 'NUI':nui, 'REP':rep},
            success: function () {
                alert("ok");  

            }
          });

        });

/**
 * Evenement ce déclenchant lorsque l'on clique sur le bouton validerFrais
 * Valide la fiche de frais
 */
        $("#validerFrais").click(function() {
            var idVisiteur = $("#lstVisiteur").val();
            var mois = $("#lstMois").val();
           $.ajax({
            type:"POST",
            cache:false,
            url:"./includes/ajax.php?action=validerFicheFrais&token="+token,
            data:{ 'idVisiteur': idVisiteur , 'mois': mois},
            success: function () {
                alert("Fiche de Frais mis à jour !");  

            }
          });  
        });

/**
 * Evenement ce déclenchant lorsque l'input nbJustificatifs change de valeur
 * Met à jour dans la base de donnée le nombre de justificatifs de la fiche de frais
 */
        $( "#nbJustificatifs" ).change(function() {
            var idVisiteur = $("#lstVisiteur").val();
            var mois = $("#lstMois").val();
            var NbJustificatifs = $("#nbJustificatifs").val();
            $.ajax({
                type:"GET",
                cache:false,
                url:"./includes/ajax.php?action=majNbJustificatifs&token="+token,
                data:{ 'idVisiteur': idVisiteur, 'NbJustificatifs':NbJustificatifs, 'mois':mois,  },
                success: function () {
        
                }
        
            }); 


        });



});
