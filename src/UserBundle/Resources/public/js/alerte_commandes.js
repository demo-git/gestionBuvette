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
        var listeIds = [];
        $('#alerte-commande-attente').html(liste[0][2]);
        for (var i = 0; i < liste[1].length; i++) {
            if (document.getElementById('commande-' + liste[1][i][0])) {
                var row = $('commande-' + liste[1][i][0]);
                if (liste[1][i][3] == 1) {
                    if (!row.hasClass('danger')) {
                        row.addClass('danger').removeClass('warning').removeClass('success');
                    }
                } else if (liste[1][i][3] == 2) {
                    if (!row.hasClass('warning')) {
                        row.addClass('warning').removeClass('danger').removeClass('success');
                    }
                }
                else if (liste[1][i][3] == 3) {
                    if (!row.hasClass('success')) {
                        row.addClass('success').removeClass('warning').removeClass('danger');
                    }
                }
                $('#commande-nom-' + liste[1][i][0]).html(liste[1][i][1]);
            } else {
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
            listeIds.push(liste[1][i][0]);
        }

        var children = listeCommandes.children();
        for (var y = 0; y < children.length; y++) {
            var child = $(children[y]);
            if(listeIds.indexOf(parseInt(child.attr('id').split('-')[1])) == -1) {
                children[y].parentNode.removeChild(children[y]);
            }
        }
    });
}

function asyncRefreshCommande() {
    setInterval(refreshCommande, 30000);
}