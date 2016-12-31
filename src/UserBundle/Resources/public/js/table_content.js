$(document).ready(function() {
    $('.content-tab').click(function () {
        var id = $(this).attr('id').split('-');
        $('.content-table').attr('style', 'display:none;');
        $('#table-' + id[1]).attr('style', 'display:inline-table;');
        $('.content-tab').removeClass('active');
        $(this).addClass('active');
    });
});