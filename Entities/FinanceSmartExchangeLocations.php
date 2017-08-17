<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceSmartExchangeLocations
 *
 * @property int $id
 * @property string|null $SL_ID
 * @property string|null $SP_ID
 * @property string|null $Location_Description
 * @property string|null $Group_Practice_Number
 * @property string $Country_Code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereGroupPracticeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereLocationDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereSLID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereSPID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeLocations whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceSmartExchangeLocations extends Model
{
    protected $guarded = [];
    protected $table = 'finance_smart_exchange_locations';
}
