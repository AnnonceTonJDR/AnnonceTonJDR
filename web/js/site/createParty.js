/**
 * Javascript pour le formulaire de connection contenu dans le header
 *
 * @author Lucas OMS
 */

function initControls() {

    //region ========= Control age =========
    var ageMax = $('#ageMax');
    var ageMin = $('#ageMin');
    ageMax.change(function () {
        if (ageMax.val() > 123)
            ageMax.val(123);
        else if (ageMax.val() < 7)
            ageMax.val(7);
        else if (ageMax.val() < ageMin.val())
            ageMax.val(ageMin.val());
    });

    ageMin.change(function () {
        if (ageMin.val() > 123)
            ageMin.val(123);
        else if (ageMin.val() < 7)
            ageMin.val(7);
        else if (ageMax.val() < ageMin.val())
            ageMax.val(ageMin.val());
    });
    //endregion

    //region ========= Control nb players =========
    var nbPlayer = $('#joueurMax');
    var playersIn = $('#nbJoueurDejaInscrits');
    nbPlayer.change(function () {
        if (nbPlayer.val() > 99)
            nbPlayer.val(99);
        else if (nbPlayer.val() < 1)
            nbPlayer.val(1);
    });

    playersIn.change(function () {
        if (playersIn.val() > 98)
            playersIn.val(98);
        else if (playersIn.val() < 0)
            playersIn.val(0);
    });
    //endregion

}

function resizeInput() {
    // var newSize = ($(this).val().length >= 4 ? $(this).val().length : 4);
    var newSize = $(this).val().length;
    $(this).attr('size', newSize);
}

$(document).ready(function () {


    initControls();

    $('input[type="text"]')
    // event handler
        .keyup(resizeInput)
        // resize on page load
        .each(resizeInput);
});