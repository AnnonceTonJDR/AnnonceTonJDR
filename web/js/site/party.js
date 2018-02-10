/**
 * Created by Lucas OMS on 09/02/2018.
 */
function responsive() {
    $('.notResponsive').hide();
    $('.responsive').show();
    $('.headerParty').css('font-size', '12px');
}


function details($id) {
    var details = $("#party" + $id + " .partyDetails");
    if (details.css('display') === 'none') {
        details.slideDown();
    } else {
        details.slideUp();
    }
}

function messageTo($idUser) {

}

function registerTo($id) {
    $.ajax({
        type: 'post',
        url: '/app/controller/ajax/registerToParty.php',
        data: {
            'id': $id
        }
    }).done(function (data) {
        if (data.ok === true) {
            var nbPlayerText = $('#party' + $id + ' .nbPlayer');
            nbPlayerText.html((parseInt(nbPlayerText.html().split('/')[0]) + 1) + "/" + nbPlayerText.html().split('/')[1]);
            alert("Inscription effectuée");
        } else if (data.ok === -1) {
            alert("Vous êtes déjà inscrit à cette partie ! Allez voir sur votre profil");
        } else if (data.ok === -2) {
            alert("La partie est déjà pleine");
        } else if (data.ok === -3) {
            alert("Ceci est votre partie !");
        }
    });
}

$(document).ready(function () {
    if ($('#wrapper').width() < 415) {
        responsive();
    }
});