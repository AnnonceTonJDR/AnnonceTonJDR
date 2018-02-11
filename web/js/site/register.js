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
        url: '/app/controller/connection/register.php',
        data: {
            'lastName': $('#nom').val(),
            'firstName': $('#prenom').val(),
            'pseudo': $('#pseudo').val(),
            'birth': $('#dateNaissance').val(),
            'mail': $('#mail').val(),
            'pwd': $('#motDePasse').val(),
            'pwdConfirm': $('#motDePasseConfirmation').val()
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
                $('#pseudo').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#pseudo').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.mail) {
                $('#mail').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#mail').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.pwd) {
                $('#motDePasse').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#motDePasse').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.birth) {
                $('#dateNaissance').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#dateNaissance').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            if (data.pwdConfirm) {
                $('#motDePasseConfirmation').removeClass("successForm").remove("errorForm").addClass("successForm");
            }
            else {
                $('#motDePasseConfirmation').removeClass("successForm").remove("errorForm").addClass("errorForm");
            }
            $('#erreur ul').empty();
            var ul = $('<ul />');
            for (var j in data.msgError) {
                ul.append($('<li>').html(data.msgError[j]));
            }
            $('#erreur').append(ul).show();
            $('input').focus(function () {
                $('input').removeClass("errorForm").addClass("successForm");
            })
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



