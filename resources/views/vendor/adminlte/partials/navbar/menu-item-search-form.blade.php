    <table>
        <tr>
            <td>
                <div class="input-group">
                    <form action="{{ route('admin.customer.list') }}" method="GET" class="form-inline mx-2">
                        <input class="form-control form-control-navbar" type="search" name="search"
                            placeholder="Buscar cliente" aria-label="{{ $item['aria-label'] ?? $item['text'] }}">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
            </td>
            <td>
                <div class="col-sm-12">
                    <form action="{{ route('front.autoLogin') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="NZQ0EHOcedq2MuPkNVBLwUuUa5mXEuka">

                        <div class="float-right" id="horaActual"
                            style="font-size: 25px;font-weight: bold;margin-left: 180px;">hora</div>


                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-warning btn-lg float-right" data-toggle="modal"
                            data-target="#telefonoModal">
                            Pedido por teléfono ☎️
                        </button>



                        <button type="submit" class="btn btn-primary float-right"
                            style="margin-right: 10px;margin-top: 5px">Nuevo
                            pedido</button>

                    </form>
                </div>

                </div>
            </td>
        </tr>
    </table>

    <script>
        function actualizarHora() {
            // Obtener la fecha y hora actual
            var fechaHoraActual = new Date();

            // Formatear la hora como HH:mm:ss
            var horaFormateada = ("0" + fechaHoraActual.getHours()).slice(-2) + ":" +
                ("0" + fechaHoraActual.getMinutes()).slice(-2) + ":" +
                ("0" + fechaHoraActual.getSeconds()).slice(-2);

            // Actualizar el contenido del div
            document.getElementById("horaActual").innerHTML = horaFormateada;
        }

        // Actualizar la hora cada segundo
        setInterval(actualizarHora, 1000);

        // Llamar a la función al cargar la página para mostrar la hora inicial
        actualizarHora();
    </script>
