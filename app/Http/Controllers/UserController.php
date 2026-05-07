<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TimeControl;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);

        if (Auth::user()->role != "admin") {
            die("No puedes acceder aqui");
        }

        return view("admin.user.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function create()
    {
        return view("admin.user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.user.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (request('password')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required',
                'password' => 'required|min:6',
                'password_confirmation' => 'required_with:password|same:password',
            ]);
        } else {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required'
            ]);
        }

        $user->name = request("name");
        $user->email = request("email");
        $user->role = request("role");

        if (request('password')) {
            $user->password = Hash::make(request('password'));
        }

        $user->save();

        return redirect()->route('admin.user.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user.list');
    }

    public function informeTime(Request $request)
    {

        $fechaInicio = Carbon::parse($request->date);
        $fechaFin = Carbon::parse($request->date2);

        $time_controls = $this->calculateHourPicking($fechaInicio, $fechaFin);

        return view('admin.user.timeControl', compact('time_controls'));
    }

    private function calculateHourPicking($fechaInicio, $fechaFin)
    {
        $empleados = [
            "77840732s" => [
                "nombre" => "Borja",
                "entrada" => "18:30",
            ],
            "21066922a" =>
            [
                "nombre" => "Angela",
                "entrada" => "19:00"
            ],
            "71732662d" => [
                "nombre" => "Isa",
                "entrada" => "18:30"
            ],
            "48695560y" => [
                "nombre" => "Kevin",
                "entrada" => "18:30"
            ],
            "48432960c" => [
                "nombre" => "Nico",
                "entrada" => "18:30"
            ],
            "48634998a" => [
                "nombre" => "Juanjo",
                "entrada" => "18:30"
            ],
            "46380884g" => [
                "nombre" => "David",
                "entrada" => "18:30"
            ],
            "77842603t" => [
                "nombre" => "Marta",
                "entrada" => "18:30"
            ]
        ];

        $nif2 = null;
        $horasTotales = 0;
        $horasTotalesNif = "";

        //Sacamos todos los fichajes entre dos fechas
        $fecha_aux = "";
        $nif = [];
        $nif2SumasTotales = [];
        for ($fecha = $fechaInicio; $fecha->lte($fechaFin); $fecha->addDay()) {
            $fecha_aux = Carbon::parse($fecha);
            $desde = $fecha->toDateString();
            $hasta = $fecha_aux->addDay()->toDateString();

            //echo "created_at between '$desde 17:00:00' and '$hasta 04:00:00'";
            $time_controls = TimeControl::whereRaw("created_at between '$desde 17:00:00' and '$hasta 04:00:00'")->get();

            //Crear un proceso/funcion que por cada nif, retorne un array con la hora de entrada y de salida, puede faltar alguna de ellas
            //en tal caso retornará un null en la que esté ausente, asi como tambien retornara el tiempo entre ambas horas            
            foreach ($time_controls as $key => $value) {
                $nif[$desde][strtolower($value->user)][] = $value->created_at;
            }

            $nif2 = [];
            foreach ($nif as $key => $value) {
                foreach ($value as $k => $v) {

                    $min = $this->min2($v, $k, $empleados);
                    //Calculamos la hora de entrada y la de salida
                    $nif2['fechas'][$key][$k] = [
                        "entrada" => $min,
                        "salida" => max($v),
                        "minutosDiff" => $min->diffInMinutes(max($v)),
                        "horasDiff" => round(($min->diffInMinutes(max($v))) / 60, 2),
                    ];

                    $horasTotales += $nif2['fechas'][$key][$k]["horasDiff"];

                    //Comprobamos si se ha olvidado de fichar en la entrada o salida
                    if ($nif2['fechas'][$key][$k]['entrada']->toDateTimeString() == $nif2['fechas'][$key][$k]['salida']->toDateTimeString()) {
                        if ($nif2['fechas'][$key][$k]['entrada']->toTimeString() >= "21:00:00") {
                            $nif2['fechas'][$key][$k]["entrada"] = null;
                        } else {
                            $nif2['fechas'][$key][$k]["salida"] = null;
                        }
                    }
                }
            }
        }


        $nif2['horasTotales'] = $horasTotales;
        $nif2['minutosTotalesPorTrabajador'] = $this->contarMinutosTotalesPorTrabajador($nif2);

        return $nif2;
    }

    function contarMinutosTotalesPorTrabajador($nif2)
    {
        $minutosTotales = [];
        //comprobar que $nif2['fechas'] tenga informacion
        if (empty($nif2['fechas'])) {
            return $minutosTotales;
        }
        foreach ($nif2['fechas'] as $fecha => $empleadosDia) {
            foreach ($empleadosDia as $nif => $value) {

                if (isset($minutosTotales[$nif])) {
                    $minutosTotales[$nif] += $value['minutosDiff'];
                } else {
                    $minutosTotales[$nif] = $value['minutosDiff'];
                }
            }
        }

        return $minutosTotales;
    }

    function min2($entradas, $nif, $emploees)
    {
        $entryTime = min($entradas);

        //Comprobamos si la hora de ficher $entryTime es manor que la hora oficial de entrda
        //enn tal caso aplicamos la hora oficial de entrada $emploees[$nif]['entrada']
        if (($entryTime->format('H:i:s')) < Carbon::parse($emploees[$nif]['entrada'])->format('H:i:s')) {
            $horaOficial = Carbon::parse($emploees[$nif]['entrada'])->format('H:i:s');
            $entryTime->setTime(explode(':', $horaOficial)[0], explode(':', $horaOficial)[1], explode(':', $horaOficial)[2]);
        }

        return $entryTime;
    }

    public function timeControlStorage(Request $request)
    {
        $tc = TimeControl::create([
            'user' => $request->user222
        ]);

        if ($tc) {
            return redirect()->route('admin.user.timeControl')->with('ok', true);
        } else {
            return redirect()->route('admin.user.timeControl')->with('ok', true);
        }
    }

    public function setCookie()
    {
        $response = new Response('Cookie creada');
        $response->cookie('cookieTime', 'cookie', 600000); // 60 minutos de vida

        return $response;
    }

    public function timeControl(Request $request)
    {
        if (1) {

            $time_controls = null;
            if ($request->date and $request->date2) {
                $fechaInicio = Carbon::parse($request->date);
                $fechaFin = Carbon::parse($request->date2);

                $time_controls = $this->calculateHourPicking($fechaInicio, $fechaFin);
            }

            return view('admin.user.timeControl', compact('time_controls'));
        } else {
            return redirect()->route('admin.order.list');
        }
    }
}
