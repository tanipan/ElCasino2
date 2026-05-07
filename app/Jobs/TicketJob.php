<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Config;
use App\Models\Ticket;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\OrderController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order_id;
    protected $copia;
    protected $usuario;

    public function __construct($order_id = "", $copia = "Copia para el restaurante", $usuario = 0)
    {
        $this->order_id = $order_id;
        $this->copia = $copia;
        $this->usuario = $usuario;
    }

    public function handle()
    {
        $order = Order::find($this->order_id);
        $restaurante = Restaurant::find($order->restaurant_id);
        $cesta = OrderController::recuperarPedidoDeBDJob($order);
        $total = 0;

        $lineas = [];
        foreach ($cesta as $linea) {
            $n = "";
            $e = null;
            //Sacamos el nombre de los elementos
            if ($linea['elementos']) {
                foreach ($linea['elementos'] as $ele) {
                    $n .= $ele->name . ",";
                }
                $e = explode(",", rtrim($n, ","));
            }

            $lineas[] = [
                "plato" => $linea['plato']->name,
                "unidades" => $linea['unidades'],
                "precio" =>  number_format($linea['precio'] / $linea['unidades'], 2, ',', ''),
                "total" => number_format($linea['unidades'] * ($linea['precio'] / $linea['unidades']), 2, ',', ''),
                "opciones" => $e,
                "observaciones" => $linea['observaciones'],
            ];

            $total += ($linea['unidades'] * ($linea['precio'] / $linea['unidades']));
        }

        //Si tiene bolsas
        if ($order->bags) {
            $precioBolsa = Config::find(4);

            $precioBolsa->value = str_replace(",", ".", $precioBolsa->value);

            $lineas[] = [
                "plato" => "Bolsas",
                "unidades" => $order->bags,
                "precio" =>  number_format($precioBolsa->value, 2, ',', ''),
                "total" => number_format($precioBolsa->value * $order->bags, 2, ',', ''),
                "opciones" => null,
                "observaciones" => "",
            ];

            $total += ($precioBolsa->value * $order->bags);
        }

        $restaurante_extra = Config::find(7);

        $pedido = [
            "total" => $total,
            "pedido" => $order->order,
            "restaurante" => $restaurante->name,
            "restaurante_extra" => $restaurante_extra->value,
            "lineas" => $lineas,
            "copia" => $this->copia,
            "observaciones" => $order->observacions,
            "coletilla" => "Hora de recogida: " . $order->time_ready,
            //"coletilla" => "Buen provecho :)",
        ];

        //Si es el cliente Comoaqui, imprimimos tres copias
        if ($order->customer_id == 132) {
            if (strpos($this->copia, "restaurante") !== false) {
                $copias = 1;
            } else {
                $copias = 3;
            }
        } else {
            $copias = 1;
        }

        for ($i = 0; $i < $copias; $i++) {
            Ticket::create([
                'json' => json_encode($pedido),
                'copias' => $copias,
                'tipo' => ((strpos($this->copia, "restaurante") !== false) ? "cocina" : "cliente"),
                'usuario' => $this->usuario,
                'token_restaurante' => $restaurante['token'],
            ]);
        }
    }
}
