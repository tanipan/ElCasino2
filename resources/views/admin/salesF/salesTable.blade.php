@foreach ($ventas as $venta)
    <tr>
        <td>{{ $venta->restaurant_id }}</td>
        <td>{{ $venta->burger }}</td>
        <td>{{ $venta->units }}</td>
        <td>{{ explode(' ', $venta->created_at)[1] }}</td>
        <td>
            <button type="button" class="btn btn-block btn-danger"
                onclick="eliminar({{ $venta->id }})">Eliminar</button>
        </td>
    </tr>
@endforeach


@section('js')
    <script></script>
@stop
