/**
 * Javascript pour le formulaire de connection contenu dans le header
 *
 * @author Lucas OMS
 */

function sendForm() {
    $.ajax({
        type: 'post',
        url: '/app/controller/ajax/createParty.php',
        data: {
            'ageMin': $('#ageMin').val(),
            'ageMax': $('#ageMax').val(),
            'joueurMax': $('#joueurMax').val(),
            'nomJeu': $('#nomJeu').val(),
            'edition': $('#editionjeu').val(),
            'nomScenario': $('#nomJeu').val(),
            'editionScneario': $('#editionscenario').val(),
            'adresse': $('#addressText').val(),
            'lieu': $('#typelieu').val(),
            'nourritureBoisson': $('#nourritureBoisson').val(),
            'alcool': $('#alcool').val(),
            'fumer': $('#fumer').val(),
            'titreForum': $('#titreForum').val(),
            'commentaire': $('#commentaire').val(),
            'date': $('#date').val(),
            'faitPartieCampagneOuverte': $('#isopenedcampain').val(),
            'nbJoueurDejaInscrits': $('#nbJoueurDejaInscrits').val()
        }
    }).done(function (data) {
        if (data.ok) {
        }
        else {
        }
    })
}

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

    //Adapt if virtual or IRL
    $('#isVirtual').change(function () {
        if ($(this).is(':checked'))
            $('#addressText').slideUp();
        else
            $('#addressText').slideDown();
    });
    $('#placebo').change(function () {
        if ($(this).is(':checked'))
            $('.nameForum').slideDown();
        else
            $('.nameForum').slideUp();
    });

    initControls();

    $('input[type="text"]')
    // event handler
        .keyup(resizeInput)
        // resize on page load
        .each(resizeInput);
});