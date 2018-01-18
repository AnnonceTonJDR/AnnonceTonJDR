/**
 * Javascript pour le formulaire de connection contenu dans le header
 *
 * @author Lucas OMS
 */

var connectionInterfaceIsOpened = false;


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
            'id': $('#idConnection').val(),
            'pwd': $('#pwdConnection').val()
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

//region =================== Bouton jouer ===================
function connectionInterface() {
    if (connectionInterfaceIsOpened) {
        $('#menuConnexion').addClass('invisible');
        connectionInterfaceIsOpened = false;
    } else {
        $('#menuConnexion').removeClass('invisible');
        //Needed to allow user exiting interface b yclicking elsewhere
        connectionInterfaceIsOpened = true;
    }

}

function closeConnectionInterface() {
    $('#menuConnexion').addClass('invisible');
    connectionInterfaceIsOpened = false;
}

// endregion

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

    $('#openConnectionMenuButton').click(connectionInterface);
    $('.js_close_connectionInterface, footer').click(closeConnectionInterface);

});