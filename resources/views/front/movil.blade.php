@extends('layouts.webInside')

@section('content')

    <div class="my-5 paddingBody">
        <section>
            <div class="brand">
                <a href="recoger.html" class="d-flex text-success">
                    <i class=" icon-left-open"></i>
                    <h6>
                        Volver al restaurante
                    </h6>
                </a>
            </div>
            <br>
            <div class="col-md-12">
                <div class="orden">
                    <div class="">
                        <div class="card-title text-center">
                            <p style="font-size: 25px; padding: 5px;">Tu orden</p>
                            <div style="text-align: left; font-size: 13px;" class="alert alert-secondary" role="alert">
                                <a href="">
                                    <i class="icon-attention-alt"></i>
                                    Si tu o alguien para el que estas pidiendo tiene una alergia o intolerancia a algún
                                    alimento haz click aqui
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <a class=" text-danger" href="">
                                    Confirma tu dirección de envío
                                </a>
                            </div>
                            <div>
                                <div class="btn-group" role="group" aria-label="Basic example">

                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="informacion-plato">
                                        <p style="font-size: 15px;">Arroz con costejillas</p>
                                        <p style="font-size: 10px;">Sin cebolla</p>
                                    </div>
                                    <div class="cantidad-plato">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn" id="menos">
                                                <i style="color: red;" class="icon-minus-1"></i>
                                            </button>
                                            <input id="cantidad" type="text"
                                                style="text-align: center; width: 30px; border: none;" value="1">
                                            <button type="button" class="btn" id="mas">
                                                <i style="color: green;" class="icon-plus"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="precio-plato">
                                        <div class="text-danger" style="font-size: 15px;">
                                            3.90 €
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="informacion-plato">
                                        <p style="font-size: 15px;">Guiso de habichuelas</p>
                                        <p style="font-size: 10px;">Sin cebolla</p>
                                    </div>
                                    <div class="cantidad-plato">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn" id="menos"
                                                onclick="javascript: contadormenos()">
                                                <i style="color: red;" class="icon-minus-1"></i>
                                            </button>
                                            <input id="cantidad" type="text"
                                                style="text-align: center; width: 30px; border: none;" value="1">
                                            <button type="button" class="btn" id="mas"
                                                onclick="javascript: contadormas()">
                                                <i style="color: green;" class="icon-plus"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="precio-plato">
                                        <div class="text-danger" style="font-size: 15px;">
                                            3.90 €
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="informacion-plato">
                                        <p style="font-size: 15px;">Calabacín al horno</p>
                                        <p style="font-size: 10px;">Sin cebolla</p>
                                    </div>
                                    <div class="cantidad-plato">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn">
                                                <i style="color: red;" class="icon-minus-1"></i>
                                            </button>
                                            <input id="cantidad" type="text"
                                                style="text-align: center; width: 30px; border: none;" value="1">
                                            <button type="button" class="btn">
                                                <i style="color: green;" class="icon-plus"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="precio-plato">
                                        <div class="text-danger" style="font-size: 15px;">
                                            3.90 €
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="informacion-plato">
                                        <p style="font-size: 15px;">Fideua</p>
                                        <p style="font-size: 10px;">Sin cebolla</p>
                                    </div>
                                    <div class="cantidad-plato">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn">
                                                <i style="color: red;" class="icon-minus-1"></i>
                                            </button>
                                            <input id="cantidad" type="text"
                                                style="text-align: center; width: 30px; border: none;" value="1">
                                            <button type="button" class="btn">
                                                <i style="color: green;" class="icon-plus"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="precio-plato">
                                        <div class="text-danger" style="font-size: 15px;">
                                            3.90 €
                                        </div>
                                    </div>
                                </div>
                                <div class="observaciones">
                                    <input style="font-size: 12px;" placeholder="Agregar observaciones" type="text"
                                        class="form-control">
                                </div>
                                <div class="precio-totalidad my-2">
                                    <div class="subtotal-caja">
                                        <div class="subtotal">
                                            <p>
                                                Subtotal
                                            </p>
                                        </div>
                                        <div class="subtotal-valor">
                                            <p>
                                                20.00 €
                                            </p>
                                        </div>
                                    </div>
                                    <div class="envio-caja">
                                        <div class="subtotal">
                                            <p>
                                                Envio
                                            </p>
                                        </div>
                                        <div class="subtotal-valor">
                                            <p>
                                                5.00 €
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="totalidad-caja">
                                    <div class="totalidad">
                                        <p>
                                            Total
                                        </p>
                                    </div>
                                    <div class="totalidad-valor">
                                        <p>
                                            20.00 €
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div style="font-size: 12px;" class="alert alert-danger mt-3" role="alert">
                                Importe mínimo 10 €, te falta añadir 5€
                            </div>
                            <div style="font-size: 12px;" class="alert alert-info" role="alert">
                                Importe mínimo para pagar con tarjeta al repartidor 20 €, te falta añadir 2€
                            </div>
                            <div style="text-align: center;">
                                <button class="btn btn-danger">
                                    <a style="color: white;" href="pedido-proceso.html">
                                        Completar pedido
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div>

    </section>

    </div>

@endsection
