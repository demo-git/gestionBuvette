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
        var keys = Object.keys(liste);
        for (var i = 0; i < keys.length; i++) {
            for (var x = 0; x < liste[keys[i]].length; x++) {
                if (document.getElementById(liste[keys[i]][x][0])) {
                    $('#pl-' + liste[keys[i]][x][0] + '-nom').html(liste[keys[i]][x][1]);
                    $('#pl-' + liste[keys[i]][x][0] + '-prix').html(liste[keys[i]][x][2]);
                } else {
                    var html = '<div id="' + liste[keys[i]][x][0] + '" style="background-image: url(\'';
                    if (liste[keys[i]][x][4] != null) {
                        html += '/uploads/' + liste[keys[i]][x][4];
                    } else {
                        html += '/bundles/buvette/images/noimagefound.jpg';
                    }
                    html += '\');margin: 0 10px 0 10px;" class="col-xs-6 col-sm-4 col-md-3 col-lg-2 vignette"><span id="pl-' + liste[keys[i]][x][0] + '-nom">' + liste[keys[i]][x][1] + '</span><br/><span id="pl-' + liste[keys[i]][x][0] + '-prix">' + liste[keys[i]][x][2] + '</span>€</div>';
                    listeProduits.append(html);
                }
                listeIds.push(liste[keys[i]][x][0]);
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
    setInterval(refresh, 60000);
}