$(document).ready(function () {
    refreshCommande();
    setTimeout(asyncRefreshCommande, 15000);
    $('#listeCommandes').on('click', '.btn-commande-upgrade', function () {
        $(this).html('<img style="height: 20px;" src="/bundles/buvette/images/loading-ajax.gif" />');
        $.ajax({
            url: $('#ajax-upgrade-commande').attr('data-ajax'),
            method: "POST",
            data: {
                id: $(this).attr('id').split('-')[2]
            },
            async: true
        }).success(function (json) {
            json = JSON.parse(json);
            $('#commande-' + json[1]).remove();
        });
    });
});

function refreshCommande() {
    $.ajax({
        url: $('#ajax-refresh-commande').attr('data-ajax'),
        method: "GET",
        async: true
    }).success(function (json) {
        var liste = JSON.parse(json);
        var listeCommandes = $('#listeCommandes');
        $('#alerte-commande-attente').html(liste[0][2]);
        listeCommandes.html('');
        for (var i = 0; i < liste[1].length; i++) {
            var html = '<div id="commande-' + liste[1][i][0] + '" class="col-xs-12 border-alerte ';
            var btnAdd = false;
            if (liste[1][i][3] == 1) {
                html += 'danger';
            } else if (liste[1][i][3] == 2) {
                html += 'warning';
            } else {
                html += 'success';
                btnAdd = true;
            }
            html += '"><div class="row"><div id="commande-nom-' + liste[1][i][0] + '" class="col-xs-6">' + liste[1][i][1] + '</div><div id="commande-ref-' + liste[1][i][0] + '" class="col-xs-6">Ref : ' + liste[1][i][2] + '</div></div>';

            if (btnAdd) {
                html += '<div class="row"><div class="col-xs-12"><button id="btn-commande-' + liste[1][i][0] + '" class="col-xs-6 col-xs-offset-3 btn btn-success btn-commande-upgrade">Retrait</button></div></div>';
            }
            html += '</div>';
            listeCommandes.append(html);
        }
    });
}

function asyncRefreshCommande() {
    setInterval(refreshCommande, 30000);
}