/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    function skip() {
        location.href = "../order/";
    }

    $("#make").on("click", function () {
        var firstname = $("#name").val().trim();
        var naam = $("#lastname").val().trim();

        firstname += "@";
        firstname += naam;
        var tel = $("#phone").val().trim();
        var email = $("#email").val().trim();
        var p1 = $("#password1").val().trim();
        var p2 = $("#password2").val().trim();

        var newletter = $("#newletter").is(":checked") ? 1 : 0;
        var preg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,})$/;
        if (naam == "" || firstname == "") {
            $(".emsg").html("El campo nombre no puede estar vacío!");
        } else if (email == "" || !preg.test(email)) {
            $(".emsg").html("Correo electrónico no válido!");
        } else if (tel == "") {
            $(".emsg").html("El número de teléfono no es válido!");
        } else if (p1 == "" || p2 == "") {
            $(".emsg").html("El campo de contraseña no puede estar vacío!");
        } else if (p1 != p2) {
            $(".emsg").html("Contraseñas no coinciden!");
        } else {
            $.post(
                "newUserCheck.php",
                {
                    naam: firstname,
                    tel: tel,
                    email: email,
                    password: p1,
                    newletter: newletter,
                },
                function (msg) {
                    if (msg == "ongeldig") {
                        $(".emsg").html(
                            "Este correo electrónico se encuentra ya registrado!"
                        );
                    } else {
                        showAlert(msg);
                        $("#name").val("");
                        $("#lastname").val("");
                        $("#phone").val("");
                        $("#email").val("");
                        $("#password1").val("");
                        $("#password2").val("");
                        $("#newletter").prop("checked", false);
                        setInterval(skip, 2000);
                    }
                }
            );
        }
    });
});
