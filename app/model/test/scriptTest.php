<?php
include_once '../Users.php';
include_once '../Parties.php';
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tests</title>
        <link href="tests.css" rel="stylesheet">
    </head>

    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
    <button id="cacheTest" onclick="cacherTestsOK();">Cacher les tests passés</button>
    <button id="afficheTest" onclick="afficherTestsOK();">Afficher les tests passés</button>
    <script>
        var affiche = true;

        function afficherTestsOK() {
            affiche = true;
            $('#afficheTest').hide();
            $('#cacheTest').show();
            $('.passed').slideDown();
        }

        function cacherTestsOK() {
            affiche = false;
            $('#afficheTest').show();
            $('#cacheTest').hide();
            $('.passed').slideUp();
        }

        $(document).ready(function () {
            cacherTestsOK();
            $('body').keypress(function (event) {
                if (event.key === 'Enter') {
                    if (affiche)
                        cacherTestsOK();
                    else {
                        afficherTestsOK();
                        $('html, body').animate({
                            scrollTop: $(".function").last().offset().top
                        }, 2000);
                    }
                }
            });
        });
    </script>

<?php


//region ==================== Test Users ====================
//region ==================== Test pseudo/mail existant ============
echo '<p class="fonction">pseudoExisteDeja</p>';
echo '<p class="' . (Users::pseudoAlreadyExists("Test") ? 'passed' : 'failed')
    . '">Le pseudo Test doit exister</p>';
echo '<p class="' . (Users::pseudoAlreadyExists("fdsfsf") ? 'failed' : 'passed')
    . '">Le pseudo fdsfsf ne doit pas exister</p>';
echo '';

echo '<p class="fonction">mailExisteDeja</p>';
echo '<p class="' . (Users::mailAlreadyExists("lucas.oms@hotmail.fr") ? 'passed' : 'failed')
    . '">Le mail lucas.oms@hotmail.fr doit etre utilisé</p>';
echo '<p class="' . (Users::mailAlreadyExists("fsdfsfs") ? 'failed' : 'passed')
    . '">Le mail fsdfsfs ne doit pas etre utilisé</p>';
//endregion

//region ==================== Test getters =========================

echo '<p class="fonction">getByIdentifiantConnexion</p>';
echo '<p class="' . (Users::getByConnectionId("Test") == null ? 'failed' : 'passed')
    . '">L\'utilisateur devrait etre trouvable avec le pseudo Test</p> ';
echo '<p class="' . (Users::getByConnectionId("lucas.oms@hotmail.fr") == null ? 'failed' : 'passed')
    . '">L\'utilisateur devrait etre trouvable avec le mail lucas.oms@hotmail.fr</p> ';
echo '<p class="' . (Users::getByConnectionId("fdsfs") == null ? 'passed' : 'failed')
    . '">Aucun utilisateur ne devrait avoir le pseudo fdsfsf</p>';

echo '';

echo '<p class="fonction">getById</p>';
echo '<p class="' . (Users::getById(1) == null ? 'failed' : 'passed')
    . '">L\'utilisateur devrait etre trouvable avec l\'id 1</p> ';
echo '<p class="' . (Users::getById(555555) == null ? 'passed' : 'failed')
    . '">L\'utilisateur ne devrait pas etre trouvable avec l\'id 555555</p> ';

echo '';

echo '<p class="fonction">getByPseudo</p>';
echo '<p class="' . (Users::getByPseudo("Test") == null ? 'failed' : 'passed')
    . '">L\'utilisateur devrait etre trouvable avec le pseudo Test</p> ';
echo '<p class="' . (Users::getByPseudo("grfsgergsewrgf") == null ? 'passed' : 'passed')
    . '">Aucun utilisateur ne devrait avoir le pseudo grfsgergsewrgf</p>';

echo '';

echo '<p class="fonction">getByMail</p>';
echo '<p class="' . (Users::getByMail("lucas.oms@hotmail.fr") == null ? 'failed' : 'passed')
    . '">L\'utilisateur devrait etre trouvable avec le mail lucas.oms@hotmail.fr</p> ';
echo '<p class="' . (Users::getByMail("grfsgergsewrgf") == null ? 'passed' : 'failed')
    . '">Aucun utilisateur ne devrait avoir le mail grfsgergsewrgf</p>';

//endregion
//endregion


echo '<p class="' . (Parties::isRegisteredOn(1, 4) === true ? 'passed' : 'failed')
    . '">L\'utilisateur 1 est inscrit a la partie 4</p>';
echo '<p class="' . (Parties::isRegisteredOn(0, 53) === false ? 'passed' : 'failed')
    . '">L\'utilisateur 0 ne peut etre inscrit nul part</p>';