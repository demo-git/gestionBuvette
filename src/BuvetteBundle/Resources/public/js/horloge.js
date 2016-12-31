window.onload=function() {
    horloge();
};

function actualiser() {
    var date = new Date();
    $('#heure').html(date.getHours() + ':' + (date.getMinutes()<10?'0':'') + date.getMinutes());
}

function horloge() {
    actualiser();
    setInterval(actualiser,30000);
}