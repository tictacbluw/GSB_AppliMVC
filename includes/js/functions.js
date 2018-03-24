/** 
 * Retourne le token de l'utilisateur 
 * @return Le token de l'utilisateur (ou une string vide si le token n'est pas trouvé)
*/
function getToken() {
    var name = "token=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function refuserHorsForfait(id) {
    var token = getToken();
    $.ajax({
        type:"GET",
        cache:false,
        url:"./includes/ajax.php?action=refuserLigneHorsForfait&token="+token,
        data:{ 'id': id },
        success: function () {
        }
        
    }); 
    var libelleId = 'libelle_'+id;  
     $("#"+libelleId).val("REFUSE -"+ $("#"+libelleId).val());
     $("#refuser_"+id).attr("disabled", true);  



}

function renvoyerMoisSuivant(id) {
    var idVisiteur = $("#lstVisiteur").val();
    var mois = $("#lstMois").val();
    var token = getToken();

    $.ajax({
        type:"GET",
        cache:false,
        url:"./includes/ajax.php?action=renvoyerMoisSuivant&token="+token,
        data:{ 'id': id, 'mois':mois, 'idVisiteur': idVisiteur },
        success: function () {
            alert('OK');
        }
        
    }); 
    $('#'+id).remove();


}

function corrigerHorsForfait(id) {
    var libelleId = 'libelle_'+id; 
    var montantId = 'montant_'+id; 
    var dateId = 'date_'+id; 
    var libelle = $("#"+libelleId).val();
    var montant = $("#"+montantId).val();
    var date = $("#"+dateId).val();
    var token = getToken();
    $.ajax({
        type:"GET",
        cache:false,
        url:"./includes/ajax.php?action=majLigneHorsForfait&token="+token,
        data:{ 'id': id, 'date':date, 'libelle':libelle, 'montant':montant  },
        success: function () {
            alert('ok');
        }

    }); 

}

function getUrlParametres() {
    var prmstr = window.location.search.substr(1);
    return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
}

function transformToAssocArray( prmstr ) {
  var params = {};
  var prmarr = prmstr.split("&");
  for ( var i = 0; i < prmarr.length; i++) {
      var tmparr = prmarr[i].split("=");
      params[tmparr[0]] = tmparr[1];
  }
  return params;
}

function rembourserFicheFrais() {
    var idVisiteur = $("#lstVisiteur").val();
    var mois = $("#lstMois").val();
    $.ajax({
        type:"GET",
        cache:false,
        url:"./includes/ajax.php?action=remboursementFicheFrais&token="+token,
        data:{ 'idVisiteur': idVisiteur , 'mois': mois },
        success: function () {
            alert("Mise à jour effectuée !");
            $.getJSON('./includes/ajax.php?action=getLesInfosFicheFrais&idVisiteur='+idVisiteur+'&mois='+mois+'&token='+token, function(data){
                $("#libEtat").empty();
                $("#libEtat").append(data.libEtat);
                $("#dateModif").empty();
                $("#dateModif").append(data.dateModif);
                $("#bouttonValider").empty();
                $("#bouttonValider").append('<button type="button" class="btn btn-info" id="remboursementFicheFrais" disabled>Remboursement effectué</button>');                  

            });  
        
        }
      }); 

}