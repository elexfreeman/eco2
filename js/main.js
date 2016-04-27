/**
 * Created by User on 04.04.2016.
 */

$(function() {
    $('.hasDatepicker2').datetimepicker({
        format:'d.m.Y',
        lang:'ru',
        timepicker:false,
        closeOnDateSelect:true,

    });

    eco.All();
});

var eco = [];

eco.All = function()
{
    $.ajax({
        type: 'POST',
        url: 'search',
        data: {"action":"all"},
        // dataType : "json",
        success: function(data) {
            $('.results-area').html(data);
            $('.results').fadeIn();
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}

eco.Search = function()
{
    var SearchForm = $('#SearchForm').serializeArray();
    console.info(SearchForm);
    //$('.results-area').html(SearchForm);
    $('.results').fadeIn();
    $('.results-area').html($('#loader').html());
    $.ajax({
        type: 'POST',
        url: 'search',
        data: SearchForm,
       // dataType : "json",
        success: function(data) {
            $('.results-area').html(data);

        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}