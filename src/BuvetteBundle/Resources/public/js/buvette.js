$(document).ready(function () {
    $('.vignette').click(function () {
        var cost = $('#cout-total-command');
        var id = $(this).attr('id');
        cost.html(parseFloat(cost.html()) + parseFloat($(this).attr('data-cost')));
        if ($('#pl-' + id).length == 0) {
            $('#listing-commande').append('<div id="pl-' + id + '" class="row margin-top-10 bordure-produit-buvette"><div class="col-xs-1 col-xs-offset-1 padding-top-7">' +
                '<span id="plqte-' + id + '">1</span></div>' +
                '<div class="col-xs-5 col-sm-5"><div class="row"><button id="btnp-' + id + '" class="btn btn-default col-xs-5">+</button><button id="btnm-' + id + '" class="btn btn-default col-xs-5 col-xs-offset-1">-</button></div></div>' +
                '<div class="col-xs-5 col-sm-5 padding-top-7">' + $(this).attr("data-name") + '</div></div>');
        } else {
            var qte = $('#plqte-' + id);
            qte.html(parseInt(qte.html()) + 1);
        }
    });
});