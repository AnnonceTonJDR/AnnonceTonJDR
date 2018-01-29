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
            if (document.location.search === "?p=c")
                document.location = "/" + document.location.search;
            else
                document.location = "/?p=i";
        }
        else if (data.ok === -1) {
            $('#pwdConnection').css({'background': 'rgb(200,25,25)'});
        }
        else if (data.ok === -2) {
            $('#idConnection').css({'background': 'rgb(200,25,25)'});
        }
    }).fail(erreurCritique);
}

//region =================== Responsive of banner ===================
var leftBanner = $('#leftBanner');
var leftBannerDown = true;
function bannerLeftUp() {
    leftBannerDown = false;
    leftBanner.animate({
        top: -leftBanner.height()
    }, 1000);
}

function bannerLeftDown() {
    leftBannerDown = true;
    leftBanner.animate({
        top: 0
    }, 1000);
}

function enableResponsiveOfHeader() {
    leftBanner.hover(function () {
        bannerLeftDown();
    }, function () {
        bannerLeftUp();
    });
    // leftBanner.click(function () {
    //     if (leftBannerDown)
    //         bannerLeftUp();
    //     else
    //         bannerLeftDown();
    // });
}

//endregion


//region =================== Bouton jouer ===================
function connectionInterface() {
    if (connectionInterfaceIsOpened) {
        $('#menuConnexion').addClass('invisible');
        connectionInterfaceIsOpened = false;
    } else {
        $('#menuConnexion').removeClass('invisible');
        $('#idConnection').focus();

        connectionInterfaceIsOpened = true;
    }

}

function closeConnectionInterface() {
    $('#menuConnexion').addClass('invisible');
    connectionInterfaceIsOpened = false;
}

// endregion

$(document).ready(function () {

    $("#connectionButton").click(seConnecter);

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
    leftBanner = $('#leftBanner');
    // enableResponsiveOfHeader();
});