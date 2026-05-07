<div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center" role="document">
        <div class="modal-content" style="width: 390px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-lg fa-times"
                        aria-hidden="true"></i></button>
                <img src="{{ asset('images/' . ($foodglish['plato']->img1 ?: ($tema == 1 ? 'producto_k.jpg' : 'producto.jpg'))) }}"
                    class="img-responsive center-block" id="ft2"
                    style="width: 100%;height: 100%;object-fit: cover;">
            </div>
            <div class="modal-body">
                <div class="modal_title">
                    <h4>{{ $foodglish['plato']->name }}</h4>
                    <h4 id="dish-price-global">{{ $foodglish['plato']->price }}&nbsp;&euro;</h4>
                </div>
                <p>{{ $foodglish['plato']->description }}</p>
                <input type="hidden" id="dish-id" value="{{ $foodglish['plato']->id }}">

                @isset($foodglish['alternativas'])
                    @foreach ($foodglish['alternativas'] as $alternativa)
                        <!-- Alternativa -->
                        <div class="control-group" id="keuze_0">
                            <h6>
                                <a data-toggle="collapse" href="#checkItem_{{ $alternativa['modificacion']->id }}">
                                    <span>{{ $alternativa['nombre'] }}</span>
                                    <span id="symbol">
                                        <i class="fa fa-angle-down fa-2x" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </h6>
                            <div id="checkItem_{{ $alternativa['modificacion']->id }}" class="panel-collapse collapse">

                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($alternativa['elementos'] as $elemento)
                                    <label class="control control--radio">
                                        <p>{{ $elemento->name }}
                                            {{ $elemento->price ? ($elemento->price > 0 ? '(+' : '(') . $elemento->price . '€)' : '' }}
                                        </p>
                                        <input type="radio" class="elemento" value="{{ $elemento->id }}"
                                            name="flexRadioDefaul-{{ $alternativa['modificacion']->id }}" />
                                        <div class="control__indicator"></div>
                                    </label>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </div>
                            <input type="hidden" data-type="2" class="keuze_0" data-max="1" data-min="0"
                                data-value="0.00" />
                        </div>
                        <!-- /Alternativa -->
                    @endforeach
                @endisset

                @isset($foodglish['extras'])
                    @foreach ($foodglish['extras'] as $extra)
                        <!-- Extra -->
                        <div class="control-group" id="keuze_0">
                            <h6>
                                <a data-toggle="collapse" href="#checkItem_{{ $extra['modificacion']->id }}">
                                    <span>{{ $extra['nombre'] }}</span>
                                    <span id="symbol">
                                        <i class="fa fa-angle-down fa-2x" aria-hidden="true"></i>
                                    </span></a>
                            </h6>
                            <div id="checkItem_{{ $extra['modificacion']->id }}"
                                class="panel-collapse {{ $extra['nombre'] == 'Selecciona tu salsa' ? '' : 'collapse' }}">

                                @foreach ($extra['elementos'] as $elemento)
                                    <label class="control control--checkbox">
                                        <p>{{ $elemento->name }}{{ $elemento->price ? ($elemento->price > 0 ? '(+' : '(') . $elemento->price . '€)' : '' }}
                                        </p>
                                        <input type="checkbox" class="elemento" value="{{ $elemento->id }}" />
                                        <div class="control__indicator"></div>
                                    </label>
                                @endforeach

                            </div>
                            <input type="hidden" data-type="2" class="keuze_0" data-max="1" data-min="0"
                                data-value="0.00" />
                        </div>
                        <!-- /Extra -->
                    @endforeach
                @endisset

            </div>

            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="footer-total">
                    <div>
                        <input type='hidden' value='1' />
                    </div>
                    <div class="row">
                        <table>
                            <tr>
                                <td>
                                    <button id="btn_menos" type="button"
                                        class="btn btn-secondary btn-block"><b>-</b></button>
                                </td>
                                <td>
                                    <button id="uds" type="button" class="btn btn-secondary btn-block">1</button>
                                </td>
                                <td>
                                    <button id="btn_mas" type="button"
                                        class="btn btn-secondary btn-block"><b>+</b></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <button class="btn" id="addCesta">Añadir</button>
                        <input id="units" type="hidden"
                            data-minimum-units="{{ $foodglish['plato']->minimum_units }}"
                            value="{{ $foodglish['plato']->minimum_units == 0 ? 1 : $foodglish['plato']->minimum_units }}">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function recuperarAlternativas() {
        var ids = "";

        $("input[type=radio]:checked").each(function() {
            if (this.checked == true) {
                ids += this.value + ",";
            }
        });

        return ids;
    }

    function recuperarExtras() {
        var ids = "";
        $("input[type=checkbox]:checked").each(function() {
            if (this.checked == true) {
                ids += this.value + ",";
            }
        });

        return ids;
    }

    function recuperarIdPlato() {
        return $("#dish-id").val();
    }
    // KO
    function recuperarObservaciones() {
        return $("#observaciones").val();
    }

    function recuperarUnidades() {
        //return parseInt($("#units").val());
        return parseInt($("#uds").html());
    }

    $(".elemento").click(function() {
        calcularImportePlato();
    });

    function calcularImportePlato() {
        $.get("{{ route('front.recuperarPrecioModalPlato') }}", {
                plato: recuperarIdPlato(),
                elementos: recuperarAlternativas() + "," + recuperarExtras()
            },
            function(data, status) {
                $('#dish-price-global').html(data + " €");
            });
    }

    $("#addCesta").click(function() {
        $.get("{{ route('front.insertarEnCesta') }}", {
                plato: recuperarIdPlato(),
                elementos: recuperarAlternativas() + "," + recuperarExtras(),
                unidades: recuperarUnidades(),
                observaciones: recuperarObservaciones(),
            },
            function(data, status) {
                cargarCesta();
            });
        $("#choose_modal").modal('hide');
    });

    $('#btn_menos').click(function() {
        var uds = parseInt($('#uds').html());

        if (uds > 1) {
            $('#uds').html(uds - 1);
        }
    });
    $('#btn_mas').click(function() {
        var uds = parseInt($('#uds').html());

        if (uds < 20) {
            $('#uds').html(uds + 1);
        }
    });
</script>
