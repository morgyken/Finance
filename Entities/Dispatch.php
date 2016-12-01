<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Dispatch
 *
 * @property integer $id
 * @property integer $insurance_invoice
 * @property integer $visit
 * @property integer $user
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereInsuranceInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dispatch extends Model {

    protected $table = 'finance_bill_dispatches';

    public function details() {
        return $this->hasMany(DispatchDetails::class, 'dispatch');
    }

}
