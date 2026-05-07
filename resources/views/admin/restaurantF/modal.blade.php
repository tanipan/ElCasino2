<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="burger-name"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="text-align: center">

        <table border="0" style="width: 100%;text-align: center;margin: 50px 0">
            @if ($restaurant->dish1)
                @php
                    $i = 1;
                @endphp
                <tr style="height: 150px;">
                    <td style="width: 50%">
                        <h1>{{ explode('#', $restaurant->dish1)[0] }}</h1>
                    </td>
                    <td style="width: 20%">
                        <button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-danger btn-lg" id="menos{{ $i }}"
                            onclick="disminuirUnidades('contador{{ $i }}')">-</button>
                    </td>
                    <td style="width: 10%">
                        <button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-light btn-lg" id="contador{{ $i }}">
                            {{ in_array($restaurant->id, [14, 16]) ? 1 : 1 }}
                        </button>
                    </td>
                    <td style="width: 20%">
                        <button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-success btn-lg" id="mas{{ $i }}"
                            onclick="aumentarUnidades('contador{{ $i }}')">+</button>
                    </td>
                </tr>
            @endif

            @if ($restaurant->dish2)
                @php
                    $i = 2;
                @endphp
                <tr style="height: 150px;">
                    <td>
                        <h1>{{ explode('#', $restaurant->dish2)[0] }}</h1>
                    </td>
                    <td><button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-danger btn-lg" id="menos{{ $i }}"
                            onclick="disminuirUnidades('contador{{ $i }}')">-</button></td>
                    <td><button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-light btn-lg" id="contador{{ $i }}">
                            {{ in_array($restaurant->id, [14, 16]) ? 0 : 1 }}
                        </button>
                    </td>
                    <td><button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-success btn-lg" id="mas{{ $i }}"
                            onclick="aumentarUnidades('contador{{ $i }}')">+</button></td>
                </tr>
            @endif

            @if ($restaurant->dish3)
                @php
                    $i = 3;
                @endphp
                <tr style="height: 150px;">
                    <td>
                        <h1>{{ explode('#', $restaurant->dish3)[0] }}</h1>
                    </td>
                    <td><button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-danger btn-lg" id="menos{{ $i }}"
                            onclick="disminuirUnidades('contador{{ $i }}')">-</button></td>
                    <td><button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-light btn-lg" id="contador{{ $i }}">
                            {{ in_array($restaurant->id, [14, 16]) ? 0 : 1 }}
                        </button></td>
                    <td><button style="height: 100px;font-size: 60px;" type="button"
                            class="btn btn-block btn-success btn-lg" id="mas{{ $i }}"
                            onclick="aumentarUnidades('contador{{ $i }}')">+</button></td>
                </tr>
            @endif
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"
            style="margin-right: 160px">Cerrar</button>
        <button type="button" class="btn btn-success btn-lg" id="vender">Vender</button>
        <input type="hidden" id="restaurant_id" value="{{ $restaurant->id }}">
    </div>
</div>

<script>
    function aumentarUnidades(contadorId) {
        var contadorElement = document.getElementById(contadorId);
        var contadorValue = parseInt(contadorElement.textContent);
        contadorElement.textContent = contadorValue + 1;
    }

    // Función para manejar el evento de clic en el botón "menos" (disminuir unidades)
    function disminuirUnidades(contadorId) {
        var contadorElement = document.getElementById(contadorId);
        var contadorValue = parseInt(contadorElement.textContent);
        if (contadorValue > 0) {
            contadorElement.textContent = contadorValue - 1;
        }
    }

    // Función para comprobar la existencia y valor de los contadores
    function comprobarContadores() {
        var contadores = ["contador1", "contador2", "contador3"];
        var valores = [];

        contadores.forEach(function(contadorId) {
            var contadorElement = document.getElementById(contadorId);
            if (contadorElement && parseInt(contadorElement.textContent) >= 0) {
                valores.push(contadorElement.textContent);
            }
        });

        if (valores.length > 0) {
            ajax(valores.join("#"), $('#restaurant_id').val());
            $('#exampleModal').modal('hide');
        } else {
            alert("No has indicado unidades");
        }
    }

    document.getElementById("vender").addEventListener("click", function() {
        comprobarContadores();
    });

    function ajax(unids, id) {
        //Hacer la llamada Ajax
        $.ajax({
            url: "{{ route('sellingBurgers') }}",
            method: 'POST',
            data: {
                id: id,
                unids: unids,
                user: {{ $user }}
            }
        }).done(function(data) {
            console.log(data);
        })
    }
</script>
