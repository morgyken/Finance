<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\FinanceAccountType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceAccountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceAccountType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceAccountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceAccountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceAccountType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceAccountType extends Model {

    protected $fillable = [];
    public $table = 'finance_gl_account_types';

}
