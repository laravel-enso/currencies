<?php

namespace LaravelEnso\Currencies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Tables\Traits\TableCache;

class ExchangeRate extends Model
{
    use AvoidsDeletionConflicts, HasFactory, TableCache;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function from()
    {
        return $this->belongsTo(Currency::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(Currency::class, 'to_id');
    }
}
