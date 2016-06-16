$(document).ready(function(){
    $('#tab-boisson').click(function () {
        $('#table-boisson').attr('style','display:inline-table;');
        $('#table-sandwitch').attr('style','display:none;');
        $('#table-snack').attr('style','display:none;');
        $('#table-composant').attr('style','display:none;');
        $('#table-pizza').attr('style','display:none;');

        $(this).addClass('active');
        $('#tab-sandwitch').removeClass('active');
        $('#tab-snack').removeClass('active');
        $('#tab-pizza').removeClass('active');
        $('#tab-composant').removeClass('active');
    });
    $('#tab-sandwitch').click(function () {
        $('#table-boisson').attr('style','display:none;');
        $('#table-sandwitch').attr('style','display:inline-table;');
        $('#table-snack').attr('style','display:none;');
        $('#table-composant').attr('style','display:none;');
        $('#table-pizza').attr('style','display:none;');

        $(this).addClass('active');
        $('#tab-boisson').removeClass('active');
        $('#tab-snack').removeClass('active');
        $('#tab-pizza').removeClass('active');
        $('#tab-composant').removeClass('active');
    });
    $('#tab-snack').click(function () {
        $('#table-boisson').attr('style','display:none;');
        $('#table-sandwitch').attr('style','display:none;');
        $('#table-snack').attr('style','display:inline-table;');
        $('#table-composant').attr('style','display:none;');
        $('#table-pizza').attr('style','display:none;');

        $(this).addClass('active');
        $('#tab-sandwitch').removeClass('active');
        $('#tab-boisson').removeClass('active');
        $('#tab-pizza').removeClass('active');
        $('#tab-composant').removeClass('active');
    });
    $('#tab-pizza').click(function () {
        $('#table-boisson').attr('style','display:none;');
        $('#table-sandwitch').attr('style','display:none;');
        $('#table-snack').attr('style','display:none;');
        $('#table-composant').attr('style','display:none;');
        $('#table-pizza').attr('style','display:inline-table;');

        $(this).addClass('active');
        $('#tab-sandwitch').removeClass('active');
        $('#tab-snack').removeClass('active');
        $('#tab-boisson').removeClass('active');
        $('#tab-composant').removeClass('active');
    });
    $('#tab-composant').click(function () {
        $('#table-boisson').attr('style','display:none;');
        $('#table-sandwitch').attr('style','display:none;');
        $('#table-snack').attr('style','display:none;');
        $('#table-composant').attr('style','display:inline-table;');
        $('#table-pizza').attr('style','display:none;');

        $(this).addClass('active');
        $('#tab-sandwitch').removeClass('active');
        $('#tab-snack').removeClass('active');
        $('#tab-pizza').removeClass('active');
        $('#tab-boisson').removeClass('active');
    });
});