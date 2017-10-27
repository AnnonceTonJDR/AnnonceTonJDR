var mail;
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
        $('#askingReset').slideUp('quick', function () {
            $('#enterCode').slideDown('down');
        })
        });
    });
    $('#hasCodeAlreadyButton').click(function () {
        mail = $("#id").val();
        $('#askingReset').slideUp('quick', function () {
            $('#askingMail').slideDown('down');
        })
        });
    });
    $('#validateMail').click(function () {
        mail = $("#mail").val();
        $('#askingMail').slideUp('quick', function () {
            $('#enterCode').slideDown('down');
        });
    });
    $('#btnCode').click(function () {
        mail = $("#id").val();
        $('#enterCode').slideUp('quick', function () {
            $('#reset').slideDown('down');
        })
        });
    });
    $('#validateNewPwd').click(function () {
        $('#reset').slideUp('quick', function () {
            $('#succesPassword').slideDown('down');
        })
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

})
;


