<?php

namespace App\Repositories;

use App\Models\Publisher;

interface PublisherRepositoryInterface
{
    public function findOrCreatePublisher(string $name): Publisher;
}
