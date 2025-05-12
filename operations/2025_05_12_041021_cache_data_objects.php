<?php

declare(strict_types=1);

use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation
{
    public function __invoke(): void
    {
        $this->artisan('data:cache-structures');
    }

    public function shouldOnce(): bool
    {
        return false;
    }
};
