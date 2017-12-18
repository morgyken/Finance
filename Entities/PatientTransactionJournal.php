<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PatientTransactionJournal
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $payment_id
 * @property float $amount
 * @property string $type
 * @property string|null $narrative
 * @property float $balance
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereNarrative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PatientTransactionJournal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientTransactionJournal extends Model
{
    protected $table = 'finance_patient_transaction_journals';
    protected $guarded = [];
}
