@extends('layouts.webInside')

@section('content')
    <section>
        <div class="d-md-flex d-sm-block p-4 my-3">
            <div class="col-md-6">
                <div class="p-3 ">
                    <div class="text-center">

                        <h2 class="fw-bold">
                            Registrate
                        </h2>

                    </div>
                    <div class="d-flex justify-content-center">
                        <form class="col-md-8 col-sm-12" action="{{ route('front.registrarCliente') }}" method="POST"
                            id="formu">
                            @csrf
                            <div>
                                <label class="text-secondary" for="">Nombre </label>
                                <input class="form-control" type="text" name="name" id="name">
                            </div>
                            <br>
                            <div>
                                <label class="text-secondary" for="">Apellidos</label>
                                <input class="form-control" type="text" name="lastname" id="lastname">
                            </div>
                            <br>
                            <div>
                                <label class="text-secondary" for="">Teléfono</label>
                                <input class="form-control" type="text" name="phone" id="phone">
                            </div>
                            <br>
                            <div>
                                <label class="text-secondary" for="">Correo electronico</label>
                                <input class="form-control" type="text" name="email" id="email"
                                    value="{{ Auth::user() ? $email_random : '' }}">
                                @error('email')
                                    <div class="alert alert-danger" role="alert" style="padding: 4px;margin-top: 10px;">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <div>
                                <label class="text-secondary" for="">Contraseña (min. 6 caracteres)</label>
                                <input class="form-control" type="password" name="password" id="password"
                                    value="{{ Auth::user() ? $pass_random : '' }}">
                            </div>
                            <br>
                            <div>
                                <label class="text-secondary" for="">Confirmar contraseña</label>
                                <input class="form-control" type="password" id="password2"
                                    value="{{ Auth::user() ? $pass_random : '' }}">
                            </div>
                            <div class="d-flex text-center justify-content-center align-items-center my-3">
                                <input type="checkbox" class="form-check-input" id="terminos"
                                    {{ Auth::user() ? 'checked' : '' }}>&nbsp;
                                <label class="form-check-label" for="terminos">Al registrarte aceptas nuestros
                                    <a target="_black" href="{{ route('front.privacidad') }}">Terminos &
                                        Condiciones</a></label>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-success" id="registrarse">
                                    Registrarse
                                </button>
                            </div>

                            @if (Auth::user() == null)
                                <div class="d-flex justify-content-center text-center my-3">
                                    ¿Ya tienes cuenta?
                                    <a class="mx-2" href="{{ route('front.login') }}">
                                        Accede desde aqui
                                    </a>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 align-self-center">
                <div class="d-flex justify-content-center align-items-center p-4">
                    <img class="img-fluid rounded-3" src="assets/img/carousel.jpeg" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $("#name").focus();
        $("#registrarse").click(function() {
            if ($("#name").val() && $("#lastname").val() && $("#email").val() && $("#phone").val()) {

                if ($("#password").val() == $("#password2").val()) {

                    if ($("#password").val().length >= 6) {
                        if (document.getElementById('terminos').checked) {
                            $("#formu").submit();
                        } else {
                            alert("Debes de aceptar los Términos y Condiciones");
                        }
                    } else {
                        alert("La contraseña debe de tener más de 6 caracteres");
                    }
                } else {
                    alert("Las contraselas no coinciden");
                }
            } else {
                alert("Inserta todos los datos");
            }
        });
    });
</script>
