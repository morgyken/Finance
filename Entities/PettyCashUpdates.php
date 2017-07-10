<?php

namespace Ignite\Finance\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\PettyCashUpdates
 *
 * @property int $id
 * @property int $user
 * @property float|null $amount
 * @property string $type
 * @property string|null $reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\PettyCashUpdates whereUser($value)
 * @mixin \Eloquent
 */
class PettyCashUpdates extends Model {

    protected $fillable = [];
    public $table = 'finance_petty_cash_updates';

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
