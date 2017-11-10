/**
 * Javascript pour le formulaire de connection contenu dans le header
 *
 * @author Lucas OMS
 */

function erreurCritique() {
    $('#contenu').html(
        'Une erreur irrécupérable est survenue. <br />'
        + 'Merci de contcter l\'admin <br/>'
        + 'contact@annonceTonJDR.fr'
    );
}

function seConnecter() {
    $.ajax({
        type: 'post',
        url: '/app/controller/connection/connection.php',
        data: {
            'identifiant': $('#idConnection').val(),
            'motDePasse': $('#pwdConnection').val()
        }
    }).done(function (data) {
        if (data.ok === 1) {
            location.reload(true);
        }
        else if (data.ok === -1) {
            $('#pwdConnection').css({'background': 'rgb(200,25,25)'});
        }
        else if (data.ok === -2) {
            $('#idConnection').css({'background': 'rgb(200,25,25)'});
        }
    }).fail(erreurCritique);
}

$(document).ready(function () {
    $("#connectionButton").click(function () {
        seConnecter();
    });

    $('#idConnection').keypress(function (event) {
        if (event.key === 'Enter')
            seConnecter();
    });

    $('#pwdConnection').keypress(function (event) {
        if (event.key === 'Enter')
            seConnecter();
    });

    $('#deconnectionButton').click(function () {
        $.ajax({
            type: 'get',
            url: '/app/controller/connection/deconnexion.php'
        }).done(function () {
            location.reload(true);
        }).fail(erreurCritique);
    });
});