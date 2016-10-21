<?php

namespace Dervis\Modules\Finance\Http\Controllers;

use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Entities\InventoryDispensing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{

    public function print_bill(Request $request)
    {
        $bill = InsuranceInvoice::findOrFail($request->id);
        $batch_sale = InventoryBatchProductSales::where('receipt', '=', $bill->invoice_no)->first();
        $batch = $batch_sale->id;
        $sold = InventoryDispensing::where('batch', '=', $batch)->get();

        $pdf = \PDF::loadView('finance::prints.bill', ['bill' => $bill, 'sold' => $sold]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
    }

}
