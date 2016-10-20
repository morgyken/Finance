<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

class insurance_invoice_payment extends Model {

    protected $fillable = ['insurance_invoice', 'user', 'amount', 'mode'];

}
