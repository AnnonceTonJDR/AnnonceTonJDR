/**
 * Javascript pour le formulaire de connection contenu dans le header
 *
 * @author Lucas OMS
 */

var connectionInterfaceIsOpened = false;
var wrapper = $('#wrapper');
var responsiveBannerEnabled = false;

function erreurCritique() {
    $('#contenu').html(
        'Une erreur irrécupérable est survenue. <br />'
        + 'Merci de contcter l\'admin <br/>'
        + 'contact@annonceTonJDR.fr'
    );
}

//region =================== Responsive of banner ===================
var leftBanner = $('#leftBanner');
var leftBannerDown = true;
var leftBannerArrow = $('#leftBannerArrow');

function bannerLeftUp() {
    leftBanner.clearQueue();
    leftBannerDown = false;
    leftBanner.animate({
        top: -leftBanner.height() + 7
    }, 700);
    $({deg: 0}).animate({deg: 180}, {
        duration: 700,
        step: function (now) {
            // in the step-callback (that is fired each step of the animation),
            // you can use the `now` paramter which contains the current
            // animation-position (`0` up to `angle`)
            leftBannerArrow.css({
                transform: 'rotate(' + now + 'deg)'
            });
        }
    });
}

function bannerLeftDown() {
    leftBanner.clearQueue();
    leftBannerDown = true;
    leftBanner.animate({
        top: 0
    }, 700);
    $({deg: 180}).animate({deg: 360}, {
        duration: 700,
        step: function (now) {
            // in the step-callback (that is fired each step of the animation),
            // you can use the `now` paramter which contains the current
            // animation-position (`0` up to `angle`)
            leftBannerArrow.css({
                transform: 'rotate(' + now + 'deg)'
            });
        }
    });
}

function enableResponsiveOfHeader() {
    leftBannerArrow.click(function () {
        if (leftBannerDown) {
            bannerLeftUp();
        } else {
            bannerLeftDown();
        }
    });
    $('#rightBanner').remove();
    $('#leftBanner ul li').first().remove();
    var addTo = $('#leftBanner ul');
    if ($('header').data('connected') === 1)
        addTo.prepend('<li><a id="deconnectionButton">Se déconnecter</a></li>');
    else
        addTo.prepend('<li><a href="/?p=signin">Se connecter</a></li>');
    addTo.prepend('<li><a href="/?p=i">Accueil</a></li>');
    $('#deconnectionButton').click(function () {
        $.ajax({
            type: 'get',
            url: '/app/controller/connection/deconnexion.php'
        }).done(function () {
            location.reload(true);
        }).fail(erreurCritique);
    });
    $('header .title').css('text-align', 'right');
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

    $('#idConnection').keypress(function (event) {
        if (event.key === 'Enter')
            seConnecter();
    });

    $('#pwdConnection').keypress(function (event) {
        if (event.key === 'Enter')
            seConnecter();
    });

    $('#openConnectionMenuButton').click(connectionInterface);
    $('.js_close_connectionInterface, footer').click(closeConnectionInterface);
    leftBanner = $('#leftBanner');
    leftBannerArrow = $('#leftBannerArrow');
    if (wrapper.width() < 1350) {
        responsiveBannerEnabled = true;
    }
    if (responsiveBannerEnabled) {
        enableResponsiveOfHeader();
    } else {
        $('#leftBannerArrow').hide();
        $('#deconnectionButton').click(function () {
            $.ajax({
                type: 'get',
                url: '/app/controller/connection/deconnexion.php'
            }).done(function () {
                location.reload(true);
            }).fail(erreurCritique);
        });
    }
    wrapper.scroll(function () {
        if (responsiveBannerEnabled) {
            if (leftBannerDown)
                bannerLeftUp();
        }
    });
});