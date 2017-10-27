/**
 * Js destiné à la page d'inscription
 *
 * @author Lucas OMS
 */

function erreurCritique() {
    $('body').html(
        'Une erreur irrécupérable est survenue. <br />'
        + 'Merci de contcter l\'admin <br/>'
        + 'contact@projectworld.fr'
    );
}

function envoyerFormulaireInscription() {
    $.ajax({
        type: 'post',
        url: '/app/controller/connexion/inscription.php',
        data: {
            'nom': $('#nom').val(),
            'prenom': $('#prenom').val(),
            'pseudo': $('#pseudo').val(),
            'dateNaissance': $('#dateNaissance').val(),
            'mail': $('#mail').val(),
            'motDePasse': $('#motDePasse').val(),
            'motDePasseConfirmation': $('#motDePasseConfirmation').val()
        }
    }).done(function (data) {
        if (data.ok) {
            $('#erreur').hide();
            alert("Inscription effectuée!");
            //TODO Afficher l'activation par mail requise
            //TODO Un bouton pour revnir à l'accueil explicitement
        }
        else {
            // console.log({
            //     'nom': $('#nom').val(),
            //     'prenom': $('#prenom').val(),
            //     'pseudo': $('#pseudo').val(),
            //     'mail': $('#mail').val(),
            //     'motDePasse': $('#motDePasse').val(),
            //     'motDePasseConfirmation': $('#motDePasseConfirmation').val()
            // });
            if (data.pseudo) {
                $('#inputPseudo').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#inputPseudo').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.mail) {
                $('#inputMail').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#inputMail').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.motDePasse) {
                $('#inputPassword').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#inputPassword').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.motDePasseConfirmation) {
                $('#inputPasswordConfirm').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#inputPasswordConfirm').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            $('#erreur ul').empty();
            var ul = $('<ul />');
            for (var j in data.messageErreur) {
                ul.append($('<li>').html(data.messageErreur[j]));
            }
            $('#erreur').append(ul).show();
        }
    });
    // .fail(erreurCritique);
}

$(document).ready(function () {
    $('#inputPseudo, #inputMail, #inputPassword, #inputPasswordConfirm, #inputNom, #inputPrenom').keypress(function (event) {
        if (event.key === 'Enter')
            envoyerFormulaireInscription();
    });
    $("#boutonValider").click(envoyerFormulaireInscription);
    return false;  //a garder sinon va recharger la page
});



