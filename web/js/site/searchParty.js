/**
 * Created by Lucas OMS on 09/02/2018.
 */

function searchParties() {
    $.ajax({
        type: 'post',
        url: '/?p=sAjax',
        data: {
            'address': $('#place-input').val(),
            'range': $('#range').val(),
            'rpg': $('#nomJeu').val()
        },
        dataType: "html"
    }).done(function (data) {
        $('#reponseRecherche').html(data);
    })
}

$(document).ready(function () {
    $('#onlyNet').change(function () {
        if ($(this).is(':checked'))
            $('#addressText').slideUp();
        else
            $('#addressText').slideDown();
    });
    $('#onlyNet').change(function () {
        if ($(this).is(':checked'))
            $('#addressText').slideUp();
        else
            $('#addressText').slideDown();
    });
    $('#withNet').change(function () {
        if ($(this).is(':checked'))
            $('#onlyNetText').slideDown();
        else
            $('#onlyNetText').slideUp();
    });
});