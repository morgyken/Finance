<?php

namespace Ignite\Finance\Entities;

use Ignite\Settings\Entities\Insurance;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;


class Copay extends Model
{
    protected $table = 'finance_copay';
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Insurance::class, 'company_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Schemes::class, 'scheme_id');
    }

    public function getDescAttribute()
    {
        return strtoupper('COPAY ' . substr($this->company->name, 0, 4) . '-' . substr($this->scheme->name, 0, 4));
    }
}
