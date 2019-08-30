$(document).ready(function () {
    asyncRefresh();
    $('#table-boisson').on('click', '.vignette', function () {
        clickVignette(this);
    });
    $('#table-pizza').on('click', '.vignette', function () {
        clickVignette(this);
    });
    $('#table-snack').on('click', '.vignette', function () {
        clickVignette(this);
    });
    $('#table-sandwitch').on('click', '.vignette', function () {
        clickVignette(this);
    });
    $('#listing-commande').on('click', '.btnp', function () {
        var id = $(this).attr('id').split('-')[1];
        var produit = $('#' + id);
        if (parseInt(produit.attr('data-qte')) <= 0) {
            alert('Attention, ce produit n\'est plus disponible en quantité suffisante pour votre commande !');
        }
        produit.attr('data-qte',parseInt(produit.attr('data-qte')) - 1);
        var qte = $('#plqte-' + id);
        qte.html(parseInt(qte.html()) + 1);
        var cost = $('#cout-total-command');
        cost.html(parseFloat(cost.html()) + parseFloat(produit.attr('data-cost')));
    }).on('click', '.btnm', function () {
        var id = $(this).attr('id').split('-')[1];
        var produit = $('#' + id);
        produit.attr('data-qte',parseInt(produit.attr('data-qte')) + 1);
        var qte = $('#plqte-' + id);
        var newQte = parseInt(qte.html()) - 1;
        if (newQte == 0) {
            $('#pl-' + id).remove();
        } else {
            qte.html(newQte);
        }
        var cost = $('#cout-total-command');
        cost.html(parseFloat(cost.html()) - parseFloat(produit.attr('data-cost')));
    });
    $('#valider-autre-commande').click(function () {
        validerCommande(3);
    });
    $('#valider-cb-commande').click(function () {
        validerCommande(1);
    });
    $('#valider-espece-commande').click(function () {
        validerCommande(2);
    });
    $('#valider-staff-commande').click(function () {
        validerCommande(4);
    });
    $('#annuler-commande').click(function () {
        clearCommande();
    });
    $('#modalCommande').on('shown.bs.modal', function () {
        var prix = $('#cout-total-command').html();
        if (parseFloat(prix) > 0) {
            $('#valider-autre-commande').removeAttr('disabled');
            $('#valider-cb-commande').removeAttr('disabled');
            $('#valider-espece-commande').removeAttr('disabled');
        } else {
            $('#valider-autre-commande').attr('disabled', 'true');
            $('#valider-cb-commande').attr('disabled', 'true');
            $('#valider-espece-commande').attr('disabled', 'true');
        }
        $('#modal-prix').html(prix);
    });
});

function clickVignette($this) {
    var cost = $('#cout-total-command');
    var id = $($this).attr('id');
    cost.html(parseFloat(cost.html()) + parseFloat($($this).attr('data-cost')));
    if (parseInt($($this).attr('data-qte')) <= 0) {
        alert('Attention, ce produit n\'est plus disponible en quantité suffisante pour votre commande !');
    }
    $($this).attr('data-qte',parseInt($($this).attr('data-qte')) - 1);
    if ($('#pl-' + id).length == 0) {
        $('#listing-commande').append('<div id="pl-' + id + '" class="row margin-top-10 bordure-produit-buvette"><div class="col-xs-1 col-xs-offset-1 padding-top-7">' +
            '<span id="plqte-' + id + '">1</span></div>' +
            '<div class="col-xs-5 col-sm-5"><div class="row"><button id="btnp-' + id + '" class="btnp btn btn-default col-xs-5">+</button><button id="btnm-' + id + '" class="btnm btn btn-default col-xs-5 col-xs-offset-1">-</button></div></div>' +
            '<div class="col-xs-5 col-sm-5 padding-top-7">' + $($this).attr("data-name") + '</div></div>');
    } else {
        var qte = $('#plqte-' + id);
        qte.html(parseInt(qte.html()) + 1);
    }
}

