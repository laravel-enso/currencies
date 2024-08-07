<?php

namespace LaravelEnso\Currencies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Currencies\Exceptions\Currency as Exception;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Tables\Traits\TableCache;

class Currency extends Model
{
    use AvoidsDeletionConflicts, HasFactory, TableCache;

    protected $guarded = ['id'];

    public function fromExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'from_id');
    }

    public function toExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'to_id');
    }

    public function countries()
    {
        return $this->hasMany(Country::class, 'currency_code', 'code');
    }

    public function scopeDefault($query)
    {
        return $query->whereIsDefault(true);
    }

    public function scopeForeign($query)
    {
        return $query->whereIsDefault(false);
    }

    protected static function booted()
    {
        static::creating(fn ($currency) => $currency->fillDefault());
        static::deleting(fn ($currency) => $currency->checkDefault());
    }

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    private function fillDefault()
    {
        $this->is_default = ! self::query()->default()->exists();
    }

    private function checkDefault()
    {
        if ($this->is_default && self::count() > 1) {
            throw Exception::cannotDeleteDefault();
        }
    }
}
