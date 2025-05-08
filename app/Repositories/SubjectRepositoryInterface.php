<?php

namespace App\Repositories;

use App\Models\Subject;

interface SubjectRepositoryInterface
{
    public function findOrCreateSubject(string $name): Subject;

    public function delete(Subject $subject): bool;
}
