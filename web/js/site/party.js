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

$(document).ready(function () {
    if ($('#wrapper').width() < 415) {
        responsive();
    }
});