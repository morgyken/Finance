<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\FinanceGlAccounts
 *
 * @property integer $id
 * @property integer $group
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Dervis\Modules\Finance\Entities\FinanceAccountGroup $groups
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceGlAccounts whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceGlAccounts whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceGlAccounts whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceGlAccounts whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\FinanceGlAccounts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceGlAccounts extends Model
{

    protected $fillable = [];
    public $table = 'finance_gl_accounts';

    public function groups()
    {
        return $this->belongsTo(FinanceAccountGroup::class, 'group');
    }

}
