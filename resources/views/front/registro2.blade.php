@extends('layouts.web')

@section('content')
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
                <!--   <div class="service_border_raund text-center"></div>  -->
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
                                <li id="special"><a href="{{ route('front.recoger') }}" class="btn_cart">Volver a
                                        Carta</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-lg-offset-3 col-md-12" id="xinxi">
                        <div class="box">
                            <h3>Crear tu cuenta</h3>
                            <div class="separator4"></div>



                            <form action="{{ route('front.registrarCliente') }}" method="post" id="formu_registro">
                                @csrf
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label>Nombre: <span>*</span></label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label>Apellido: <span>*</span></label>
                                    <input type="text" name="lastname" id="lastname" class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label>Teléfono: <span>*</span></label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ request('telefono') }}">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label>Correo electrónico: <span>*</span></label>
                                    <input type="text" name="email" id="email" class="form-control" value="">
                                    <script>
                                        @if (request('telefono'))
                                            document.addEventListener('DOMContentLoaded', function() {
                                                document.getElementById('email').value = correo;
                                                document.getElementById('password').value = contrasena;
                                                document.getElementById('password2').value = contrasena;
                                            });
                                        @endif
                                    </script>
                                    @error('email')
                                        <div class="alert alert-danger" role="alert" style="padding: 4px;margin-top: 10px;">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label>Contraseña: <span>*</span></label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label>Repetir contraseña: <span>*</span></label>
                                    <input type="password" name="password2" id="password2" class="form-control">
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter"
                                            {{ request('telefono') ? 'checked' : '' }}>
                                        Suscríbete a nuestro
                                        boletín.
                                    </label>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="terminos"
                                            {{ request('telefono') ? 'checked' : '' }}> He leído y acepto la
                                        Política de Privacidad
                                        De conformidad con las normativas de protección de datos, le facilitamos la
                                        siguiente información del tratamiento:
                                        Responsable: THE URBAN S.L.
                                        Fines del tratamiento: mantener una relación comercial y enviar comunicaciones de
                                        productos o servicios
                                        Derechos que le asisten: acceso, rectificación, portabilidad, supresión, limitación
                                        y oposición
                                        <a target="_black" style="color: blue" href="{{ route('privacidad') }}">Más
                                            información</a>
                                    </label>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <p class="emsg"></p>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">

                                    <a id="registrarse" class="btn btn-primary">Registrarse</a>
                                </div>

                                <!--
                                                                                                                                                                                    <div class="text-center">
                                                                                                                                                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Registeren</button>
                                                                                                                                                                                    </div>
                                                                                                                                                                                 -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function generarCorreoAleatorio() {
            const caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
            let usuario = '';
            for (let i = 0; i < 10; i++) {
                usuario += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            return usuario + '@pedidotelefonico.com';
        }

        function generarContrasenaSegura(longitud = 12) {
            const mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const minusculas = 'abcdefghijklmnopqrstuvwxyz';
            const numeros = '0123456789';
            const simbolos = '!@#$%^&*()_+-=[]{}|;:,.<>?';

            const todos = mayusculas + minusculas + numeros + simbolos;

            let contrasena = '';
            contrasena += mayusculas.charAt(Math.floor(Math.random() * mayusculas.length));
            contrasena += minusculas.charAt(Math.floor(Math.random() * minusculas.length));
            contrasena += numeros.charAt(Math.floor(Math.random() * numeros.length));
            contrasena += simbolos.charAt(Math.floor(Math.random() * simbolos.length));

            for (let i = 4; i < longitud; i++) {
                contrasena += todos.charAt(Math.floor(Math.random() * todos.length));
            }

            // Mezclar la contraseña para evitar patrones
            contrasena = contrasena.split('').sort(() => 0.5 - Math.random()).join('');
            return contrasena;
        }

        var correo = generarCorreoAleatorio();
        var contrasena = generarContrasenaSegura();
    </script>
    <!-- Content -->
@endsection
