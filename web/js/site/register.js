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

$(document).ready(function () {
    $("#boutonValider").click(function () {
        $.ajax({
            type: 'post',
            url: '/app/controller/connexion/inscription.php',
            data: {
                'nom': $('#nom').val(),
                'prenom': $('#prenom').val(),
                'pseudo': $('#pseudo').val(),
                'mail': $('#mail').val(),
                'motDePasse': $('#motDePasse').val(),
                'motDePasseConfirmation': $('#motDePasseConfirmation').val()
            }
        }).done(function (data) {
            if (data.ok) {
                $('#erreur').hide();
                document.location.href = "../../vue/vitrine.php";
            }
            else {
                console.log({
                    'nom': $('#nom').val(),
                    'prenom': $('#prenom').val(),
                    'pseudo': $('#pseudo').val(),
                    'mail': $('#mail').val(),
                    'motDePasse': $('#motDePasse').val(),
                    'motDePasseConfirmation': $('#motDePasseConfirmation').val()
                });
                if (data.pseudo) {
                    $('#inputPseudo').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("succesFormulaire");
                }
                else {
                    $('#inputPseudo').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("erreurFormulaire");
                }
                if (data.mail) {
                    $('#inputMail').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("succesFormulaire");
                }
                else {
                    $('#inputMail').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("erreurFormulaire");
                }
                if (data.motDePasse) {
                    $('#inputPassword').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("succesFormulaire");
                }
                else {
                    $('#inputPassword').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("erreurFormulaire");
                }
                if (data.motDePasseConfirmation) {
                    $('#inputPasswordConfirm').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("succesFormulaire");
                }
                else {
                    $('#inputPasswordConfirm').removeClass("succesFormulaire").remove("erreurFormulaire").addClass("erreurFormulaire");
                }
                $('#erreur ul').empty();
                var ul = $('<ul />');
                for (var j in data.messageErreur) {
                    ul.append($('<li>').html(data.messageErreur[j]));
                }
                $('#erreur').append(ul).show();
            }

        }).fail(erreurCritique);
        return false;  //a garder sinon va recharger la page
    });
});


