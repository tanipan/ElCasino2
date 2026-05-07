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

                                    <h4><strong>POLÍTICA DE COOKIES</strong></h4>

                                    <p><strong>INFORMACIÓN SOBRE COOKIES</strong></p>

                                    <p>Conforme con la Ley 34/2002, de 11 de julio, de servicios de la sociedad de la
                                        información y de comercio
                                        electrónico (LSSI), en relación con el Reglamento (UE) 2016/679 del Parlamento
                                        Europeo y del Consejo, de 27
                                        de abril de 2016, General de Protección de Datos (GDPR) y la Ley Orgánica 3/2018, de
                                        5 de diciembre, de
                                        Protección de Datos y Garantía de los Derechos Digitales (LOPDGDD), es obligado
                                        obtener el consentimiento
                                        expreso del usuario de todas las páginas web que usan cookies prescindibles, antes
                                        de que este navegue por
                                        ellas.</p>

                                    <p><strong>¿QUÉ SON LAS COOKIES?</strong></p>
                                    <p>Las cookies y otras tecnologías similares tales como local shared objects, flash
                                        cookies o píxeles, son
                                        herramientas empleadas por los servidores Web para almacenar y recuperar información
                                        acerca de sus
                                        visitantes, así como para ofrecer un correcto funcionamiento del sitio.
                                    </p>
                                    <p>Mediante el uso de estos dispositivos se permite al servidor Web recordar algunos
                                        datos concernientes al
                                        usuario, como sus preferencias para la visualización de las páginas de ese servidor,
                                        nombre y contraseña,
                                        productos que más le interesan, etc.</p>

                                    <p><strong>COOKIES AFECTADAS POR LA NORMATIVA Y COOKIES EXCEPTUADAS</strong></p>
                                    <p>Según la directiva de la UE, las cookies que requieren el consentimiento informado
                                        por parte del usuario son
                                        las cookies de analítica y las de publicidad y afiliación, quedando exceptuadas las
                                        de carácter técnico y las
                                        necesarias para el funcionamiento del sitio web o la prestación de servicios
                                        expresamente solicitados por el
                                        usuario.</p>

                                    <p><strong>TIPOS DE COOKIES</strong></p>
                                    <p><strong>SEGÚN LA FINALIDAD</strong></p>
                                    <ul class="mi-lista">
                                        <li>
                                            <strong>Cookies técnicas y funcionales:</strong> son aquellas que permiten al
                                            usuario la
                                            navegación a través de una
                                            página web, plataforma o aplicación y la utilización de las diferentes opciones
                                            o servicios que en ella
                                            existan.
                                        </li>
                                        <li><strong>Cookies analíticas:</strong> son aquellas que permiten al responsable de
                                            las mismas el
                                            seguimiento y análisis
                                            del comportamiento de los usuarios de los sitios web a los que están vinculadas.
                                            La
                                            información
                                            recogida mediante este tipo de cookies se utiliza en la medición de la actividad
                                            de
                                            los sitios web,
                                            aplicación o plataforma y para la elaboración de perfiles de navegación de los
                                            usuarios de dichos sitios,
                                            aplicaciones y plataformas, con el fin de introducir mejoras en función del
                                            análisis
                                            de los datos de uso
                                            que hacen los usuarios del servicio.</li>
                                        <li><strong>Cookies publicitarias:</strong> son aquellas que permiten la gestión, de
                                            la forma más
                                            eficaz
                                            posible, de los
                                            espacios publicitarios que, en su caso, el editor haya incluido en una página
                                            web,
                                            aplicación o
                                            plataforma desde la que presta el servicio solicitado en base a criterios como
                                            el
                                            contenido editado o la
                                            frecuencia en la que se muestran los anuncios.</li>
                                        <li><strong>Cookies de publicidad comportamental:</strong> recogen información sobre
                                            las preferencias
                                            y
                                            elecciones
                                            personales del usuario (retargeting) para permitir la gestión, de la forma más
                                            eficaz posible, de los
                                            espacios publicitarios que, en su caso, el editor haya incluido en una página
                                            web,
                                            aplicación o
                                            plataforma desde la que presta el servicio solicitado.</li>
                                        <li><strong>Cookies sociales:</strong> son establecidas por las plataformas de redes
                                            sociales en los
                                            servicios para
                                            permitirle compartir contenido con sus amigos y redes. Las plataformas de medios
                                            sociales tienen la capacidad de rastrear su actividad en línea fuera de los
                                            Servicios. Esto puede afectar al contenido y los
                                            mensajes que ve en otros servicios que visita.</li>
                                        <li><strong>Cookies de afiliados:</strong> permiten hacer un seguimiento de las
                                            visitas procedentes
                                            de otras webs, con las
                                            que el sitio web establece un contrato de afiliación (empresas de afiliación).
                                        </li>
                                        <li><strong>Cookies de seguridad:</strong> almacenan información cifrada para evitar
                                            que los datos
                                            guardados en ellas
                                            sean vulnerables a ataques maliciosos de terceros.</li>
                                    </ul>
                                    <p><strong>SEGÚN LA PROPIEDAD</strong></p>
                                    <ul class="mi-lista">
                                        <li><strong>Cookies propias:</strong> son aquellas que se envían al equipo terminal
                                            del usuario desde
                                            un equipo o dominio
                                            gestionado por el propio editor y desde el que se presta el servicio solicitado
                                            por el usuario.</li>
                                        <li><strong> Cookies de terceros:</strong> son aquellas que se envían al equipo
                                            terminal del usuario
                                            desde un equipo o
                                            dominio que no es gestionado por el editor, sino por otra entidad que trata los
                                            datos obtenidos través de
                                            las cookies.</li>
                                    </ul>
                                    <p><strong>SEGÚN EL PLAZO DE CONSERVACIÓN</strong></p>
                                    <ul class="mi-lista">
                                        <li><strong>Cookies de sesión:</strong> son un tipo de cookies diseñadas para
                                            recabar y almacenar datos mientras el
                                            usuario accede a una página web.</li>
                                        <li><strong>Cookies persistentes:</strong> son un tipo de cookies en el que los
                                            datos siguen almacenados en el terminal y
                                            pueden ser accedidos y tratados durante un período definido por el responsable
                                            de la cookie, y que
                                            puede ir de unos minutos a varios años.</li>
                                    </ul>
                                    <p><strong>TRATAMIENTO DE DATOS PERSONALES</strong></p>

                                    <p>THE URBAN BURGER S.L. es el Responsable del tratamiento de los datos personales del
                                        Interesado y le
                                        informa de que estos datos serán tratados de conformidad con lo dispuesto en el
                                        Reglamento (UE) 2016/679,
                                        de 27 de abril de 2016 (GDPR), por lo que se le facilita la siguiente información
                                        del
                                        tratamiento:</p>
                                    <p>Fines del tratamiento: según se especifica en el apartado de cookies que se utilizan
                                        en
                                        este sitio web.</p>
                                    <p>Legitimación del tratamiento: salvo en los casos en los que resulte necesario para la
                                        navegación por la web,
                                        por consentimiento del interesado (art. 6.1 GDPR).</p>
                                    <p>Criterios de conservación de los datos: según se especifica en el apartado de cookies
                                        utilizadas en la web.</p>
                                    <p>Comunicación de los datos: no se comunicarán los datos a terceros, excepto en cookies
                                        propiedad de
                                        terceros o por obligación legal.</p>
                                    <p><strong> Derechos que asisten al Interesado:</strong></p>
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
                                            Derecho a presentar una reclamación ante la Autoridad de control (www.aepd.es)
                                            si
                                            considera que el
                                            tratamiento no se ajusta a la normativa vigente.
                                        </li>
                                    </ul>

                                    <p><strong>Datos de contacto para ejercer sus derechos:</strong></p>

                                    <p>THE URBAN BURGER S.L.. Calle Vidal Abarca 3, bajo - 30840 ALHAMA DE MURCIA (Murcia).
                                        E-mail: info@smashurban.com</p>

                                    <p><strong>COOKIES UTILIZADAS EN ESTE SITIO WEB</strong></p>
                                    <p><strong>COOKIES CONTROLADAS POR EL EDITOR</strong></p>
                                    <p><strong>Técnicas y funcionales</strong></p>
                                    <table border="1">
                                        <tr>
                                            <td><strong>Propiedad</strong></td>
                                            <td><strong>Cookie</strong></td>
                                            <td><strong>Finalidad</strong></td>
                                            <td><strong>Plazo</strong></td>
                                        </tr>
                                        <tr>
                                            <td>smashurban.com</td>
                                            <td>_ga_5YXT6D374W</td>
                                            <td>Cookie necesaria para la utilización de las opciones y servicios del sitio
                                                web</td>
                                            <td>en un año</td>
                                        </tr>
                                        <tr>
                                            <td>smashurban.com</td>
                                            <td>ci_session</td>
                                            <td>Cookie necesaria para la utilización de las opciones y servicios del sitio
                                                web</td>
                                            <td>Sesión</td>
                                        </tr>
                                        <tr>
                                            <td>smashurban.com</td>
                                            <td>cookieconsent_status</td>
                                            <td>Esta cookie se utiliza para recordar si ha dado su consentimiento para el
                                                uso de cookies en este sitio web.</td>
                                            <td>en un año</td>
                                        </tr>
                                    </table>

                                    <p><strong>Analíticas</strong></p>
                                    <table border="1">
                                        <tr>
                                            <td><strong>Propiedad</strong></td>
                                            <td><strong>Cookie</strong></td>
                                            <td><strong>Finalidad</strong></td>
                                            <td><strong>Plazo</strong></td>
                                        </tr>
                                        <tr>
                                            <td>smashurban.com</td>
                                            <td>_ga</td>
                                            <td>ID utiliza para identificar a los usuarios</td>
                                            <td>en un año</td>
                                        </tr>
                                        <tr>
                                            <td>smashurban.com</td>
                                            <td>_gat</td>
                                            <td>Se utiliza para monitorizar el número de peticiones al servidor
                                                de Google Analytics cuando se utiliza el Administrador de
                                                etiquetas Google</td>
                                            <td>Sesión</td>
                                        </tr>
                                        <tr>
                                            <td>smashurban.com</td>
                                            <td>_gid</td>
                                            <td>ID utiliza para identificar a los usuarios durante 24 horas después de la
                                                última actividad</td>
                                            <td>en 22 horas</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <p><strong>COOKIES DE TERCEROS</strong></p>
                                    <p> Los servicios de terceros son ajenos al control del editor. Los proveedores pueden
                                        modificar en todo momento
                                        sus condiciones de servicio, finalidad y utilización de las cookies, etc.</p>
                                    <p><strong> Proveedores externos de este sitio web:</strong></p>
                                    <table border="1">
                                        <tr>
                                            <td><strong>Editor</strong></td>
                                            <td><strong>Política de privacidad</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Google Analytics</td>
                                            <td>https://privacy.google.com/take-control.html</td>
                                        </tr>
                                        <tr>
                                            <td>Osano</td>
                                            <td>N/A</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <p><strong>PANEL DE CONFIGURACIÓN DE COOKIES</strong></p>
                                    <p>Desde este panel podrá configurar las cookies que el sitio web puede instalar en su
                                        navegador, excepto las
                                        cookies técnicas o funcionales que son necesarias para la navegación y la
                                        utilización de las diferentes
                                        opciones o servicios que se ofrecen.</p>

                                    <p><strong>CÓMO GESTIONAR LAS COOKIES DESDE EL NAVEGADOR</strong></p>
                                    <table border="1">
                                        <tr>
                                            <td>Eliminar las cookies del
                                                dispositivo</td>
                                            <td>Las cookies que ya están en un dispositivo se pueden eliminar borrando el
                                                historial del
                                                navegador, con lo que se suprimen las cookies de todos los sitios web
                                                visitados.
                                                Sin embargo, también se puede perder parte de la información guardada (por
                                                ejemplo,
                                                los datos de inicio de sesión o las preferencias de sitio web).</td>
                                        </tr>
                                        <tr>
                                            <td>Gestionar las cookies específicas
                                                del sitio</td>
                                            <td>Para tener un control más preciso de las cookies específicas de cada sitio,
                                                los usuarios
                                                pueden ajustar su configuración de privacidad y cookies en el navegador.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bloquear las cookies</td>
                                            <td>Aunque la mayoría de los navegadores modernos se pueden configurar para
                                                evitar que
                                                se instalen cookies en los dispositivos, eso puede obligar al ajuste manual
                                                de
                                                determinadas preferencias cada vez que se visite un sitio o página. Además,
                                                algunos
                                                servicios y características pueden no funcionar correctamente (por ejemplo,
                                                los inicios de
                                                sesión con perfil).</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <p><strong>CÓMO ELIMINAR LAS COOKIES DE LOS NAVEGADORES MÁS COMUNES</strong></p>
                                    <table border="1">
                                        <tr>
                                            <td>Chrome</td>
                                            <td>http://support.google.com/chrome/answer/95647?hl=es</td>
                                        </tr>
                                        <tr>
                                            <td>Edge</td>
                                            <td>https://support.microsoft.com/es-es/microsoft-edge/eliminar-las-cookies-en-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Explorer</td>
                                            <td>https://support.microsoft.com/es-es/help/278835/how-to-delete-cookie-files-in-internet-explorer
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Firefox</td>
                                            <td>https://www.mozilla.org/es-ES/privacy/websites/#cookies</td>
                                        </tr>
                                        <tr>
                                            <td>Safaro</td>
                                            <td>https://support.apple.com/es-es/guide/safari/sfri11471/mac</td>
                                        </tr>
                                        <tr>
                                            <td>Opera</td>
                                            <td>https://help.opera.com/en/latest/security-and-privacy/#clearBrowsingData
                                            </td>
                                        </tr>
                                    </table>
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
