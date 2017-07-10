<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\RemovedBills
 *
 * @property int $id
 * @property int|null $visit
 * @property int|null $investigation
 * @property int|null $dispensing
 * @property int|null $sale
 * @property string|null $reason
 * @property int $user
 * @property int|null $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereDispensing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereInvestigation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\RemovedBills whereVisit($value)
 * @mixin \Eloquent
 */
class RemovedBills extends Model {

    protected $fillable = [];
    protected $table = 'finance_removed_bills';

}
