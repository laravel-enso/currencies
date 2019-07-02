<?php

namespace LaravelEnso\Currencies\app\Observers;

use LaravelEnso\Currencies\app\Models\Currency;
use LaravelEnso\Currencies\app\Exceptions\CurrencyException;

class Observer
{
    public function creating(Currency $currency)
    {
        $currency->is_default = Currency::default()->first() === null;
    }

    public function updating(Currency $currency)
    {
        if ($currency->is_default) {
            DB::startTransaction();
            Currency::where('id', '<>', $currency->id)
                ->update(['is_default' => false]);
        }
    }

    public function updated(Currency $currency)
    {
        if ($currency->is_default) {
            DB::endTransaction();
        }
    }

    public function deleting(Currency $currency)
    {
        if ($currency->is_default && Currency::count() > 1) {
            throw new CurrencyException('You cannot delete the default currency!');
        }
    }
}