@extends('layouts.webInside')

@section('content')
    <section>
        <div class="d-md-flex d-sm-block p-4 my-3">
            <div class="col-md-6">
                <div class="p-3 ">
                    <div class="text-center">

                        <h2 class="fw-bold">
                            Reupera tu contraseña
                        </h2>
                        <p class="text-secondary">
                            Ingresa con tu correo y te mandaremos un mail para cambiar tu contraseña
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <form class="col-md-8 col-sm-12" action="{{ route('front.recordar1') }}" method="POST">
                            @csrf
                            <div>
                                <label class="text-secondary" for="">Correo eléctronico</label>
                                <input class="form-control" type="text" name="email">
                            </div>
                            <div class="d-flex text-center justify-content-center align-items-center my-3">
                                @if (Session::get('status') === true)
                                    <div class="alert alert-success mt-3" role="alert">
                                        Te hemos mandado un mail para recuperar tu contraseña correctamente
                                    </div>
                                @endif
                                @if (Session::get('status') === false)
                                    <div class="alert alert-danger mt-3" role="alert">
                                        El correo indicado no existe en nuestro sistema
                                    </div>
                                @endif
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success">
                                    Recuperar
                                </button>
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
