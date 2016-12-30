$(document).ready(function () {
    asyncRefresh();
    setTimeout(asyncRefreshCommande, 15000);
    $('#table-pizza').on('click', '.btn-commande-upgrade', function () {
        $.ajax({
            url: $('#ajax-upgrade-commande').attr('data-ajax'),
            method: "POST",
            data: {
                id: $(this).attr('id').split('-')[2]
            },
            async: true
        }).success(function (json) {
            json = JSON.parse(json);
            if (json[0] == 2) {
                $('#btn-commande-' + json[1]).addClass('btn-success').removeClass('btn-warning').html('Prêt');
            } else if(json[0] == 3) {
                $('#commande-' + json[1]).remove();
            }
        });
    });
});

function refresh() {
    $.ajax({
        url: $('#ajax-refresh-produits').attr('data-ajax'),
        method: "GET",
        async: true
    }).success(function (json) {
        var liste = JSON.parse(json);
        var listeProduits = $('#listeStock');
        var listeIds = [];
        for (var i = 0; i < Object.keys(liste).length; i++) {
            if (document.getElementById('stock-' + liste[i][0])) {
                $('#pl-' + liste[i][0] + '-nom').html(liste[i][1]);
                $('#pl-' + liste[i][0] + '-qte').html(liste[i][2]);
            } else {
                var html = '<tr id="stock-' + liste[i][0] + '"><td id="pl-' + liste[i][0] + '-nom" class="col-md-3">' + liste[i][1] + '</td><td id="pl-' + liste[i][0] + '-qte" class="col-md-2">' + liste[i][2] + '</td><td class="col-md-5"><a href="/cuisine/addQuantity/' + liste[i][0] + '"><button class="btn btn-primary btn-table-left">Ajout stock</button></a></td></tr>';
                listeProduits.append(html);
            }
            listeIds.push(liste[i][0]);
        }

        var children = listeProduits.children();
        for (var y = 0; y < children.length; y++) {
            var child = $(children[y]);
            if(listeIds.indexOf(parseInt(child.attr('id').split('-')[1])) == -1) {
                children[y].parentNode.removeChild(children[y]);
            }
        }
    });
}

function asyncRefresh() {
    setInterval(refresh, 60000);
}

function refreshCommande() {
    $.ajax({
        url: $('#ajax-refresh-commande').attr('data-ajax'),
        method: "GET",
        async: true
    }).success(function (json) {
        var liste = JSON.parse(json);
        var listeCommandes = $('#table-pizza');
        var listeIds = [];
        for (var i = 0; i < liste[1].length; i++) {
            if (document.getElementById('commande-' + liste[1][i][0])) {
                var row = $('commande-' + liste[1][i][0]);
                if (liste[1][i][4] > liste[0][1]) {
                    if (!row.hasClass('danger')) {
                        row.addClass('danger').removeClass('warning');
                    }
                } else if (liste[1][i][4] > liste[0][0]) {
                    if (!row.hasClass('warning')) {
                        row.addClass('warning').removeClass('success');
                    }
                }
                $('#time-' + liste[1][i][0]).html(liste[1][i][4]);
            } else {
                var html = '<div id="commande-' + liste[1][i][0] + '" class="col-xs-12 border-alerte ';
                if (liste[1][i][4] > liste[0][1]) {
                    html += 'danger';
                } else if (liste[1][i][4] > liste[0][0]) {
                    html += 'warning';
                } else {
                    html += 'success';
                }
                html += ' padding-bottom-15 padding-top-15"><div class="margin-top-20 col-xs-6 col-sm-3"><span id="time-' + liste[1][i][0] + '">' + liste[1][i][4] + '</span>m depuis commande</div><div class="margin-top-20 col-xs-6 col-sm-6"><span id="commande-nom-' + liste[1][i][0] + '">' + liste[1][i][1] + '</span> / Ref : <span id="commande-ref-' + liste[1][i][0] + '">' + liste[1][i][2] + '</span></div><div class="col-xs-12 col-sm-3"><button id="btn-commande-' + liste[1][i][0] + '" class="margin-top-10 col-xs-8 col-xs-offset-2 btn btn-warning btn-commande-upgrade">En préparation</button></div></div>';
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