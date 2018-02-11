function connection() {
    $.ajax({
        type: 'post',
        url: '/app/controller/connection/connection.php',
        data: {
            'id': $('#idConnection').val(),
            'pwd': $('#pwdConnection').val()
        }
    }).done(function (data) {
        if (data.ok === 1) {
            if (document.location.search === "?p=c")
                document.location = "/" + document.location.search;
            else if (document.location.search === "?p=user")
                document.location = "/?p=user";
            else
                document.location = "/?p=i";
        }
        else if (data.ok === -1) {
            $('#pwdConnection').css({'background': 'rgb(200,25,25)'});
        }
        else if (data.ok === -2) {
            $('#idConnection').css({'background': 'rgb(200,25,25)'});
        }
    }).fail(erreurCritique);
}

$(document).ready(function () {
    $('#connectionButton').click(function () {
        connection();
    });
});