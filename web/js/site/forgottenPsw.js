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

    // $('#btnDemande').click(function () {
    //     $.ajax({
    //         type: 'get',
    //         url: 'app/controller/connexion/sendForgottenPWD.php?identifiant=' + $('#identifiant').val()
    //     }).done(function (data) {
    //         if (data.ok) {
    //             code = data.code;
    //             $('#demandeReinitialisation').slideUp('slow');
    //             $('#codeReinitialisation').slideDown('slow');
    //         }
    //         else {
    //             $('#erreurIdentifiant').html(data.message).show();
    //         }
    //
    //     }).fail(erreurCritique);
    // });

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

// $('#btnReinitialisation').click(function () {
//     $.ajax({
//         type: 'get',
//         url: '../../controler/connexion/resetPwdWithCode.php?mdp=' + $('#motDePasseReset').val() + '&confirm=' + $('#motDePasseConfirmation').val() + '&log=' + $('#identifiant').val()
//     }).done(function (data) {
//         if (data.ok) {
//             $('#succesPassword').slideDown('slow');
//             $('#erreurPassword').slideUp('slow');
//             $('#reinitialisation').slideUp('slow');
//         }
//         else {
//             $('#erreurPassword ul').empty();
//             var ul = $('<ul />');
//             for (var j in data.message) {
//                 ul.append($('<li>').html(data.message[j]));
//             }
//             $('#erreurPassword').append(ul).show();
//         }
//
//     }).fail(erreurCritique);
// })
});


