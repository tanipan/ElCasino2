<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Config;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController extends Controller
{
    public function show(Table $table, Request $request)
    {
        return QrCode::size(300)->generate(
            route('tableLogin', $table->token),
        );
    }
}
