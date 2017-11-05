var mail;
var code;

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
    $.ajax({
        type: 'get',
        url: 'app/controller/connexion/checkCode.php?identifiant=' + mail + "&code=" + $('#codeReinit').val()
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
    //TODO ajax avec mail, code, et new mdp /mdp confirm
    //TODO renvoie oui ou non (et si erreur, affichage)
    $('#reset').slideUp('quick', function () {
        $('#succesPassword').slideDown('down');
    });
}

$(document).ready(function () {

    $("#id").keypress(function (event) {
        if (event.key === 'Enter')
            envoyerCode();
    });

    $('#sendCodeButton').click(function () {
        envoyerCode();
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

    $("#motDePasseReset, #motDePasseConfirmation").keypress(function (event) {
        if (event.key === 'Enter')
            resetMDP();
    });

    $('#validateNewPwd').click(function () {
        resetMDP();
    });
});


