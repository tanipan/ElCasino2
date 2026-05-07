<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Restaurant;
use App\Models\RestaurantF;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use App\Models\SaleF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SalesFController extends Controller
{
    public function sales(Request $request)
    {
        $restaurants = RestaurantF::all();

        return view("admin.salesF.sales", compact('restaurants'));
    }

    public function informe(Request $request)
    {
        $date = $request->date;
        $date2 = $request->date2;

        $ventas = SaleF::whereRaw("date(created_at) between '$date' and '$date2'");

        $ventas = $ventas->get();

        $ventasAux = [];
        foreach ($ventas as $value) {
            $ventasAux[$value['restaurant_id']][] = $value;
        }

        if (Auth::user()->role != "admin") {
            die("No puedes acceder aqui");
        }

        return view("admin.salesF.informe", compact('ventasAux'));
    }

    public function sellingBurgers(Request $request)
    {
        $restaurant = RestaurantF::find($request->id);

        $i = 1;
        $datos = [];
        foreach (explode("#", $request->unids) as $unidades) {

            if ($unidades > 0) {

                $dato = [
                    "restaurant_id" => $restaurant->name,
                    "burger" => $restaurant->{"dish" . $i},
                    "units" => $unidades,
                    "user" => $request->user
                ];

                $sale = SaleF::create($dato);
                $datos['lineas'][] = $dato;
            }

            $i++;
        }

        $datos["restaurant"] = $restaurant->name;


        //Crear ticket
        $ticket = Ticket::create([
            'json' => $this->json($datos),
            'copias' => 1,
            'tipo' => $request->user,
            'usuario' => 0,
            'hora_impresion' => date("Y-m-d H:i:s"),
            'token_restaurante' => 'fWiAPXGawg7GKoSb7MaxWvcn3qcEv6JUYAnM9Sh4fMckrYSYVW',
        ]);
    }

    private function json($datos)
    {

        $precio_burger = 12;

        $total = 0;
        $lineas = [];
        foreach ($datos['lineas'] as $linea) {
            $lineas[] = [
                "plato" => explode("#", $linea['burger'])[0],
                "plato_id" => 1,
                "unidades" => $linea['units'],
                "precio" => explode("#", $linea['burger'])[1],
                "total" => $linea['units'] * explode("#", $linea['burger'])[1],
                "opciones" => null,
                "observaciones" => null
            ];

            $total += $linea['units'] * explode("#", $linea['burger'])[1];
        }

        $json = '{
            "total": ' . $total . ',
            "pedido": "Esperamos que la disfrutes!!!",
            "restaurante": "' . $datos['restaurant'] . '",
            "restaurante_extra": "MayosBurgerFest###",
            "lineas": ' . json_encode($lineas) . ',
            "copia": "(Entrega este ticket en la hamburguesería)",
            "observaciones": "",
            "coletilla": "MayosBurgerFest"
        }';

        return $json;
    }

    public function getSales(Request $request)
    {
        $ventas = SaleF::where('user', $request->user)->take(20)->orderBy('id', 'desc')->get();

        return view("admin.salesF.salesTable", compact('ventas'));
    }

    public function deleteSale(Request $request)
    {
        SaleF::where('id', $request->id)->delete();
    }
}
