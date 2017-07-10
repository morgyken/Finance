<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceSmartExchangeTypes
 *
 * @property int $id
 * @property int|null $Type
 * @property int|null $Description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeTypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeTypes whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeTypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeTypes whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeTypes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceSmartExchangeTypes extends Model
{
    protected $guarded = [];
    protected $table = 'finance_smart_exchange_types';
}
