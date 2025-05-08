<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function findOrCreateSubject(string $name): Subject
    {
        return Subject::firstOrCreate(['name' => $name]);
    }

    public function delete(Subject $subject): bool
    {
        return $subject->delete();
    }
}
