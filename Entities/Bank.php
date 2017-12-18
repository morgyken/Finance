<?php

namespace Ignite\Finance\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Finance\Entities\Bank
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Finance\Entities\Bank whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bank extends Model {

    protected $fillable = [];
    public $table = 'finance_banks';

}
