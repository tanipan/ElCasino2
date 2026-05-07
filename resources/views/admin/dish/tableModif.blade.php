@foreach ($modifications as $modification)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px"></th>
                <th>
                    {{ $modification['modification']->name }}
                </th>
                <th>Suplemento</th>
                <th>Oculto</th>
                <th style="width: 250px">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modification['elements'] as $element)
                <tr>
                    <td>{{ $element->id }}</td>
                    <td>{{ $element->name }}</td>
                    <td>{{ $element->price }}€</td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch{{ $element->id }}"
                                data-element-id="{{ $element->id }}" {{ $element->hidden ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch{{ $element->id }}">Oculto</label>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-6">

                                <button type="button" class="btn-modif btn btn-block btn-info"
                                    data-element-id="{{ $element->id }}">Modificar</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn-delete btn btn-block btn-danger"
                                    data-element-id="{{ $element->id }}">Eliminar</button>

                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

<script>
    $(document).ready(function() {
        $('.custom-control-input').on('change', function() {
            // Obtener el ID del elemento desde el atributo data-element-id
            const elementId = $(this).data('element-id');
            const isChecked = $(this).is(':checked'); // Verificar si el checkbox está marcado

            // Realizar la llamada AJAX
            $.ajax({
                url: "{{ route('ocultarElemento') }}",
                method: 'GET', // Método HTTP
                data: {
                    elemento: elementId
                }, // Enviar el ID del elemento como parámetro
                success: function(response) {
                    // Manejar respuesta de la API
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error('Error en la solicitud:', error);
                }
            });
        });
    });
</script>
