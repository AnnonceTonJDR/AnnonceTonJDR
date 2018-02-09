/**
 * Created by Lucas OMS on 09/02/2018.
 */

function details($id) {
    var details = $("#party" + $id + " .partyDetails");
    if (details.css('display') === 'none') {
        details.slideDown();
    } else {
        details.slideUp();
    }
}