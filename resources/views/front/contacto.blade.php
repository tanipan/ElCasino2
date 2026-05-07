@extends('layouts.webInside')

@section('content')
    <div class="paddingBody my-5 d-lg-flex d-md-flex d-sm-block">
        <div class="col-lg-6 px-3">
            <div class="fs-2 fw-bold">
                Contáctanos
            </div>
            <div class="d-md-flex d-sm-block my-2">
                <div class="col-5 d-flex">
                    <div class="align-self-center me-4">
                        <i class="colorIcono fondoIcono px-3 py-3 rounded-circle bi bi-telephone-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="fs-4 mb-1" style="font-weight: 500;">
                            Llamanos
                        </div>
                        <div>
                            868 920 297
                        </div>
                    </div>
                </div>
                <div class="col-7 d-flex ">
                    <div class="align-self-center me-4">
                        <i class="colorIcono fondoIcono px-3 py-3 rounded-circle bi bi-telephone-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="fs-4 mb-1" style="font-weight: 500;">
                            Whatsapp
                        </div>
                        <div>
                            <a href="https://wa.me/+34868920297">868 920 297</a>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <div class="fs-2 fw-bold">
                Envianos un mensaje
            </div>
            <form action="{{ route('front.contactoEnviar') }}" method="POST" id="formu">
                <div class="my-2">
                    @csrf
                    <input placeholder="Nombre" type="text" class="fondoGris my-1" name="name" id="name">
                    <input placeholder="Correo electrónico" type="text" class="fondoGris my-1" name="email"
                        id="email">
                    <input placeholder="Asunto" type="text" class="fondoGris my-1" name="subject" id="subject">
                    <textarea placeholder="Mensaje" type="text" class="fondoGris my-1" cols="30" name="message" id="message"
                        rows="3"></textarea>
                </div>
                @if (Session::get('status') === true)
                    <div class="alert alert-success mt-3" role="alert">
                        Hemos recibido correctamente tu mensaje.
                    </div>
                @endif
                <div id="captcha">
                </div>
                <input type="text" placeholder="Inserta el código" id="cpatchaTextBox" />
                <br><br>
                <button class="btn fondoVerde fs-4 fw-bold" type="button" id="enviar">
                    Enviar mensaje
                </button>
            </form>
        </div>
        <div class="col-lg-6 px-3">
            <div class="fs-2 fw-bold">
                Ubicación
            </div>
            <div class="w-100 h-100">
                <div id="map-container-google-1" class=" map-container h-100 my-3">
                    <iframe class="img-fluid h-75"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12601.663046325128!2d-1.4272734!3d37.8505612!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xef00b2bad61a9650!2sRestaurante%20Los%20Bartolos!5e0!3m2!1ses!2sco!4v1638488969676!5m2!1ses!2sco"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </div>
    </div>
@endsection

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#enviar").click(function() {

            if (($("#name").val() != "HenryNix") && ($("#name").val() != "CrytoNix")) {

                if ($("#name").val() && $("#email").val() && $("#subject").val() && $("#message")
                    .val()) {
                    if (ValidateEmail($("#email").val())) {
                        if (validateCaptcha()) {
                            $("#formu").submit();
                        }
                    } else {
                        alert("El correo no es correcto")
                    }

                } else {
                    alert("Inserta todos los datos");
                }

            }

        });

        createCaptcha()
    });

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return (true)
        }
        return (false)
    }

    var code;

    function createCaptcha() {
        //clear the contents of captcha div first 
        document.getElementById('captcha').innerHTML = "";
        var charsArray =
            "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%&*";
        var lengthOtp = 10;
        var captcha = [];
        for (var i = 0; i < lengthOtp; i++) {
            //below code will not allow Repetition of Characters
            var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
            if (captcha.indexOf(charsArray[index]) == -1)
                captcha.push(charsArray[index]);
            else i--;
        }
        var canv = document.createElement("canvas");
        canv.id = "captcha";
        canv.width = 200;
        canv.height = 50;
        var ctx = canv.getContext("2d");
        ctx.font = "25px Georgia";
        ctx.strokeText(captcha.join(""), 0, 30);
        //storing captcha so that can validate you can save it somewhere else according to your specific requirements
        code = captcha.join("");
        document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
    }

    function validateCaptcha() {
        event.preventDefault();
        if (document.getElementById("cpatchaTextBox").value == code) {
            return true;
        } else {
            alert("Inserta el código");
            createCaptcha();
            return false;
        }
    }
</script>
