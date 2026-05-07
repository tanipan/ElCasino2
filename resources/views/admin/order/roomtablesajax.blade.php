@foreach ($tables as $table)
    <div class="col-lg-3 col-6">

        <div class="small-box {{ $table->getStatusColor() }}">
            <div class="inner">
                <h3 data-table="{{ $table->id }}" data-toggle="modal" data-target="#exampleModalLongTable"
                    class="modal-comandaTable">
                    {{ $table->name }}
                </h3>
                @if ($table->idTableFullyServed())
                    <button type="button" class="col-3 btn btn-block btn-primary btn-xs">Servida 👍🏻</button>
                @endif

                {!! $table->showNotificationTable() !!}
                <div class="info-box-content">
                    <span class="info-box-text">Importe actual
                        <strong style="font-size: 20px">{{ $table->getTotal() }}€</strong></span><br>
                    @foreach ($table->getOrders() as $order)
                        <span data-order="{{ $order->id }}" data-toggle="modal" data-target="#exampleModalLong"
                            class="badge modal-comanda2 badge-{{ $order->getStatusColorTable() }}"
                            style="font-size: 19px;cursor: pointer;">
                            {{ $order->order }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a style="padding: 10px 0" href="{{ route('tableLogin', $table->token) }}" class="small-box-footer">
                Acceder <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
@endforeach
