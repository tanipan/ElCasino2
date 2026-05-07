<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'table');
    }

    public function location()
    {
        $location = Location::find($this->location);

        return $location;
    }

    public function getOrders()
    {
        if ($this->relationLoaded('orders')) {
            return $this->orders;
        }

        $today = date('Y-m-d');

        return Order::where('table', $this->id)
            ->where('paid', 0)
            ->where('status', "!=", 6)
            ->whereRaw("date(date)  between '$today 00:00:00' and '$today 23:59:59'")
            ->get();
    }

    public function getOrdersPending()
    {
        if ($this->relationLoaded('orders')) {
            return $this->orders->where('status', 1);
        }

        $today = date('Y-m-d');

        return Order::where('table', $this->id)
            ->where('paid', 0)
            ->where('status', 1)
            ->whereRaw("date(date)  between '$today 00:00:00' and '$today 23:59:59'")
            ->get();
    }

    public function getTotal()
    {
        $orders = $this->getOrders();
        $total = 0;
        foreach ($orders as $order) {
            $total += $order->total;
        }

        return $total;
    }

    public function getStatusColor()
    {
        $status = " bg-secondary";

        if ($this->getOrders()->count()) {
            $status = " bg-success";
        }

        if ($this->getOrdersPending()->count()) {
            $status = " bg-warning";
        }

        if ($this->notify_waiter or $this->request_account) {
            $status = " bg-danger";
        }

        return $status;
    }

    public function showNotificationTable()
    {
        $return = "";
        if ($this->notify_waiter) {
            $return .=  '<span data-table="' . $this->id . '" class="table-alert-waiter badge badge-warning blink" style="font-size: 19px;cursor: pointer;">Camarero requerido</span>';
        }

        if ($this->request_account) {

            if ($this->payment_method == 'card') {
                $payment_method = "💳";
            } else {
                $payment_method = "💶";
            }


            if ($this->division_account > 1) {
                $return .= '<span data-table="' . $this->id . '" class="table-alert table-alert-account badge badge-warning blink" style="font-size: 19px;cursor: pointer;margin-top:5px">' . $payment_method . ' Cuenta entre ' . $this->division_account . '</span>';
            } else {
                $return .= '<span data-table="' . $this->id . '" class="table-alert table-alert-account badge badge-warning blink" style="font-size: 19px;cursor: pointer;margin-top:5px">' . $payment_method . ' Cuenta</span>';
            }
        }

        return  $return;
    }

    public function setNotifyWaiter()
    {
        $this->notify_waiter = true;
        $this->save();
    }

    public function setRequestAccount()
    {
        $this->request_account = true;
        $this->save();
    }

    public function setDivisionAccount($numberOfDivisions = 1)
    {
        $this->division_account = $numberOfDivisions;
        $this->save();
    }

    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
        $this->save();
    }

    public function cleanTable()
    {
        $this->payment_method = null;
        $this->division_account = 0;
        $this->notify_waiter = false;
        $this->request_account = false;
        $this->save();
    }

    public function idTableFullyServed()
    {
        if ($this->relationLoaded('orders')) {
            $total_units = 0;
            $total_served = 0;
            $has_lines = false;

            foreach ($this->orders as $order) {
                if ($order->relationLoaded('orderLines')) {
                    foreach ($order->orderLines as $line) {
                        $has_lines = true;
                        $total_units += $line->units;
                        $total_served += $line->units_served_table;
                    }
                }
            }

            if ($has_lines) {
                return ($total_units > 0 && $total_units == $total_served);
            } else {
                return false;
            }
        }

        $today = date('Y-m-d');

        $results = DB::select("select sum(ol.`units_served_table`) = sum(ol.`units`) servida
        from orders o 
        inner join order_lines ol ON ol.`order_id` = o.id
        where o.paid=0 and o.`status` != 6 and date(o.date)  between '" . $today . " 00:00:00' and '" . $today . " 23:59:59'
        and o.`table`=" . $this->id . "");

        return $results[0]->servida;
    }
}
