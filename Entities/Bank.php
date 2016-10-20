<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Finance\Entities\Bank
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Bank whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Bank whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Finance\Entities\Bank whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bank extends Model {

    protected $fillable = [];
    public $table = 'finance_banks';

}
