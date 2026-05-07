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
                        <h3>Cambiar contraseña</h3>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="plink">
                            <div class="link3 col-md-12">
                                <a href="javascript:void(0);">Inserta una nueva
                                    contraseña<span>&nbsp;&nbsp;&nbsp;&nbsp;</span></a>
                            </div>
                            <div id="link2" class="col-md-8 col-md-offset-2">
                                <form action="{{ route('front.recordar3', ['token' => $token]) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="password" class="control-label">Nueva Contraseña:
                                        </label>
                                        <input type="hidden" name="token" id="token" class="form-control"
                                            value="{{ old('token') ? old('token') : $token }}" />
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
                                        <button id="change2" class="btn btn-primary" rid="11">Cambiar
                                            contraseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content -->
@endsection
