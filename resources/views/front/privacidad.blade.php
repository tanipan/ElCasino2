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
                            <div class="elementor-element elementor-element-4b088c3 elementor-widget elementor-widget-text-editor"
                                data-id="4b088c3" data-element_type="widget" data-widget_type="text-editor.default">
                                <div class="elementor-widget-container">

                                    <style>
                                        .mi-lista {
                                            list-style: disc;
                                            padding: 20px;
                                            margin: 0;
                                        }
                                    </style>

                                    <h4><strong>POLÍTICA DE PRIVACIDAD</strong></h4>

                                    <strong>
                                        <p>1. INFORMACIÓN AL USUARIO
                                    </strong></p>
                                    <p><strong>¿Quién es el responsable del tratamiento de tus datos personales?</strong>
                                    </p>
                                    <p>THE URBAN BURGER S.L. es el RESPONSABLE del tratamiento de los datos personales del
                                        USUARIO
                                        y le informa de que estos datos serán tratados de conformidad con lo dispuesto en el
                                        Reglamento (UE) 2016/679,
                                        de 27 de abril (GDPR), y la Ley Orgánica 3/2018, de 5 de diciembre (LOPDGDD).</p>
                                    <p><strong>¿Para qué tratamos tus datos personales?</strong></p>
                                    <p>Para mantener una relación comercial con el usuario. Las operaciones previstas para
                                        realizar el tratamiento
                                        son:</p>

                                    <ul class="mi-lista">
                                        <li>Remisión de comunicaciones comerciales publicitarias por e-mail, fax, SMS, MMS,
                                            redes
                                            sociales o
                                            cualquier otro medio electrónico o físico, presente o futuro, que posibilite
                                            realizar
                                            comunicaciones
                                            comerciales. Estas comunicaciones serán realizadas por el RESPONSABLE y estarán
                                            relacionadas con
                                            sus productos y servicios, o de sus colaboradores o proveedores, con los que
                                            este
                                            haya
                                            alcanzado
                                            algún acuerdo de promoción. En este caso, los terceros nunca tendrán acceso a
                                            los
                                            datos
                                            personales.
                                        </li>
                                        <li>Realizar estudios de mercado y análisis estadísticos.</li>
                                        <li>Tramitar encargos, solicitudes, dar respuesta a las consultas o cualquier tipo
                                            de
                                            petición que sea
                                            realizada por el USUARIO a través de cualquiera de las formas de contacto que se
                                            ponen a
                                            su
                                            disposición en la página web del RESPONSABLE.</li>
                                        <li>Remitir el boletín informativo online, sobre novedades, ofertas y promociones en
                                            nuestra
                                            actividad.</li>
                                    </ul>

                                    <p><strong>¿Por qué motivo podemos tratar tus datos personales?</strong></p>
                                    <p>Porque el tratamiento está legitimado por el artículo 6 del GDPR de la siguiente
                                        forma:</p>
                                    <ul class="mi-lista">
                                        <li>Con el consentimiento del USUARIO: remisión de comunicaciones comerciales y del
                                            boletín
                                            informativo.</li>
                                        <li>Por interés legítimo del RESPONSABLE: realizar estudios de mercado, análisis
                                            estadísticos, etc. y
                                            tramitar encargos, solicitudes, etc. a petición del USUARIO.</li>
                                    </ul>
                                    <p><strong>¿Durante cuánto tiempo guardaremos tus datos personales?</strong></p>
                                    <p>Se conservarán durante no más tiempo del necesario para mantener el fin del
                                        tratamiento
                                        o existan
                                        prescripciones legales que dictaminen su custodia y cuando ya no sea necesario para
                                        ello, se suprimirán con
                                        medidas de seguridad adecuadas para garantizar la anonimización de los datos o la
                                        destrucción total de los
                                        mismos.
                                    </p>
                                    <p><strong>¿A quién facilitamos tus datos personales?</strong></p>
                                    <p>No está prevista ninguna comunicación de datos personales a terceros salvo, si fuese
                                        necesario para el
                                        desarrollo y ejecución de las finalidades del tratamiento, a nuestros proveedores de
                                        servicios relacionados con
                                        comunicaciones, con los cuales el RESPONSABLE tiene suscritos los contratos de
                                        confidencialidad y de
                                        encargado de tratamiento exigidos por la normativa vigente de privacidad.</p>
                                    <p><strong>¿Cuáles son tus derechos?</strong></p>
                                    <p>Los derechos que asisten al USUARIO son:</p>
                                    <ul class="mi-lista">
                                        <li>
                                            Derecho a retirar el consentimiento en cualquier momento.
                                        </li>
                                        <li>
                                            Derecho de acceso, rectificación, portabilidad y supresión de sus datos, y de
                                            limitación u oposición a su
                                            tratamiento.
                                        </li>
                                        <li>
                                            Derecho a presentar una reclamación ante la autoridad de control (www.aepd.es)
                                            si
                                            considera que el tratamiento no se ajusta a la normativa vigente.
                                        </li>
                                    </ul>

                                    <p><strong> Datos de contacto para ejercer sus derechos:</strong></p>
                                    <p> THE URBAN S.L. Calle Vidal Abarca 3, bajo - 30840 ALHAMA DE MURCIA (Murcia).
                                        E-mail: info@smashurban.com</p>
                                    <p><strong>
                                            2. CARÁCTER OBLIGATORIO O FACULTATIVO DE LA INFORMACIÓN FACILITADA POR EL
                                            USUARIO</strong></p>
                                    <p>
                                        Los USUARIOS, mediante la marcación de las casillas correspondientes y la entrada de
                                        datos en los campos,
                                        marcados con un asterisco (*) en el formulario de contacto o presentados en
                                        formularios
                                        de descarga, aceptan
                                        expresamente y de forma libre e inequívoca, que sus datos son necesarios para
                                        atender su
                                        petición, por parte
                                        del prestador, siendo voluntaria la inclusión de datos en los campos restantes. El
                                        USUARIO garantiza que los
                                        datos personales facilitados al RESPONSABLE son veraces y se hace responsable de
                                        comunicar cualquier
                                        modificación de los mismos.</p>
                                    <p>
                                        El RESPONSABLE informa de que todos los datos solicitados a través del sitio web son
                                        obligatorios, ya que
                                        son necesarios para la prestación de un servicio óptimo al USUARIO. En caso de que
                                        no se
                                        faciliten todos los
                                        datos, no se garantiza que la información y servicios facilitados sean completamente
                                        ajustados a sus
                                        necesidades.</p>
                                    <p><strong>3. MEDIDAS DE SEGURIDAD</strong></p>
                                    <p>
                                        Que de conformidad con lo dispuesto en las normativas vigentes en protección de
                                        datos
                                        personales, el
                                        RESPONSABLE está cumpliendo con todas las disposiciones de las normativas GDPR y
                                        LOPDGDD
                                        para el
                                        tratamiento de los datos personales de su responsabilidad, y manifiestamente con los
                                        principios descritos en el
                                        artículo 5 del GDPR, por los cuales son tratados de manera lícita, leal y
                                        transparente
                                        en relación con el
                                        interesado y adecuados, pertinentes y limitados a lo necesario en relación con los
                                        fines
                                        para los que son
                                        tratados.</p>
                                    <p>
                                        El RESPONSABLE garantiza que ha implementado políticas técnicas y organizativas
                                        apropiadas para aplicar
                                        las medidas de seguridad que establecen el GDPR y la LOPDGDD con el fin de proteger
                                        los
                                        derechos y
                                        libertades de los USUARIOS y les ha comunicado la información adecuada para que
                                        puedan
                                        ejercerlos.</p>
                                    <p>
                                        Para más información sobre las garantías de privacidad, puedes dirigirte al
                                        RESPONSABLE
                                        a través de THE URBAN BURGER S.L.. C/ POSTIGOS, SN - 30840 ALHAMA DE MURCIA
                                        (Murcia). E-mail:
                                        info@smashurban.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content -->
@endsection
