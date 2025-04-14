<?php

namespace App\Http\Controllers;

use App\Models\BusinessInventoryMetricsPrices;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        return view("order");
    }

    public function show()
    {
        $orders = Invoice::orderBy('created_at', 'desc')->get();
        $data = [];

        $index = 1;

        foreach ($orders as $order) {
            $data[] = [
                'no' => $index,
                'customer_name' => $order->name,
                'customer_mobile' => $order->mobile,
                'customer_email' => $order->email,
                'customer_address' => $order->address,
                'invoice_number' => $order->invoice_number,
                "action" => "<i class='fas fa-eye view-invoice-items-btn' data-id='" . $order->invoice_number . "' data-url='view-invoice-items/" . $order->invoice_number . "' style='cursor: pointer;'></i>"
            ];
            $index++;
        }
        return response()->json($data);
    }

    public function viewInvoiceItems(string $invoiceNumber)
    {
        $invoiceItems = InvoiceItems::with('inventory', 'metric')
            ->where('invoice_number', $invoiceNumber)
            ->get();

            Log::info(json_encode($invoiceItems,JSON_PRETTY_PRINT));

        $invoiceItemsWithDetails = $invoiceItems->map(function ($item) {
            $priceRecord = BusinessInventoryMetricsPrices::where('business_id', $item->business_id)
                ->where('inventory_id', $item->inventory_id)
                ->where('metrics_id', $item->metrics_id)
                ->first();

            $rate = $priceRecord ? $priceRecord->price : 'N/A';
            $lineTotal = is_numeric($rate) && is_numeric($item->qty) ? $rate * $item->qty : 'N/A';

            return [
                'description' => $item->inventory && $item->metric ? $item->inventory->name . ' - ' . $item->metric->name : (optional($item->inventory)->name ?? optional($item->metric)->name ?? 'N/A'),
                'rate' => $rate,
                'qty' => $item->qty,
                'line_total' => $lineTotal,
            ];
        });

        return response()->json($invoiceItemsWithDetails);
    }
}
