<div class="modal-header d-block">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-start">
            <div class="fs-5">
                {{ $foodglish['plato']->name }}
            </div>
            <div>
                {{ $foodglish['plato']->description }}
            </div>
            <input type="hidden" id="dish-id" value="{{ $foodglish['plato']->id }}">
        </div>
        <h6 class="text-success float-end" id="dish-price-global">{{ $foodglish['plato']->price }} €</h6>
    </div>

</div>
<div class="modal-body">
    <div class="accordion" style="width: 100%;" id="acordeonmodal">

        @isset($foodglish['alternativas'])
            @foreach ($foodglish['alternativas'] as $alternativa)
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="acordeon-modal-{{ $alternativa['modificacion']->id }}">
                        <button class="accordion-button justify-content-between btn-success" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $alternativa['modificacion']->id }}"
                            aria-expanded="true" aria-controls="collapseOne{{ $alternativa['modificacion']->id }}">
                            <h6 class="mx-4">{{ $alternativa['nombre'] }}</h6>
                            <i class="icon-down-open"></i>
                        </button>
                    </h2>
                    <div id="collapseOne{{ $alternativa['modificacion']->id }}" class="accordion-collapse collapse"
                        aria-labelledby="acordeon-modal-{{ $alternativa['modificacion']->id }}"
                        data-bs-parent="#acordeonmodal">
                        <div class="accordion-body text-start">
                            <ul>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($alternativa['elementos'] as $elemento)
                                    <li>
                                        <input class="form-check-input elemento" type="radio"
                                            {{ $i == 0 ? 'checked' : '' }}
                                            name="flexRadioDefault-{{ $alternativa['modificacion']->id }}"
                                            id="element-{{ $elemento->id }}" value="{{ $elemento->id }}">
                                        <label class="form-check-label" for="element-{{ $elemento->id }}">
                                            {{ $elemento->name }}
                                            {{ $elemento->price ? '(+' . $elemento->price . '€)' : '' }}
                                        </label>
                                    </li>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset

        @isset($foodglish['extras'])
            @foreach ($foodglish['extras'] as $alternativa)
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="acordeon-modal-{{ $alternativa['modificacion']->id }}">
                        <button class="accordion-button justify-content-between btn-success" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $alternativa['modificacion']->id }}"
                            aria-expanded="true" aria-controls="collapseOne{{ $alternativa['modificacion']->id }}">
                            <h6 class="mx-4">{{ $alternativa['nombre'] }}</h6>
                            <i class="icon-down-open"></i>
                        </button>
                    </h2>
                    <div id="collapseOne{{ $alternativa['modificacion']->id }}" class="accordion-collapse collapse"
                        aria-labelledby="acordeon-modal-{{ $alternativa['modificacion']->id }}"
                        data-bs-parent="#acordeonmodal">
                        <div class="accordion-body text-start">
                            <ul>
                                @foreach ($alternativa['elementos'] as $elemento)
                                    <li>
                                        <input type="checkbox" class="form-check-input elemento"
                                            id="element-{{ $elemento->id }}" value="{{ $elemento->id }}">
                                        <label class="form-check-label"
                                            for="element-{{ $elemento->id }}">{{ $elemento->name }}
                                            {{ $elemento->price ? '(+' . $elemento->price . '€)' : '' }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset

    </div>

    <input class="form-control" placeholder="Observaciones" type="text" id="observaciones">
</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

    <div class="card">
        <div class="d-flex align-items-center px-1">
            <button class="btn text-danger p-0" id="subtract">
                <i class="bi bi-dash fs-3"></i>
            </button>
            <div class="p-1 fs-5 mx-1" id="units" data-minimum-units="{{ $foodglish['plato']->minimum_units }}">
                {{ $foodglish['plato']->minimum_units == 0 ? 1 : $foodglish['plato']->minimum_units }}
            </div>
            <button class="btn text-success p-0" id="add">
                <i class="bi bi-plus fs-3"></i>
            </button>
        </div>
    </div>

    <button type="button" class="btn btn-success" id="addCesta">Agregar</button>
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

    function recuperarObservaciones() {
        return $("#observaciones").val();
    }

    function recuperarUnidades() {
        return parseInt($("#units").html());
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

    $("#subtract").click(function() {
        var units = parseInt($('#units').html());
        if (units > {{ $foodglish['plato']->minimum_units == 0 ? 1 : $foodglish['plato']->minimum_units }}) {
            $('#units').html(parseInt(units - 1))
        }
    });

    $("#add").click(function() {
        var units = parseInt($('#units').html());
        $('#units').html(parseInt(units + 1))
    });

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
        $('#exampleModal').modal('hide');
    });
</script>
