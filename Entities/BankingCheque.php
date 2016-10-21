<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\BankingCheque
 *
 * @property integer $id
 * @property integer $banking
 * @property string $holder_name
 * @property string $cheque_number
 * @property string $cheque_date
 * @property string $bank
 * @property string $branch
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereBanking($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereHolderName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereChequeNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereChequeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereBranch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\BankingCheque whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BankingCheque extends Model {

    protected $fillable = [];
    protected $table = 'finance_banking_cheques';

}
