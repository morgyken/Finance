<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Dispatch
 *
 * @property int $id
 * @property int $user
 * @property int|null $firm
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Settings\Entities\Insurance|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\DispatchDetails[] $details
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Dispatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Dispatch whereFirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Dispatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Dispatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Dispatch whereUser($value)
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
