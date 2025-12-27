<?php

return [
    'converterPrecision' => 2,
    'apiPrecision' => 6,
    'fixerCurrencyApi' => [
        'host' => 'https://data.fixer.io/api',
        'key' => env('FIXER_CURRENCY_API_KEY', null),
    ],
];
