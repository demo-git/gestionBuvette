$(document).ready(function () {
    asyncRefresh();
});

function refresh() {
    $.ajax({
        url: $('#ajax-refresh-produits').attr('data-ajax'),
        method: "GET",
        async: true
    }).success(function (json) {
        var liste = JSON.parse(json);
        var listeProduits = $('#listeProduits');
        var listeIds = [];
        for (var i = 0; i < Object.keys(liste).length; i++) {
            for (var x = 0; x < liste[i].length; x++) {
                if (document.getElementById(liste[i][x][0])) {
                    $('#pl-' + liste[i][x][0] + '-nom').html(liste[i][x][1]);
                    $('#pl-' + liste[i][x][0] + '-prix').html(liste[i][x][2]);
                } else {
                    var html = '<div id="' + liste[i][x][0] + '" style="background-image: url(\'';
                    if (liste[i][x][4] != null) {
                        html += '/uploads/' + liste[i][x][4];
                    } else {
                        html += '/bundles/buvette/images/noimagefound.jpg';
                    }
                    html += '\');margin: 0 10px 0 10px;" class="col-xs-6 col-sm-4 col-md-3 col-lg-2 vignette"><span id="pl-' + liste[i][x][0] + '-nom">' + liste[i][x][1] + '</span><br/><span id="pl-' + liste[i][x][0] + '-prix">' + liste[i][x][2] + '</span>€</div>';
                    listeProduits.append(html);
                }
                listeIds.push(liste[i][x][0]);
            }
        }

        var children = listeProduits.children();
        for (var y = 0; y < children.length; y++) {
            var child = $(children[y]);
            if(listeIds.indexOf(parseInt(child.attr('id'))) == -1) {
                children[y].parentNode.removeChild(children[y]);
            }
        }
    });
}

function asyncRefresh() {
    setInterval(refresh, 50000);
}