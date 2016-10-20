<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\FinanceAccountGroup
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Dervis\Modules\Finance\Entities\FinanceAccountType $types
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountGroup whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountGroup whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceAccountGroup extends Model
{

    protected $fillable = [];
    public $table = 'finance_gl_account_groups';

    public function types()
    {
        return $this->belongsTo(FinanceAccountType::class, 'type');
    }

}
