/**
 * Created by Lucas OMS on 09/02/2018.
 */
function responsive() {
    $('.notResponsive').hide();
    $('.responsive').show();
    $('.headerParty').css('font-size', '12px');
}


function details(id) {
    var details = $("#party" + id + " .partyDetails");
    if (details.css('display') === 'none') {
        details.slideDown();
    } else {
        details.slideUp();
    }
}

var openMessage = -1;

function messageTo(idParty) {
    console.log(idParty);
    if (openMessage === idParty) {
        $('#divMessage' + idParty).slideUp();
        openMessage = -1;
    } else {
        if (openMessage !== -1) {
            $('#divMessage' + openMessage).slideUp();
            $('#divMessage' + idParty).slideDown();
        } else
            $('#divMessage' + idParty).slideDown();
        openMessage = idParty;
    }
}

function sendTo(idParty, isPrivate) {
    //If no error
    if (openMessage === idParty) {
        $.ajax({
            type: 'post',
            url: '/app/controller/ajax/sendMessage.php',
            data: {
                'idParty': idParty,
                'private': isPrivate,
                'message': $('#divMessage' + idParty + ' .messageArea').val()
            }
        }).done(function (data) {
            if (data.ok === true) {
                alert("Message envoyé");
                $('#divMessage' + openMessage).slideUp();
                location.reload();
            } else if (data.ok === -1) {
                alert("Vous tentez de vous envoyer un message à vous même");
            } else if (data.ok === -2) {
                alert("Votre message est trop court ! La concision n'est pas toujours de mise.");
            } else if (data.ok === -3) {
                alert("Partie à supprimer invalide");
            }
        });
    }
}

function deleteParty(idParty) {
    $.ajax({
        type: 'post',
        url: '/app/controller/ajax/deleteParty.php',
        data: {
            'idParty': idParty
        }
    }).done(function (data) {
        if (data.ok === true) {
            alert("Partie supprimée");
            location.reload();
        } else if (data.ok === -1) {
            alert("Vous n'êtes pas le propriétaire de cette partie !");
        } else if (data.ok === -2) {
            alert("Vous devriez être connecté");
        }
    });
}

function registerTo(id) {
    $.ajax({
        type: 'post',
        url: '/app/controller/ajax/registerToParty.php',
        data: {
            'id': id
        }
    }).done(function (data) {
        if (data.ok === true) {
            var nbPlayerText = $('#party' + id + ' .nbPlayer');
            nbPlayerText.html((parseInt(nbPlayerText.html().split('/')[0]) + 1) + "/" + nbPlayerText.html().split('/')[1]);
            alert("Inscription effectuée");
            $('#party' + id + ' .subButton').remove();
            $('#party' + id + ' .partyDetails').append('' +
                '<button class="unsubButton" onclick="unregisterTo(' + id + ')">Se désinscrire\n' +
                '</button>');
        } else if (data.ok === -1) {
            alert("Vous êtes déjà inscrit à cette partie ! Allez voir sur votre profil");
        } else if (data.ok === -2) {
            alert("La partie est déjà pleine");
        } else if (data.ok === -3) {
            alert("Ceci est votre partie !");
        }
    });
}

function unregisterTo(id) {
    $.ajax({
        type: 'post',
        url: '/app/controller/ajax/unregisterToParty.php',
        data: {
            'id': id
        }
    }).done(function (data) {
        if (data.ok === true) {
            var nbPlayerText = $('#party' + id + ' .nbPlayer');
            nbPlayerText.html((parseInt(nbPlayerText.html().split('/')[0]) - 1) + "/" + nbPlayerText.html().split('/')[1]);
            alert("Désinscription effectuée");
            $('#party' + id + ' .unsubButton').remove();
            $('#party' + id + ' .partyDetails').append('' +
                '<button class="subButton" onclick="registerTo(' + id + ')">S\'inscrire\n' +
                '</button>');
        } else if (data.ok === -1) {
            alert("Vous n'êtes pas inscrit à cette partie ! Allez voir sur votre profil");
        } else if (data.ok === -2) {
            alert("Ceci est votre partie !");
        }
    });
}

$(document).ready(function () {
    if ($('#wrapper').width() < 415) {
        responsive();
    }
});