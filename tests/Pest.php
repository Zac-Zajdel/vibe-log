<?php

declare(strict_types=1);
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

pest()
    ->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature', 'Unit');

beforeAll(function () {
    Http::preventStrayRequests();
});

TestResponse::macro('assertSuccess', function (int $status = Response::HTTP_OK, ?string $message = null, ?array $json = []) {
    /** @var TestResponse $this */
    $this
        ->assertStatus($status)
        ->assertJson([
            'status' => 'success',
            'message' => $message ?? true,
        ]);

    if ($json) {
        $this->assertJsonPath(
            'data',
            fn ($data) => $this->recursiveMatch($data, $json),
        );
    }

    return $this;
});

TestResponse::macro('recursiveMatch', function ($actual, $expected) {
    return collect($expected)->every(function ($value, $key) use ($actual) {
        $actualValue = data_get($actual, $key);

        if (is_array($value)) {
            return $this->recursiveMatch($actualValue, $value);
        }

        return $actualValue === $value;
    });
});
