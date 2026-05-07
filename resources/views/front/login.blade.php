@extends('layouts.webInside')

@section('content')
    <section>
        <div class="d-md-flex d-sm-block p-4 my-3">
            <div class="col-md-6">
                <div class="p-3 ">
                    <div class="text-center">

                        <h2 class="fw-bold">
                            Bienvenido de vuelta!
                        </h2>
                        <p class="text-secondary">
                            Ingresa con tu correo electronico y contraseña
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <form class="col-md-8 col-sm-12" action="{{ route('front.validarLogin') }}" method="POST">
                            @csrf
                            <div>
                                <label class="text-secondary" for="">Correo eléctronico</label>
                                <input class="form-control" type="text" name="email">
                            </div>
                            <br>
                            <div>
                                <label class="text-secondary" for="">Contraseña</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class="d-flex text-center justify-content-center align-items-center my-3">
                                <!--<input type="checkbox">
                                                            <p class="mx-3 m-0">
                                                                Recordar usuario para este dispositivo
                                                            </p>-->
                                @if (Session::get('error'))
                                    <div class="alert alert-danger mt-3" role="alert">
                                        El usuario o la contraseña no coinciden
                                    </div>
                                @endif
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success">
                                    Ingresar
                                </button>
                            </div>
                            <div class="d-flex justify-content-center text-center my-3">
                                ¿No recuerdas tu contraseña?
                                <a class="mx-2" href="{{ route('front.recordar') }}">
                                    Recupérala desde aqui
                                </a>
                            </div>
                            <div class="d-flex justify-content-center text-center my-3">
                                ¿Aún no tienes cuenta?
                                <a class="mx-2" href="{{ route('front.registro') }}">
                                    Registrate aqui
                                </a>
                            </div>
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
