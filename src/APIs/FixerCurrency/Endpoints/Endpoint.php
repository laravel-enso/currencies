<?php

namespace LaravelEnso\Currencies\APIs\FixerCurrency\Endpoints;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Api\Contracts\Endpoint as Contract;
use LaravelEnso\Api\Enums\Methods;

abstract class Endpoint implements Contract
{
    abstract public function path(): string;

    abstract public function params(): array;

    public function method(): string
    {
        return Methods::get;
    }

    public function url(): string
    {
        $baseUrl = Config::get('enso.currencies.fixerCurrencyApi.host');

        return Collection::wrap([$baseUrl, $this->path()])
            ->filter()
            ->implode('/');
    }

    public function body(): array
    {
        return $this->params() +
            ['access_key' => Config::get('enso.currencies.fixerCurrencyApi.key')];
    }
}
