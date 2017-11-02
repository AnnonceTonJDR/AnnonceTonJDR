$(document).ready(function () {
    var code;

    $('#btnDemande').click(function () {
        $.ajax({
            type: 'get',
            url: 'app/controller/connexion/sendForgottenPWD.php?identifiant=' + $('#identifiant').val()
        }).done(function (data) {
            if (data.ok) {
                code = data.code;
                $('#demandeReinitialisation').slideUp('slow');
                $('#codeReinitialisation').slideDown('slow');
            }
            else {
                $('#erreurIdentifiant').html(data.message).show();
            }

        }).fail(erreurCritique);
    });

    $('#btnCode').click(function () {
        console.log(code);
        console.log($('#codeReinit').val());
        if ($('#codeReinit').val() == code) {
            $('#codeReinitialisation').slideUp('slow');
            $('#reinitialisation').slideDown('slow');
        }
    });

    $('#btnReinitialisation').click(function () {
        $.ajax({
            type: 'get',
            url: '../../controler/connexion/resetMDP.php?mdp=' + $('#motDePasseReset').val() + '&confirm=' + $('#motDePasseConfirmation').val() + '&log=' + $('#identifiant').val()
        }).done(function (data) {
            if (data.ok) {
                $('#succesPassword').slideDown('slow');
                $('#erreurPassword').slideUp('slow');
                $('#reinitialisation').slideUp('slow');
            }
            else {
                $('#erreurPassword ul').empty();
                var ul = $('<ul />');
                for (var j in data.message) {
                    ul.append($('<li>').html(data.message[j]));
                }
                $('#erreurPassword').append(ul).show();
            }

        }).fail(erreurCritique);
    })

});