function validerCommande(payement) {
    var produits = [];
    var children = $('#listing-commande').children();
    var id;
    for (var i = 0; i < children.length; i++) {
        id = $(children[i]).attr('id').split('-')[1];
        produits.push([parseInt(id),parseInt($('#plqte-' + id).html())]);
    }
    $('#modal-commande-footer-1').addClass('footer-visible-none');
    $('#modal-commande-footer-2').removeClass('footer-visible-none');
    $.ajax({
        url: $('#ajax-validation').attr('data-ajax'),
        method: "POST",
        data: {
            payement : payement,
            produits : JSON.stringify(produits),
            prix : $('#cout-total-command').html()
        }
    }).success(function (retour) {
        refresh();
        $('#modal-commande-footer-2').addClass('footer-visible-none');
        $('#modal-commande-footer-1').removeClass('footer-visible-none');
        $('#modalCommande').modal('hide');
        retour = parseInt(retour);
        if (retour !== 0) {
            openModalValidation(retour);
            clearCommande();
        } else {
            openModalValidation(0);
        }
    }).error(function () {
        $('#modal-commande-footer-2').addClass('footer-visible-none');
        $('#modal-commande-footer-1').removeClass('footer-visible-none');
        $('#modalCommande').modal('hide');
        openModalValidation(0);
    });
}

function clearCommande() {
    $('#listing-commande').html('');
    $('#cout-total-command').html('0');
}

function openModalValidation(retour) {
    var res = $('#modal_validation_body');
    if (retour != 0) {
        if (!res.hasClass('alert-success')) {
            res.addClass('alert-success');
        }
        if (res.hasClass('alert-danger')) {
            res.removeClass('alert-danger');
        }
        $('#modal_resultat_validation').html('La commande a bien été enregistrée !<br/>Numéro de commande : ' + retour);
    } else {
        if (!res.hasClass('alert-danger')) {
            res.addClass('alert-danger');
        }
        if (res.hasClass('alert-success')) {
            res.removeClass('alert-success');
        }
        $('#modal_resultat_validation').html('Un problème est survenue, la commande n\'a pas été enregistrée !');
    }
    $('#modalValidation').modal('show');
}

function refresh() {
    $.ajax({
        url: $('#ajax-refresh-produits').attr('data-ajax'),
        method: "GET",
        async: true
    }).success(function (json) {
        var liste = JSON.parse(json);
        var listeProduits;
        if (document.getElementById('table-sandwitch')) {
            listeProduits = [$('#table-boisson'), $('#table-sandwitch'), $('#table-snack'), $('#table-pizza')];
        } else {
            listeProduits = [$('#table-boisson')];
        }
        var listeIds = [];
        var keys = Object.keys(liste);
        for (var i = 0; i < keys.length; i++) {
            for (var x = 0; x < liste[keys[i]].length; x++) {
                if (document.getElementById(liste[keys[i]][x][0])) {
                    $('#' + liste[keys[i]][x][0]).attr('data-name', liste[keys[i]][x][1]).attr('data-cuisson', liste[keys[i]][x][3]).attr('data-cost', liste[keys[i]][x][2]).attr('data-qte', liste[keys[i]][x][5]);
                    $('#pl-' + liste[keys[i]][x][0] + '-nom').html(liste[keys[i]][x][1]);
                    $('#pl-' + liste[keys[i]][x][0] + '-prix').html(liste[keys[i]][x][2]);
                    $('#pl-' + liste[keys[i]][x][0] + '-qteaff').html(liste[keys[i]][x][5]);
                } else {
                    if (i in listeProduits) {
                        var html = '<div id="' + liste[keys[i]][x][0] + '" data-qte="' + liste[keys[i]][x][5] + '" data-name="' + liste[keys[i]][x][1] + '" data-cuisson="' + liste[keys[i]][x][3] + '" data-cost="' + liste[keys[i]][x][2] + '" style="background-image: url(\'';
                        if (liste[keys[i]][x][4] != null) {
                            html += '/uploads/' + liste[keys[i]][x][4];
                        } else {
                            html += '/bundles/buvette/images/noimagefound.jpg';
                        }
                        html += '\');" class="col-xs-6 col-sm-6 col-md-3 vignette"><span id="pl-' + liste[keys[i]][x][0] + '-nom">' + liste[keys[i]][x][1] + '</span><br/><span id="pl-' + liste[keys[i]][x][0] + '-prix">' + liste[keys[i]][x][2] + '</span>€<br/><br/>Stock : <span id="pl-' + liste[keys[i]][x][0] + '-qteaff">' + liste[keys[i]][x][5] + '</span></div>';
                        listeProduits[keys[i]].append(html);
                    }
                }
                listeIds.push(liste[keys[i]][x][0]);
            }
        }

        for (var z = 0; z < listeProduits.length; z++) {
            var children = listeProduits[z].children();
            for (var y = 0; y < children.length; y++) {
                var child = $(children[y]);
                if(listeIds.indexOf(parseInt(child.attr('id'))) == -1) {
                    children[y].parentNode.removeChild(children[y]);
                }
            }
        }

    });
}

function asyncRefresh() {
    setInterval(refresh, 60000);
}