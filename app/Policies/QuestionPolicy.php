<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy
{
    public function update(User $user, Question $question): bool
    {
        return $question->user_id === $user->id;
    }

    public function delete(User $user, Question $question): bool
    {
        return $question->user_id === $user->id;
    }
}
