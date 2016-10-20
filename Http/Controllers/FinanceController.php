<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Finance\Entities\PatientPayments;
use Ignite\Reception\Entities\Patients;

class FinanceController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }


}
