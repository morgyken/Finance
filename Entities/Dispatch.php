<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Dispatch
 *
 * @property integer $id
 * @property integer $user
 * @property integer $firm
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\DispatchDetails[] $details
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereFirm($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Dispatch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dispatch extends Model {

    protected $table = 'finance_bill_dispatches';

    public function details() {
        return $this->hasMany(DispatchDetails::class, 'dispatch');
    }

    public function company() {
        return $this->belongsTo(\Ignite\Settings\Entities\Insurance::class, 'firm', 'id');
    }

}
