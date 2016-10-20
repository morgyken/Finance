<?php

namespace Dervis\Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Dervis\Modules\Finance\Entities\PatientPayments
 *
 * @property integer $id
 * @property string $receipt
 * @property integer $patient
 * @property integer $scheme
 * @property mixed $InsuranceAmount
 * @property mixed $CashAmount
 * @property mixed $MpesaReference
 * @property mixed $MpesaAmount
 * @property mixed $MpesaNumber
 * @property mixed $paybil
 * @property mixed $account
 * @property mixed $ChequeName
 * @property mixed $ChequeAmount
 * @property mixed $ChequeNumber
 * @property mixed $ChequeDate
 * @property mixed $ChequeBank
 * @property mixed $ChequeBankBranch
 * @property mixed $CardType
 * @property mixed $CardName
 * @property mixed $CardNumber
 * @property mixed $CardExpiry
 * @property mixed $CardSecurity
 * @property mixed $CardAmount
 * @property string $description
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Dervis\Modules\Reception\Entities\Patients $patients
 * @property-read \Dervis\Modules\Core\Entities\User $users
 * @property-read \Dervis\Modules\Setup\Entities\Schemes $schemes
 * @property-read mixed $total
 * @property-read mixed $modes
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereInsuranceAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCashAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereMpesaReference($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereMpesaAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereMpesaNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments wherePaybil($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereChequeName($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereChequeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereChequeNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereChequeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereChequeBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereChequeBankBranch($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCardType($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCardName($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCardNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCardExpiry($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCardSecurity($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCardAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dervis\Modules\Finance\Entities\PatientPayments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientPayments extends Model {

    //  public $primaryKey = 'patient_payments';

    public function patients() {
        return $this->belongsTo(\Dervis\Modules\Reception\Entities\Patients::class, 'patient', 'patient_id');
    }

    public function users() {
        return $this->belongsTo(\Dervis\Modules\Core\Entities\User::class, 'user', 'user_id');
    }

    public function schemes() {
        return $this->belongsTo(\Dervis\Modules\Setup\Entities\Schemes::class, 'scheme', 'scheme_id');
    }

    public function getTotalAttribute() {
        return $this->CardAmount + $this->CashAmount + $this->ChequeAmount + $this->MpesaAmount;
    }

    public function getModesAttribute() {
        $text = [];
        if (!empty($this->CashAmount))
            $text[] = "Cash - " . $this->CashAmount;
        if (!empty($this->MpesaAmount))
            $text[] = 'MPESA - ' . $this->MpesaAmount;
        if (!empty($this->CardAmount))
            $text[] = $this->CardType . ' - ' . $this->CardAmount;
        if (!empty($this->ChequeAmount))
            $text[] = 'Cheque - ' . $this->ChequeAmount;
        if (!empty($this->InsuranceAmount))
            $text[] = 'Insurance - ' . $this->InsuranceAmount;
        return $text;
    }

}
