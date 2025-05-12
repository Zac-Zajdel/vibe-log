<?php

declare(strict_types=1);

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Resource;

arch()->preset()->laravel();

test('Strict Types')
    ->expect('App')
    ->toUseStrictTypes();

test('Data')
    ->expect('App\Data')
    ->toHaveSuffix('Data');

test('Data Request')
    ->expect('App\Data\Request')
    ->toExtend(Data::class);

test('Data Resource')
    ->expect('App\Data\Resource')
    ->toExtend(Resource::class);

test('Data Transfer')
    ->expect('App\Data\Transfer')
    ->toExtend(Dto::class);
