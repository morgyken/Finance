<?php

namespace Dervis\Modules\Finance\Http\Controllers;

use Dervis\Modules\Finance\Entities\InsuranceInvoice;
use Illuminate\Http\Request;

class ReportController extends \Illuminate\Routing\Controller {

    public function print_bill(Request $request) {
        $bill = InsuranceInvoice::findOrFail($request->id);
        $batch_sale = InventoryBatchProductSales::where('receipt', '=', $bill->invoice_no)->first();
        $batch = $batch_sale->id;
        $sold = InventoryDispensing::where('batch', '=', $batch)->get();

        $pdf = \PDF::loadView('finance::prints.bill', ['bill' => $bill, 'sold' => $sold]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
    }

}
