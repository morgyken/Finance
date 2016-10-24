<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Finance\Entities\InsuranceInvoice;

class FinanceController extends AdminBaseController {

    public function __construct() {
        parent::__construct();
    }

    public function billing() {
        $this->data['insurance_invoices'] = InsuranceInvoice::all();
        return view('finance::billing', ['data' => $this->data]);
    }

}
