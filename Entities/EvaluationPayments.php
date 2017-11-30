<?php

namespace Ignite\Finance\Entities;

use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


class EvaluationPayments extends Model
{

    protected $fillable = [
        'receipt', 'patient', 'user', 'amount', 'visit', 'sale', 'dispensing', 'deposit'
    ];

    public $table = 'finance_evaluation_payments';

    protected $with = ['cash', 'card', 'cheque', 'mpesa', 'patients', 'users', 'jambopay'];

    public function getTotalAttribute()
    {
        $total = 0;
        if (!empty($this->cash)) {
            $total += $this->cash->amount;
        }
        if (!empty($this->card)) {
            $total += $this->card->amount;
        }
        if (!empty($this->mpesa)) {
            $total += $this->mpesa->amount;
        }
        if (!empty($this->cheque)) {
            $total += $this->cheque->amount;
        }
        if (!empty($this->jambopay)) {
            $total += $this->jambopay->Amount;
        }
        return $total;
    }

    public function getModesAttribute()
    {
        return payment_modes($this);
    }

    public function cash()
    {
        return $this->hasOne(PaymentsCash::class, 'payment');
    }

    public function getCashAmountAttribute()
    {
        $total = 0;
        if (!empty($this->cash)) {
            $total += $this->cash->amount;
        }
        return $total;
    }

    public function mpesa()
    {
        return $this->hasOne(PaymentsMpesa::class, 'payment');
    }

    public function cheque()
    {
        return $this->hasOne(PaymentsCheque::class, 'payment');
    }

    public function card()
    {
        return $this->hasOne(PaymentsCard::class, 'payment');
    }

    public function jambopay()
    {
        return $this->hasOne(JambopayPayment::class, 'payment_id');
    }

    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function details()
    {
        return $this->hasMany(EvaluationPaymentsDetails::class, 'payment', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function sales()
    {
        return $this->belongsTo(InventoryBatchProductSales::class, 'sale');
    }

    public function dispensing()
    {
        return $this->hasMany(Dispensing::class, 'dispensing', 'id');
    }

    public function copay()
    {
        return $this->hasOne(Copay::class, 'payment_id');
    }

}
