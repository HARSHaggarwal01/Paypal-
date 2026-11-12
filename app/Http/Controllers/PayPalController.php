<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;

class PayPalController extends Controller
{
    protected $paypal;

    public function __construct(PayPalService $paypal)
    {
        $this->paypal = $paypal;
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $order = $this->paypal->createOrder($request->amount);

        return response()->json($order);
    }

    public function captureOrder(Request $request)
    {
        $request->validate([
            'orderId' => 'required|string',
        ]);

        $capture = $this->paypal->captureOrder($request->orderId);

        // Here you can mark the order as paid in DB, send email, etc.
        return response()->json($capture);
    }
}
