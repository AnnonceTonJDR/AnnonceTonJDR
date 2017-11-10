var mail;
var code;

function sendMailWithCode() {
    mail = $("#id").val();
    $.ajax({
        type: 'get',
        url: 'app/controller/connection/sendResetPwdCode.php?id=' + mail
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
    $.ajax({
        type: 'get',
        url: 'app/controller/connection/checkCode.php?id=' + mail + "&code=" + $('#codeReinit').val()
    }).done(function (data) {
        if (data.ok) {
            code = $('#codeReinit').val();
            $('#enterCode').slideUp('quick', function () {
                $('#reset').slideDown('down');
            });
        }
        else {
            alert(data.message);
        }
    }).fail(erreurCritique);
}

function resetMDP() {
    $.ajax({
        type: 'get',
        url: 'app/controller/connection/resetPwdWithCode.php?id=' + mail + "&code=" + $('#codeReinit').val()
        + "&mdp=" + $('#pwdReset').val() + "&confirm=" + $('#pwdConfirm').val()
    }).done(function (data) {
        if (data.ok) {
            $('#reset').slideUp('quick', function () {
                $('#succesPassword').slideDown('down');
            });
        }
        else {
            alert(data.message);
        }
    }).fail(erreurCritique);
    //TODO ajax avec mail, code, et new mdp /mdp confirm
    //TODO renvoie oui ou non (et si erreur, affichage)
}

$(document).ready(function () {

    $("#id").keypress(function (event) {
        if (event.key === 'Enter')
            sendMailWithCode();
    });

    $('#sendCodeButton').click(function () {
        sendMailWithCode();
    });

    $('#hasCodeAlreadyButton').click(function () {
        $('#askingReset').slideUp('quick', function () {
            $('#askingMail').slideDown('down');
        });
    });

    $('#validateMail').click(function () {
        mail = $("#mail").val();
        $('#askingMail').slideUp('quick', function () {
            $('#enterCode').slideDown('down');
        });
    });

    $("#codeReinit").keypress(function (event) {
        if (event.key === 'Enter')
            validateCode();
    });

    $('#btnCode').click(function () {
        validateCode();
    });

    $("#pwdReset, #pwdConfirm").keypress(function (event) {
        if (event.key === 'Enter')
            resetMDP();
    });

    $('#validateNewPwd').click(function () {
        resetMDP();
    });
});


