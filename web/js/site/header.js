/**
 * Javascript pour le formulaire de connexion contenu dans le header
 *
 * @author Lucas OMS
 */

function erreurCritique() {
    $('#contenu').html(
        'Une erreur irrécupérable est survenue. <br />'
        + 'Merci de contcter l\'admin <br/>'
        + 'contact@projectworld.fr'
    );
}

function seConnecter() {
    $.ajax({
        type: 'post',
        url: '/controler/connexion/connexion.php',
        data: {
            'identifiant': $('#identifiantConnexion').val(),
            'motDePasse': $('#motDePasseConnexion').val()
        }
    }).done(function (data) {
        if (data.ok === 1) {
            document.location.href = "/controler/jeu/menuMatch.php";
        }
        else if (data.ok === -1) {
            $('#motDePasseConnexion').css({'background': 'rgb(200,25,25)'});
        }
        else if (data.ok === -2) {
            $('#identifiantConnexion').css({'background': 'rgb(200,25,25)'});
        }
    }).fail(erreurCritique);
}

$(document).ready(function () {
    $("#boutonConnexion").click(function () {
        seConnecter();
    });

    $("#contenu, #header, footer").click(fermerInterfaceConnexion);

    $('#identifiantConnexion').keypress(function (event) {
        if (event.key === 'Enter')
            seConnecter();
    });

    $('#motDePasseConnexion').keypress(function (event) {
        if (event.key === 'Enter')
            seConnecter();
    });
});