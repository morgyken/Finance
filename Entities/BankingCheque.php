<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\BankingCheque
 *
 * @property int $id
 * @property int $banking
 * @property string $holder_name
 * @property string $cheque_number
 * @property string $cheque_date
 * @property string $bank
 * @property string $branch
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereBanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereChequeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereChequeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\BankingCheque whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BankingCheque extends Model {

    protected $fillable = [];
    protected $table = 'finance_banking_cheques';

}
