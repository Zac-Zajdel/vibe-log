<?php

declare(strict_types=1);

arch()->preset()->laravel();

test('Strict Types')
    ->expect('App')
    ->toUseStrictTypes();

// test('Data')
//     ->expect('App\Data')
//     ->toHaveSuffix('Data');

// test('Data Request')
//     ->expect('App\Data\Request')
//     ->toExtend(\Spatie\LaravelData\Data::class);

// test('Data Resource')
//     ->expect('App\Data\Resource')
//     ->toExtend(\Spatie\LaravelData\Resource::class);

// test('Data Transfer')
//     ->expect('App\Data\Transfer')
//     ->toExtend(\Spatie\LaravelData\Dto::class);
