<?php

namespace App\Repositories;

use App\Models\Publisher;

class PublisherRepository implements PublisherRepositoryInterface
{
    public function findOrCreatePublisher(string $name): Publisher
    {
        return Publisher::firstOrCreate(['name' => $name]);
    }
}
