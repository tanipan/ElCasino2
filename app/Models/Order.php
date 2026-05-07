<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDateCreatedAttribute()
    {
        $date = new DateTime($this->created_at);

        return $date->format('H:i:s d-m-Y');
    }

    public function getPickUpTimeAttribute()
    {
        date_default_timezone_set('Europe/Madrid');
        $minutos_margen = Config::find(14)->value;
        $nueva_hora = date('H:i:s', strtotime("-$minutos_margen minutes", strtotime($this->time_ready)));

        return $nueva_hora;
    }

    public function getOrdersPending()
    {
        //Obtenemos todos los pedidos que todavía no ha llegado su hora de impresión
        $sql_pedidos_programados = "select * from orders o
        where 
        o.created_at between concat(CURDATE(),' 00:00:00') and concat(CURDATE(),' 23:59:59') and
        /*o.time_ready and*/ status=2";

        $pp = DB::select($sql_pedidos_programados);

        $pedidos = [];
        foreach ($pp as $value) {
            $pedidos[$value->time_ready] = "";
        }
        ksort($pedidos);

        foreach ($pedidos as $hora => $vacio) {

            $temp = [];
            foreach ($pp as $order) {

                if ($hora == $order->time_ready) {
                    $temp['order'][] = $order;
                }
            }

            $temp_dish = [];
            foreach ($temp['order'] as $or) {
                $lines = OrderLine::where('order_id', $or->id)->get();
                foreach ($lines as $line) {

                    //Sacamos las unidades de cada plato por hora
                    if (array_key_exists($line->dish_id, $temp_dish)) {
                        $num = $temp_dish[$line->dish_id];
                        $temp_dish[$line->dish_id] = $num + $line->units;
                    } else {
                        $temp_dish[$line->dish_id] = $line->units;
                    }
                }
            }

            $temp['dishs'] = $temp_dish;

            //dd($temp_dish);
            $pedidos[$hora] = $temp;
        }
        //dd($pedidos);
        return $pedidos;
    }

    public function getTotalDishByOrders($date1, $date2)
    {
        if (!$date1 or !$date2) {
            return [];
        }

        //Obtenemos todos los pedidos que todavía no ha llegado su hora de impresión
        $sql_articulos_vendidos = "select 
        d.`name` nombre, sum(ol.`units`) unidades, dt.name tipo
        FROM orders o 
        inner join order_lines ol on ol.`order_id` = o.id
        inner join `dishes` d on d.id = ol.`dish_id`
        inner join `dish_types` dt ON dt.id = d.`dish_type_id`
        where (`paid` = 1 or (`table`>0)) and o.`date` BETWEEN '" . $date1 . " 00:00:00' and '" . $date2 . " 23:59:59' and o.`status`<=4 
        group by d.`name`,dt.name
        order by sum(ol.`units`) desc";

        $pp = DB::select($sql_articulos_vendidos);


        return $pp;
    }

    public function getDishses()
    {
        $dishs = Dish::all();

        $array_dish = [];
        foreach ($dishs as $dish) {
            $array_dish[$dish->id] = $dish;
        }

        return $array_dish;
    }

    public function getTotal($euro = false, $soloValor = false)
    {
        if ($euro) {
            if ($this->discount) {
                if ($soloValor) {
                    return ($this->total - ($this->total * $this->discount / 100)) . "€";
                } else {
                    return "<span style='color: red'>" . ($this->total - ($this->total * $this->discount / 100)) . "€</span>";
                }
            } else {
                return $this->total . "€";
            }
        } else {
            if ($this->discount) {
                if ($soloValor) {
                    return ($this->total - ($this->total * $this->discount / 100));
                } else {
                    return "<span style='color: red'>" . ($this->total - ($this->total * $this->discount / 100)) . "</span>";
                }
            } else {
                return $this->total;
            }
        }
    }

    public function getLines()
    {
        return OrderLine::where('order_id', $this->id)->get();
    }

    function getStatusColorTable()
    {
        switch ($this->status) {
            case 1:
                return "danger blink";
                break;
            case 2:
                return "info";
                break;
            default:
                return "info";
                break;
        }
    }

    public function getType()
    {
        if ($this->order_comoaqui) {
            return "ca";
        } elseif ($this->customer_id > 715) {
            return "takeAway";
        } elseif ($this->getAttribute('table')) {
            return 'table';
        } else {
            return "takeAway";
        }
    }

    public function getLinesStarter()
    {
        $lines = $this->getLines();
        $lines_aux = [];

        $postres = Config::find(29)->value;
        $entrantes = Config::find(30)->value;
        $salsas = Config::find(34)->value;

        $val = $postres . "," . $entrantes . "," . $salsas;
        $val = explode(",", $val);

        foreach ($lines as $line) {
            if (in_array($line->dish->dish_type_id, $val) and $line->dish->id != 17) {
                $lines_aux[] = $line;
            }
        }

        return $lines_aux;
    }

    public function getLinesStarterIsPrepared()
    {
        $lines = $this->getLines();
        $lines_aux = [];
        $todasPreparadas = false;

        $postres = Config::find(29)->value;
        $entrantes = Config::find(30)->value;

        $val = $postres . "," . $entrantes;
        $val = explode(",", $val);

        foreach ($lines as $line) {
            if (in_array($line->dish->dish_type_id, $val) and $line->dish->id != 17) {
                if (!$line->is_ready) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getLinesBurger()
    {
        $lines = $this->getLines();

        $lines_aux = [];

        $burger = Config::find(13)->value;

        $burger = explode(",", $burger);

        foreach ($lines as $line) {
            if (in_array($line->dish->dish_type_id, $burger)) {
                $lines_aux[] = $line;
            }
        }

        return $lines_aux;
    }

    public function getLinesBurgerIsPrepared()
    {
        $lines = $this->getLines();
        $lines_aux = [];
        $todasPreparadas = false;

        $burgers = Config::find(13)->value;
        $burgers = explode(",", $burgers);

        foreach ($lines as $line) {
            if (in_array($line->dish->dish_type_id, $burgers)) {
                if (!$line->is_ready) {
                    return false;
                }
            }
        }

        return true;
    }

    public function orderCanBePrepared()
    {
        if (!$this->time_ready) {
            return 1;
        }

        date_default_timezone_set('Europe/Madrid');
        // Obtener la hora actual en formato de 24 horas
        $horaActual = date('H:i');

        $minutos = Config::find(14)->value;

        // Sumar los minutos a la hora futura
        $horaFuturaConMinutos = strtotime("-$minutos minutes", strtotime($this->time_ready));

        // Formatear la hora futura con minutos
        $horaFuturaConMinutos = date('H:i', $horaFuturaConMinutos);

        // Comparar la hora futura con minutos con la hora actual
        return $horaFuturaConMinutos <= $horaActual;
    }

    function getTimeSort()
    {
        if ($this->time_ready) {
            return $this->time_ready;
        } else {
            return Carbon::parse($this->date)->format('H:i:s');;
        }
    }

    function getMinutesLate()
    {
        // Convertir las horas a objetos Carbon
        $carbonHora1 = Carbon::parse(date("H:i:s"));
        $carbonHora2 = Carbon::parse(($this->time_ready ? $this->time_ready : $this->date));

        // Calcular la diferencia en minutos
        $diferenciaEnMinutos = $carbonHora1->diffInMinutes($carbonHora2);

        // Determinar si la diferencia debe ser positiva o negativa
        $signo = ($carbonHora1 < $carbonHora2) ? -1 : 1;

        // Aplicar el signo a la diferencia en minutos
        if (($signo * $diferenciaEnMinutos) < 0) {
            return 0;
        }
        return $signo * $diferenciaEnMinutos;
    }
}
