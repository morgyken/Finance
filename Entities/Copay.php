<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Copay
 *
 * @property int $id
 * @property int $visit_id
 * @property int $company_id
 * @property int $scheme_id
 * @property float $amount
 * @property int|null $payment_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Copay whereVisitId($value)
 * @mixin \Eloquent
 */
class Copay extends Model
{
    protected $table = 'finance_copay';
    protected $guarded = [];
}
