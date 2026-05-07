<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DishType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getIsVisibleAttribute()
    {
        if ($this->IsOpenThisDayV2() and $this->IsOpenThisTurnV2()) {
            return 1;
        }

        if (!$this->IsOpenThisDay() or !$this->IsOpenThisTurn()) {
            return 0;
        }

        //Sacamos todos los platos que contiene
        $dishs = Dish::where('dish_type_id', $this->id)
            ->where('hidden', "!=", 1)
            ->get();

        if (count($dishs) == 0) {
            return 0;
        }

        //Si no gestiona stock, es como si siempre tuviera stock de todos sus platos
        if ($this->manageStock == 0) {
            return 1;
        }

        foreach ($dishs as $dish) {
            if ($dish->HasStock) {
                return 1;
            }
        }

        return 0;
    }

    public function IsOpenThisDay()
    {
        $day = date('w');
        $open = false;

        switch ($day) {
            case '0':   //Domingo
                $open = $this->sunday;
                break;
            case '1':   //Lunes
                $open = $this->monday;
                break;
            case '2':   //Martes
                $open = $this->tuesday;
                break;
            case '3':   //Miercoles
                $open = $this->wednesday;
                break;
            case '4':   //Jueves
                $open = $this->thursday;
                break;
            case '5':   //Viernes
                $open = $this->friday;
                break;
            case '6':   //Sabado
                $open = $this->saturday;
                break;
        }

        return $open;
    }

    public function IsOpenThisDayV2()
    {
        $day = date('w');

        if (($day == 5) or ($day == 6) or ($day == 0)) {
            $day = 1;
        } else {
            $day = $day + 1;
        }

        $open = false;

        switch ($day) {
            case '0':   //Domingo
                $open = $this->sunday;
                break;
            case '1':   //Lunes
                $open = $this->monday;
                break;
            case '2':   //Martes
                $open = $this->tuesday;
                break;
            case '3':   //Miercoles
                $open = $this->wednesday;
                break;
            case '4':   //Jueves
                $open = $this->thursday;
                break;
            case '5':   //Viernes
                $open = $this->friday;
                break;
            case '6':   //Sabado
                $open = $this->saturday;
                break;
        }

        return $open;
    }

    public function IsOpenThisTurn()
    {
        $day = date('w');
        $turn = null;

        switch ($day) {
            case '0':   //Domingo
                $turn = $this->sundayTurn;
                break;
            case '1':   //Lunes
                $turn = $this->mondayTurn;
                break;
            case '2':   //Martes
                $turn = $this->tuesdayTurn;
                break;
            case '3':   //Miercoles
                $turn = $this->wednesdayTurn;
                break;
            case '4':   //Jueves
                $turn = $this->thursdayTurn;
                break;
            case '5':   //Viernes
                $turn = $this->fridayTurn;
                break;
            case '6':   //Sabado
                $turn = $this->saturdayTurn;
                break;
        }

        if ($turn == "allDay") {
            return true;
        } elseif (($turn == "atMeals") and (date('H:i') <= '16:00')) {
            return true;
        } elseif (($turn == "atDinners") and (date('H:i') > '16:00')) {
            return true;
        }

        return false;
    }

    public function IsOpenThisTurnV2()
    {
        $day = date('w');
        $currday = date('w');
        $turn = null;

        if (($day == 5) or ($day == 6) or ($day == 0)) {
            $day = 1;
        } else {
            $day = $day + 1;
        }

        switch ($day) {
            case '0':   //Domingo
                $turn = $this->sundayTurn;
                break;
            case '1':   //Lunes
                $turn = $this->mondayTurn;
                break;
            case '2':   //Martes
                $turn = $this->tuesdayTurn;
                break;
            case '3':   //Miercoles
                $turn = $this->wednesdayTurn;
                break;
            case '4':   //Jueves
                $turn = $this->thursdayTurn;
                break;
            case '5':   //Viernes
                $turn = $this->fridayTurn;
                break;
            case '6':   //Sabado
                $turn = $this->saturdayTurn;
                break;
        }

        if ($turn == "allDay") {
            return true;
        } elseif (($turn == "atMeals") and (date('H:i') > '16:00')) {
            return true;
        } elseif (($turn == "atDinners") and (date('H:i') > '16:00')) {
            return true;
        }

        if (($currday == 6) or ($currday == 0)) {
            return true;
        }

        return false;
    }
}
