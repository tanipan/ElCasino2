@extends('layouts.web')

@section('content')
    @php
        //$customer = isset(Session::get('login')['cliente']) ? Session::get('login')['cliente'] : null;
    @endphp

    <!-- Content -->

    <!-- Menu mobile -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-lg" id="hscroll">

    </div>
    <!-- /Menu mobile -->
    </div>
    </div>
    </div>
    </header>

    <section id="service" class="service">
        <div class="container">
            <div class="row">
                <div class="main_service_area sections">
                    <div class="col-lg-2 hidden-md hidden-sm hidden-xs" id="category">
                        <div class="post1 fix">
                            <ul class="get_cate" style="top: 100px;margin-top: 13px;">
                                <li id="special">
                                    <a href="javascript:void(0);" id="cart" class="btn_cart" bid="37187"><i
                                            class="fa fa-shopping-basket"></i>&nbsp;CESTA&nbsp;&nbsp;&nbsp;
                                        <span id="totaal2"> 0 </span>
                                    </a>
                                </li>
                                <li id="special">
                                    <a href="{{ route('front.recoger') }}" class="btn_cart">Volver a Carta</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-lg-offset-3 col-md-8 col-sm-12" id="xinxi">
                        <h3>Mi Cuenta</h3>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="plink">
                            <div class="link1 col-md-12">
                                <a href="javascript:void(0);">Datos personales<span>&nbsp;&nbsp;&nbsp;&nbsp;<i
                                            class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                            </div>
                            <div id="link1" class="col-md-8 col-md-offset-2">
                                <form action="{{ route('front.modificarDatos', ['token' => $customer->token]) }}"
                                    method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>Correo electrónico:
                                            </label>
                                            <input type="text" name="email" id="email"
                                                value="{{ $customer->email }}" class="form-control" readonly />
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label>Nombre: </label>
                                            <input type="text" name="name" id="name"
                                                value="{{ $customer->name }}" class="form-control" />
                                            @error('name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label>Apellido: </label>
                                            <input type="text" name="lastname" id="lastname"
                                                value="{{ $customer->lastname }}" class="form-control" />
                                            @error('lastname')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label>Teléfono: </label>
                                            <input type="text" name="phone" id="phone"
                                                value="{{ $customer->phone }}" class="form-control"
                                                placeholder="ej: 0X XXX XX XX o 0XXX XX XX XX" />
                                            @error('phone')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" id="newsletter"
                                                    name="newsletter" {{ $customer->newsletter ? 'checked' : '' }} />
                                                Suscríbete a nuestro boletín.
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <p class="cmsg"></p>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <button id="change" class="btn btn-primary" rid="11">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="link2 col-md-12">
                                <a href="javascript:void(0);">Datos de acceso<span>&nbsp;&nbsp;&nbsp;&nbsp;<i
                                            class="fa fa-chevron-down" aria-hidden="true"></i></span></a>
                            </div>
                            <div id="link2" class="col-md-8 col-md-offset-2">
                                <form action="{{ route('front.modificarPassword', ['token' => $customer->token]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="control-label">Contraseña:
                                        </label>
                                        <input type="password" name="currpass" id="currpass" class="form-control" />
                                        @error('currpass')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label">Nueva Contraseña:
                                        </label>
                                        <input type="password" name="password" id="password" class="form-control" />
                                        @error('password')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label">Confirmar nueva contraseña:
                                        </label>
                                        <input type="password" name="password2" id="password2" class="form-control" />
                                        @error('password2')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <p class="pmsg"></p>
                                    <br />
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="btns">
                                        <button id="change2" class="btn btn-primary" rid="11">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                            <div id="link" class="col-md-12">
                                <a href="{{ route('front.logout') }}">Cerrar Sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content -->
@endsection
