<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Config;
use App\Models\Customer;
use App\Models\Element;
use App\Models\DishType;
use App\Models\OrderLine;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrderLineElement;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function getInvoiceSAP(Request $request)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://valhanaappdes.aquaservice.com:50001/sap/bc/ZDOC?getPDF=null&contRep=ZD&arObject=ZFACTURAS&docId=1105379886',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic UkZDVVNFUjpBcXVhc2VydmljZTE5',
                'Cookie: MYSAPSSO2=AjQxMDMBABhSAEYAQwBVAFMARQBSACAAIAAgACAAIAACAAYxADAAMAADABBBAFMARAAgACAAIAAgACAABAAYMgAwADIANAAwADIAMgAwADEAMQAzADgABQAEAAAACAYAAlgACQACUwD%2fAVYwggFSBgkqhkiG9w0BBwKgggFDMIIBPwIBATELMAkGBSsOAwIaBQAwCwYJKoZIhvcNAQcBMYIBHjCCARoCAQEwcDBkMQswCQYDVQQGEwJERTEcMBoGA1UEChMTU0FQIFRydXN0IENvbW11bml0eTETMBEGA1UECxMKU0FQIFdlYiBBUzEUMBIGA1UECxMLSTAwMjEwODY4MzMxDDAKBgNVBAMTA0FTRAIICiAiBhgRCQEwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTI0MDIyMDExMzgzN1owIwYJKoZIhvcNAQkEMRYEFFfREFJhx43lg7R8KQE%21IpGM9Id0MAkGByqGSM44BAMELjAsAhRvWaodiJfz9YJJqM18SdKIJUsTTAIUXj12LkTb4FKMrx%2ffSpAH6O3AHCQ%3d; SAP_SESSIONID_ASD_100=TyYOKScAPbnFFUMQKnIFJOJkZtvP_RHutQm18qO8Ilc%3d; SPNegoTokenRequested=2024-02-20%2011%3a38%3a09; sap-usercontext=sap-client=100'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    /**
     * Actualizar categorias de MOCHILOO a COMOAQUI
     *
     * @param Request $request
     * @return void
     */
    public function categoriesFromMochilloToComoaqui(Request $request)
    {
        //Recuperamos todas las categorias del restaurante de mochiloo
        $dishTypes = DishType::all();
        $contador = 0;
        foreach ($dishTypes as $dish) {

            //Configuramos el calendario del tipo de plato
            $sql = "UPDATE restaurante_tipo_plato SET 
                    dias = '" . $this->getDayOfWeek2($dish) . "',
                    turno = '" . $this->getTurn2($dish) . "'
                    WHERE tipo_plato_id = '$dish->dishTypeCaId' AND restaurante_id = '" . env('RESTAURANTE_ID') . "'
                    LIMIT 1;
            ";
            DB::connection('mysql_comoaqui')->update($sql);

            //Actualziamos el nombre del tipo de plato
            $sql = "UPDATE tipo_plato SET 
                    slug = '" . $dish->slug . "',
                    tipo = '" . $dish->name . "' 
                    WHERE id = '$dish->dishTypeCaId'
                    LIMIT 1;
            ";
            DB::connection('mysql_comoaqui')->update($sql);
            $contador++;
        }

        return response()->json(['message' => 'Se actualizaron ' . $contador . ' categorias']);
    }

    /**
     * Crear categorias de COMOAQUI a MOCHILOO
     *
     * @param Request $request
     * @return void
     */
    public function categoriesFromComoaquiToMochillo(Request $request)
    {
        //*** 
        // COMOAQUI
        //***
        $categorias = DB::connection('mysql_comoaqui')->select("
        SELECT
            * 
        FROM
            restaurante_tipo_plato 
        Inner JOIN
            tipo_plato ON tipo_plato.id = restaurante_tipo_plato.tipo_plato_id
        WHERE
            restaurante_id = " . env("RESTAURANTE_ID") . "
        ");

        $contador = 0;

        foreach ($categorias as $cat) {

            if (strpos($cat->tipo, "#") !== false) {
                continue;
            }

            $DishType = DishType::where('dishTypeCaId', $cat->tipo_plato_id)->first();

            if ($DishType == null) {
                $DishType = new DishType();
            }

            $DishType->name = ucfirst($cat->tipo);
            $DishType->slug = Str::slug($cat->tipo);
            $DishType->hidden = 0;
            $DishType->manageStock = 0;
            $DishType->monday = $this->getDayOfWeek($cat->dias, "l");
            $DishType->mondayTurn = $this->getTurn($cat->turno);
            $DishType->tuesday = $this->getDayOfWeek($cat->dias, "m");
            $DishType->tuesdayTurn = $this->getTurn($cat->turno);
            $DishType->wednesday = $this->getDayOfWeek($cat->dias, "x");
            $DishType->wednesdayTurn = $this->getTurn($cat->turno);
            $DishType->thursday = $this->getDayOfWeek($cat->dias, "j");
            $DishType->thursdayTurn = $this->getTurn($cat->turno);
            $DishType->friday = $this->getDayOfWeek($cat->dias, "v");
            $DishType->fridayTurn = $this->getTurn($cat->turno);
            $DishType->saturday = $this->getDayOfWeek($cat->dias, "s");
            $DishType->saturdayTurn = $this->getTurn($cat->turno);
            $DishType->sunday = $this->getDayOfWeek($cat->dias, "d");
            $DishType->sundayTurn = $this->getTurn($cat->turno);
            $DishType->dishTypeCaId = $cat->tipo_plato_id;
            $DishType->short = 0;
            $DishType->save();

            $contador++;
        }

        return response()->json([
            'message' => 'Categorias creadas: ' . $contador,
        ]);
    }

    private function getDayOfWeek($dias_ca, $dia_laravel)
    {
        if (strpos($dias_ca, $dia_laravel) === false) {
            return 0;
        } else {
            return 1;
        }
    }

    private function getDayOfWeek2($DishType)
    {
        $dias = "";

        if ($DishType->monday) {
            $dias .= "l,";
        }
        if ($DishType->tuesday) {
            $dias .= "m,";
        }
        if ($DishType->thursday) {
            $dias .= "x,";
        }
        if ($DishType->wednesday) {
            $dias .= "j,";
        }
        if ($DishType->friday) {
            $dias .= "v,";
        }
        if ($DishType->satuday) {
            $dias .= "s,";
        }
        if ($DishType->sunday) {
            $dias .= "d,";
        }

        return substr_replace($dias, "", -1);;
    }

    private function getTurn($turno_ca)
    {
        switch ($turno_ca) {
            case 'completo':
                return "allDay";
                break;
            case 'comidas':
                return "atMeals";
                break;
            case 'cenas':
                return "atDinners";
                break;
            default:
                return "allDay";
                break;
        }
    }

    private function getTurn2($DishType)
    {
        $arrayTurno[] = $DishType->mondayTurn;
        $arrayTurno[] = $DishType->tuesdayTurn;
        $arrayTurno[] = $DishType->thursdayTurn;
        $arrayTurno[] = $DishType->wednesdayTurn;
        $arrayTurno[] = $DishType->fridayTurn;
        $arrayTurno[] = $DishType->saturdayTurn;
        $arrayTurno[] = $DishType->sundayTurn;
        $arrayTurno = array_count_values($arrayTurno);

        switch (array_search(max($arrayTurno), $arrayTurno)) {
            case 'allDay':
                return "completo";
                break;
            case 'atMeals':
                return "comidas";
                break;
            case 'atDinners':
                return "cenas";
                break;
            default:
                return "completo";
                break;
        }
    }

    public function syncCaUrban(Request $request)
    {

        $json = '{"0":{"plato":{"plato":[{"nombre":"Papas fritas","precio":"2.50","ingredientes":"","id":"0c781b0f45a678831b3036ce49f30e5b","check":"9ae24534906226a6d2702a59f84bfd58"}],"unidades_minimas":1,"unidades":1}},"1":{"plato":{"plato":[{"nombre":"Papas fritas con cheddar","precio":"3.30","ingredientes":"","id":"8fec975857a806366fc545f3d9ccffc8","check":"36cbbe467ef42047b30612ec54da4d11"}],"unidades_minimas":1,"unidades":1}},"2":{"plato":{"plato":[{"nombre":"Original Urban","precio":9,"ingredientes":"Doble smash (200gr), cheddar, pepinillo, tomate, lechuga y salsa Urban","id":"f90ebfa07f0029913842518e9402779f","check":"0e26395d77ddbbc42ab8dbb8a9bf3629"}],"extras":[{"nombre":"Sin pepinillo","precio":"0.00","seleccionado":false,"id":"df3948e55859ed3fa2662c17d4c5fdc4","check":"1302156a33dee215169e63238b6a686d"},{"nombre":"Sin tomate","precio":"0.00","seleccionado":false,"id":"6cea997881577c6f6bcf7db7fd741872","check":"b58cb8b130cb5306af414f5fcda38a27"},{"nombre":"Sin lechuga","precio":"0.00","seleccionado":false,"id":"dc69b2f2566ab3a9bc91dfb1b8b67d0b","check":"32bddcf17e1102accad6d2d746e358d0"},{"nombre":"Sin salsa Urban","precio":"0.00","seleccionado":false,"id":"9aa49d6e3310dacd3aba6ec72e584b2c","check":"330d7446217d7aa74451690e433721bc"}],"unidades_minimas":1,"unidades":1}},"3":{"plato":{"plato":[{"nombre":"CheeseBacon","precio":"9.90","ingredientes":"Doble smash (200gr), doble bacon, doble cheddar, pepinillo y salsa Urban","id":"ffe1a314bffd74bb5e6eb47908cdf93f","check":"dcd0a8720d41b8b2dbaaeae17b298a1f"}],"extras":[{"nombre":"Sin pepinillo","precio":"0.00","seleccionado":false,"id":"df3948e55859ed3fa2662c17d4c5fdc4","check":"1302156a33dee215169e63238b6a686d"},{"nombre":"Sin bacon","precio":"0.00","seleccionado":false,"id":"ad2b7a15527267d3d59771ef769628dd","check":"e46b7ce4c41e0a79f6efd8d0cb3a41aa"},{"nombre":"Sin salsa Urban","precio":"0.00","seleccionado":false,"id":"9aa49d6e3310dacd3aba6ec72e584b2c","check":"330d7446217d7aa74451690e433721bc"}],"unidades_minimas":1,"unidades":1}},"4":{"plato":{"plato":[{"nombre":"BBQ Lover","precio":"9.50","ingredientes":"Doble smash (200gr), bacon, cheddar, cebolla crujiente y salsa BBQ Special","id":"9d357676f21c888348133c32a3a9056a","check":"6b15187bdbbc7fdeb4eb319118d8d152"}],"extras":[{"nombre":"Sin cebolla crujiente","precio":"0.00","seleccionado":false,"id":"194878e0fcff9105bb5b9f933aef5ba6","check":"9c0350c142f93a9d997b0ff33a75ef2a"},{"nombre":"Sin bacon","precio":"0.00","seleccionado":false,"id":"ad2b7a15527267d3d59771ef769628dd","check":"e46b7ce4c41e0a79f6efd8d0cb3a41aa"},{"nombre":"Sin salsa BBQ","precio":"0.00","seleccionado":false,"id":"eaba49ca281e4b0999c3388b7a0db3d2","check":"93ac865f3e7d33aa6712699e7180a12c"}],"unidades_minimas":1,"unidades":1}},"order":"183448","delivery_time":"21:30"}';

        $json = json_decode($json, 1);
        $order = [];
        foreach ($json as $key => $plato) {

            //Recuperamos el plato por el nombre
            if (is_array($plato)) {
                $dish = Dish::where('name', $plato['plato']['plato'][0])->first();

                $unid = $plato['plato']['unidades'];

                $order['lines'][] = [
                    'dish' => $dish,
                    'unid' => $unid,
                ];
            } else {
                if ($key == "order") {
                    $order['order_ca'] = $plato;
                }

                if ($key == "delivery_time") {
                    $order['delivery_time'] = $plato;
                }
            }
        }

        $this->registrarPedido($order, $order['order_ca'], $order['delivery_time']);

        dd('');
    }

    private function calcularTotal($lineas)
    {

        return 10;
    }

    public function registrarPedido($lineas, $order_ca, $delivery_time)
    {
        //Guardamos los datos de la cabecera
        $restaurante = Restaurant::first();
        $pedido_id = Order::orderBy("id", "desc")->first();
        $pedido_id = ($pedido_id ? $pedido_id->id : 0);

        $cliente = Customer::find(708);

        $order = Order::create([
            "order" => date("Y") . "-" . str_pad(++$pedido_id, 4, "0", STR_PAD_LEFT),
            "date" => date("Y-m-d H:i:s"),
            "total" => $this->calcularTotal($lineas),
            "observacions" => '',
            "observations_kitchen" => '',
            "order_comoaqui" => substr($order_ca, -2),
            "time_ready" => ($delivery_time ? ($delivery_time) : null),
            "margin_ready" => ($delivery_time ? (Config::find(14)->value) : null),
            "status" => 2,
            "paid" => 1,
            "payment_method" => 'ca',
            "customer_id" => $cliente->id,
            "address_id" => 1,
            "restaurant_id" => $restaurante->id,
            "token" => Str::random(30),
            "discount" => 0,
        ]);

        //Incrementamos el ID de pedido en la tabla de configs
        $ultimo = Config::find(2);
        $ultimo->value = $order->id;
        $ultimo->save();

        //Guardamos los datos de las lineas

        if ($lineas) {

            foreach ($lineas['lines'] as $plato) {

                //$plato = $plato['dish'];                
                $line = OrderLine::create([
                    "order_id" => $order->id,
                    "units" => $plato['unid'],
                    "observacions" => '',
                    "dish_id" => $plato['dish']->id,
                    //No pasamos aqui los elementos para precio del plato sea el precio base
                    "price" => 12 //DishController::recuperarPrecioPlatoInner($plato['dish'], null, $plato['unid'], null),
                ]);

                /*if ($line) {
                    //Guardamos los datos de los elementos de las lineas                    
                    foreach ($plato['elementos'] as $elemento) {
                        OrderLineElement::create([
                            "order_line_id" => $line->id,
                            "price" => Element::find($elemento)->price,
                            "element_id" => $elemento,
                        ]);
                    }
                }*/

                $oc = new OrderController();
                $oc->controlDeStock(['plato' => $plato['dish']->id]);
            }
        }
        return $order;
    }
}
