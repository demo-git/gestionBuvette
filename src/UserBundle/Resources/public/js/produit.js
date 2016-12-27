var NB_COMPOSANT;
var jsonData = null;
$(document).ready(function(){
    NB_COMPOSANT = $(".composant").length - 1;

    $("#add-composant").click(function (){
        NB_COMPOSANT++;
        if(jsonData == null){
            $.ajax({
                method: "POST",
                url: $('#ajax-produit-add').attr('data-ajax')
            })
            .done(function( data ) {
                jsonData = data.split(';');
                addComposant();
            });
        }
        else{
            addComposant();
        }
        return false;
    });

    $("#composants").on('click', ".delete", function(){
        var id = $(this).attr('id').split('-');
        $("#" + id[1]).remove();
        return false;
    });
});

function addComposant(){
    var html = '<div id="produit_modifier_composants_' + NB_COMPOSANT + '" class="composant col-md-6"><div class="col-md-12"><label class="required btn-margin">Nouveau composant :</label><div id="delete-produit_modifier_composants_' + NB_COMPOSANT + '" class="btn btn-danger delete">X</div></div><div class="col-md-12"><label for="produit_modifier_composants_' + NB_COMPOSANT +'_produitComposant" class="required">Produit :</label><select id="produit_modifier_composants_' + NB_COMPOSANT +'_produitComposant" name="produit_modifier[composants][' + NB_COMPOSANT +'][produitComposant]" class="form-control">';

    $.each(jsonData, function() {
        var data = this.split('/');
        html += '<option value="' + data[0] + '">' + data[1] + '</option>';
    });

    html += '</select></div><div class="col-md-12"><label for="produit_modifier_composants_' + NB_COMPOSANT +'_quantite" class="required">Quantité :</label><input id="produit_modifier_composants_' + NB_COMPOSANT +'_quantite" name="produit_modifier[composants][' + NB_COMPOSANT +'][quantite]" min="1" type="number" class="form-control"></div></div>';

    $("#composants").append(html);
}