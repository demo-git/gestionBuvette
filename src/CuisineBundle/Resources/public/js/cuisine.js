$(document).ready(function () {
    asyncRefresh();
    $('.btn-commande-upgrade').click(function () {
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