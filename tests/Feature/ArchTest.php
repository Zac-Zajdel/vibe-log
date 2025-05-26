<?php

declare(strict_types=1);

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Resource;

arch()
    ->preset()
    ->laravel()
    ->ignoring([
        'App\Providers\TelescopeServiceProvider',
        'Laravel\Telescope\TelescopeServiceProvider',
        '*TelescopeServiceProvider*',
    ]);

test('Strict Types')
    ->expect('App')
    ->toUseStrictTypes();

test('Data Request')
    ->expect('App\Data\Request')
    ->toExtend(Data::class);

test('Data Resource')
    ->expect('App\Data\Resource')
    ->toExtend(Resource::class);
