<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class OrderController extends Controller
{
    public function index()
    {
        return view("order");
    }

    public function show(){
        $orders = Invoice::get();
        $data = [];

        $index = 1;

        foreach ($orders as $order) {
            $data[] = [
                'no' => $index,
                'customer_name' => $order->name,
                'customer_mobile' => $order->mobile,
                'customer_email' => $order->email,
                'customer_address' => $order->address,
                'invoice_number' => $order->invoice_number
            ];
            $index++;
        }
        return response()->json($data);
    }
}
