<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\FinanceSmartExchangeFiles
 *
 * @property int $id
 * @property string $Global_ID
 * @property string $Member_Nr
 * @property int $Admit_ID
 * @property int $Progress_Flag
 * @property string|null $Rejection_Reason
 * @property int $Exchange_Type
 * @property int $InOut_Type
 * @property string $Location_ID
 * @property string $Smart_Date
 * @property mixed $Smart_File
 * @property string $Exchange_Date
 * @property mixed $Exchange_File
 * @property string $Result_Date
 * @property mixed $Result_File
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereAdmitID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereExchangeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereExchangeFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereExchangeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereGlobalID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereInOutType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereLocationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereMemberNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereProgressFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereResultDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereResultFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereSmartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereSmartFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\FinanceSmartExchangeFiles whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinanceSmartExchangeFiles extends Model
{
    protected $guarded = [];
    protected $table = 'finance_smart_exchange_files';
}
