var mail;


function envoyerCode() {
    mail = $("#id").val();
    //TODO envoi du mail avec le code
    $.ajax({
        type: 'get',
        url: 'app/controller/connexion/sendResetPwdCode.php?identifiant=' + mail
    }).done(function (data) {
        if (data.ok) {
            $('#askingReset').slideUp('quick', function () {
                $('#enterCode').slideDown('down');
            });
        }
        else {
            alert("Mail invalide");
        }

    }).fail(erreurCritique);
}

function validateCode() {
    //TODO vérifie le code sur la BD
    $('#enterCode').slideUp('quick', function () {
        $('#reset').slideDown('down');
    });
}

function resetMDP() {
    //TODO ajax avec mail, code, et new mdp /mdp confirm
    //TODO renvoie oui ou non (et si erreur, affichage)
    $('#reset').slideUp('quick', function () {
        $('#succesPassword').slideDown('down');
    });
}

$(document).ready(function () {


    $('#sendCodeButton').click(function () {
        mail = $("#id").val();
        //TODO envoi du mail avec le code
        $('#askingReset').slideUp('quick', function () {
            $('#enterCode').slideDown('down');
        });
    });

    $('#hasCodeAlreadyButton').click(function () {
        mail = $("#mail").val();
        $('#askingReset').slideUp('quick', function () {
            $('#askingMail').slideDown('down');
        });
    });

    $('#validateMail').click(function () {
        $('#askingMail').slideUp('quick', function () {
            $('#enterCode').slideDown('down');
        });
    });

    $('#btnCode').click(function () {
        //TODO vérifie le code sur la BD
        $('#enterCode').slideUp('quick', function () {
            $('#reset').slideDown('down');
        });
    });

    $('#validateNewPwd').click(function () {
        //TODO ajax avec mail, code, et new mdp /mdp confirm
        //TODO renvoie oui ou non (et si erreur, affichage)
        $('#reset').slideUp('quick', function () {
            $('#succesPassword').slideDown('down');
        });
    });

});


