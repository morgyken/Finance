<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\FinanceAccountType
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceAccountType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceAccountType extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_account_types';

}
