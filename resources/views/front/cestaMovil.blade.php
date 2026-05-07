@extends('layouts.webInside')

@section('content')
    <section>
        <br>
        <div class="brand">
            <a href="{{ route('front.recoger') }}" class="d-flex text-success">
                <i class=" icon-left-open"></i>
                <h6>
                    Volver al restaurante
                </h6>
            </a>
        </div>
        <br>
        <div class="col-md-12">
            <div id="cesta">

            </div>
        </div>


        </div>

    </section>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    //Desde aqui lanzamos los eventos tras la carga de la página
    $(document).ready(function() {
        //Cargar aqui la cesta
        cargarCesta()
    });

    function cargarCesta() {
        $.get("{{ route('front.cargarCesta') }}", {},
            function(data, status) {
                $('#cesta').html(data);                
            });
    }
</script>
