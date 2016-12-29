$(document).ready(function () {
    refreshAlerteStocks();
    setTimeout(asyncRefreshAlerteSctocks(), 30000);
});

function refreshAlerteStocks() {
    $.ajax({
        url: $('#ajax-alerte-stocks').attr('data-ajax'),
        method: "GET",
        async: true
    }).success(function (json) {
        var liste = JSON.parse(json);
        var listeAlertesD = $('#alertesStockDanger');
        var listeAlertesW = $('#alertesStockWarning');
        listeAlertesD.html('');
        listeAlertesW.html('');
        for (var i = 0; i < Object.keys(liste).length; i++) {
            if (liste[i][3] == 1) {
                listeAlertesD.append('<div class="col-xs-12 border-alerte danger"><div class="row"><div class="col-xs-12"><p>produit : ' + liste[i][1] + '</p></div><div class="col-xs-12"><p>quantité : ' + liste[i][2] + '</p></div></div></div>');
            } else {
                listeAlertesW.append('<div class="col-xs-12 border-alerte warning"><div class="row"><div class="col-xs-12"><p>produit : ' + liste[i][1] + '</p></div><div class="col-xs-12"><p>quantité : ' + liste[i][2] + '</p></div></div></div>');
            }
        }
    });
}

function asyncRefreshAlerteSctocks() {
    setInterval(refreshAlerteStocks, 60000);
}