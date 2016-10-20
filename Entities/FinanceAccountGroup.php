<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceAccountGroup
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Finance\Entities\FinanceAccountType $types
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceAccountGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceAccountGroup whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceAccountGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceAccountGroup whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceAccountGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\FinanceAccountGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceAccountGroup extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_account_groups';

    public function types() {
        return $this->belongsTo(FinanceAccountType::class, 'type');
    }

}
